<?php

namespace App\Http\Controllers\Api\v1\Wallet;

use App\Models\Card;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Services\WalletService;
use App\Traits\FileUploadTrait;
use App\Http\Requests\CardRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Notifications\SendNotification;

class CardController extends Controller
{
    use ApiStatusTrait, FileUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cards = Card::where('user_id', auth()->user()->id)->get();

        foreach ($cards as $card) {
            // Decrypt card details
            $card->card_number = decrypt($card->card_number);
            $card->cvv = null;
            $card->expiry_month = decrypt($card->expiry_month);
            $card->expiry_year = decrypt($card->expiry_year);

            // Mask card number, keeping only the last five digits
            $maskedCardNumber = '************' . substr($card->card_number, -5);
            $card->card_number = $maskedCardNumber;
        }

        return $this->success(['cards' => $cards], "All Card details");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CardRequest $request)
    {
        $user = auth()->user();

        if ($request->card_id != null) {
            $card = Card::where(['id' => $request->card_id, 'user_id' => $user->id])->first();

            if (!$card) {
                return $this->error(null, 'Card details not found', 422);
            }

            $authtoken = $card->auth_token;
            $secretkey = Setting::where('slug', 'secretkey')->first()->value;

            $url = "https://api.paystack.co/transaction/charge_authorization";

            // Define the request data
            $data = [
                'email' => $user->email,
                'amount' => $request->amount * 100, // Convert amount to kobo
                'authorization_code' => $authtoken,
            ];

            // Set the request headers
            $headers = [
                "Authorization" => "Bearer $secretkey",
                "Cache-Control" => "no-cache",
            ];

            // Send the POST request using Laravel's HTTP client
            $response = Http::withHeaders($headers)->post($url, $data);

            // Get the response content
            $result = $response->json();

            if ($result['status'] == true) {
                $data = $result['data'];
                DB::beginTransaction();
               try {
                    // Update wallet and create wallet history using WalletService
                    WalletService::updateWallet($user, [
                        'amount' => $data['amount'] / 100, // Convert amount back to Naira
                        'type' => 'deposit',
                        'payment_type' => 'paystack',
                        'description' => 'Paystack deposit via wallet',
                        'fee' => $data['fees'] / 100,
                        'reference' => $data['reference'],
                    ]);

                    // Update card details
                    $card->auth_token = $data['authorization']['authorization_code'];
                    $card->customer_code = $data['customer']['customer_code'];
                    $card->save();

                    DB::commit();

                    return $this->success($card, "Card charged successfully");
               } catch (\Exception $e) {
                   DB::rollBack();
                    return $this->error(null, 'Error processing the transaction', 500);
                }
            } else {
                return $this->error(null, 'Error charging card', 422);
            }
        } else {
            // Hash card number for comparison
            $hashedCardNumber = hash('sha256', $request->input('card_number'));

            // Check if the card already exists
            $existingCard = Card::where([
                ['user_id', '=', $user->id],
                ['card_hash', '=', $hashedCardNumber],
            ])->first();

            if ($existingCard) {
                return $this->error(null, 'This card is already saved', 422);
            }

            $encryptedCard = new Card;
            $encryptedCard->user_id = $user->id;
            $encryptedCard->type = $request->input('type');
            $encryptedCard->card_number = encrypt($request->input('card_number'));
            $encryptedCard->card_hash = $hashedCardNumber;
            $encryptedCard->cvv = encrypt($request->input('cvv'));
            $encryptedCard->name_on_card = $request->input('name_on_card');
            $encryptedCard->expiry_month = encrypt($request->input('expiry_month'));
            $encryptedCard->expiry_year = encrypt($request->input('expiry_year'));

            if ($encryptedCard->save()) {
                $message = "Your Card details were saved successfully. Thank you for trusting us";
                $user->notify(new SendNotification($user, $message));

                $publickey = Setting::where('slug', 'publickey')->first()->value;

                return $this->success(['card' => $encryptedCard, "public_key" => $publickey], "Card details saved successfully");
            } else {
                return $this->error(null, 'Error saving card details', 422);
            }
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $card = Card::findOrFail($id);

        // Decrypt sensitive card information
        $card->card_number = decrypt($card->card_number);
        $card->cvv = decrypt($card->cvv);
        $card->expiry_month = decrypt($card->expiry_month);
        $card->expiry_year = decrypt($card->expiry_year);

        // Mask card number, keeping only the last five digits
        $maskedCardNumber = '************' . substr($card->card_number, -5);
        $card->card_number = $maskedCardNumber;

        return $this->success(['card' => $card], "Card details");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CardRequest $request, $id)
    {
        $encryptedCard = Card::where(['user_id' => auth()->user()->id, 'id' => $id])->first();

        // Update card data
        $encryptedCard->user_id = auth()->user()->id;
        $encryptedCard->type = $request->input('type');
        $encryptedCard->card_number = encrypt($request->input('card_number'));
        $encryptedCard->cvv = encrypt($request->input('cvv'));
        $encryptedCard->name_on_card = $request->input('name_on_card');
        $encryptedCard->expiry_month = encrypt($request->input('expiry_month'));
        $encryptedCard->expiry_year = encrypt($request->input('expiry_year'));

        if ($encryptedCard->save()) {
            return $this->success(['card' => $encryptedCard], "Card details updated successfully");
        } else {
            return $this->error(null, 'Error updating card details', 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $encryptedCard = Card::where(['user_id' => auth()->user()->id, 'id' => $id])->first();

        if (!$encryptedCard) {
            return $this->error(null, 'Card not found', 404);
        }

        if ($encryptedCard->delete()) {
            return $this->success(null, "Card deleted successfully");
        } else {
            return $this->error(null, 'Error deleting card', 422);
        }
    }

    public function payWithExistingCard(Request $request)
    {
        $this->validate($request, [
            "card_id" => 'required|exists:cards,id',
            "transaction_type" => 'required|in:deposit,withdraw,transfer',
            "amount" => 'required|numeric|min:1',
        ]);

        $card = Card::where(['user_id' => auth()->user()->id, 'id' => $request->card_id])->first();

        if (!$card) {
            return $this->error(null, 'Card details not found', 422);
        }

        $authtoken = $card->auth_token;
        $secretkey = Setting::where('slug', 'secretkey')->first()->value;

        $url = "https://api.paystack.co/transaction/charge_authorization";

        // Define the request data
        $data = [
            'email' => auth()->user()->email,
            'amount' => $request->amount * 100, // Convert amount to kobo
            'authorization_code' => $authtoken,
        ];

        // Set the request headers
        $headers = [
            "Authorization" => "Bearer $secretkey",
            "Cache-Control" => "no-cache",
        ];

        // Send the POST request using Laravel's HTTP client
        $response = Http::withHeaders($headers)->post($url, $data);

        // Get the response content
        $result = $response->json();

        if ($result['status'] == true) {
            $data = $result['data'];
            $user = auth()->user();

            DB::beginTransaction();
            try {
                // Update wallet and create wallet history using WalletService
                WalletService::updateWallet($user, [
                    'amount' => $data['amount'] / 100, // Convert amount back to Naira
                    'type' => $request->transaction_type,
                    'payment_type' => 'paystack',
                    'description' => 'Paystack ' . $request->transaction_type . ' via wallet',
                    'fee' => $data['fees'] / 100,
                    'reference' => $data['reference'],
                ]);

                DB::commit();

                return $this->success($card, "Card charged successfully");
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->error(null, 'Error processing the transaction', 500);
            }
        } else {
            return $this->error(null, 'Error charging card', 422);
        }
    }
}
