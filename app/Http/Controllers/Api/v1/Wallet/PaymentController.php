<?php

namespace App\Http\Controllers\Api\v1\Wallet;

use App\Models\Card;
use App\Models\User;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Notifications\SendNotification;
use App\Services\WalletService;

class PaymentController extends Controller
{
    use ApiStatusTrait, FileUploadTrait;

    public function paystackWebhooks(Request $request)
    {
        http_response_code(200);

        if ((strtoupper($_SERVER['REQUEST_METHOD']) != 'POST') || !array_key_exists('HTTP_X_PAYSTACK_SIGNATURE', $_SERVER)) {
            exit();
        }

        $input = @file_get_contents("php://input");

        // Get the secret key from database and check if the hash is the same, else exit
        $secretkey = Setting::where(['slug' => 'secretkey'])->first()->value;
        if ($_SERVER['HTTP_X_PAYSTACK_SIGNATURE'] !== hash_hmac('sha512', $input, $secretkey)) {
            exit();
        }

        Log::info($request);

        if ($request['event'] == 'charge.success' && $request['data']['metadata']['custom_fields'][0]['from'] == 'wallet') {

            try {
                DB::beginTransaction();
                $data = $request['data'];
                $user = User::where('email', $data['customer']['email'])->first();
                if ($user) {
                    WalletService::updateWallet($user, [
                        'amount' => $data['amount'] / 100,
                        'type' => 'deposit',
                        'payment_type' => 'paystack',
                        'description' => 'Paystack deposit via wallet',
                        'reference' => $data['reference'],
                        'fee' => $data['fees'] / 100,
                    ]);

                    // Update card details if available
                    $card = Card::where('user_id', $user->id)->first();
                    if ($card) {
                        $card->auth_token = $data['authorization']['authorization_code'];
                        $card->customer_code = $data['customer']['customer_code'];
                        $card->save();
                    }
                }
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                Log::info($th->getMessage());
            }
        } elseif ($request['event'] == 'charge.success' && $request['data']['metadata']['custom_fields'][0]['from'] == 'order') {
            $id = $request['data']['metadata']['id'];
            $order = Order::find($id);
            Log::info($order);

            if ($order) {
                $order->update([
                    'payment_type' => 'online',
                    'payment_status' => 'Paid',
                ]);

                $order->user->notify(new SendNotification($order->user, 'Your Paystack online payment order was successful!'));
            }
        }

        http_response_code(200);
        return response()->json(['message' => 'Webhook received successfully'], 200);
    }

    public function nombaWebhooks(Request $request)
    {
        http_response_code(200);

        Log::info($request);

        if ($request->has('payload') && $request->has('event_type') && $request->has('data')) {
            $payload = $request->input('payload');
            $eventType = $payload['event_type'];
            $data = $payload['data'];

            if ($eventType == 'payment_success') {
                try {
                    DB::beginTransaction();

                    $user = User::where('email', $data['order']['customerEmail'])->first();

                    if ($user) {
                        WalletService::updateWallet($user, [
                            'amount' => $data['order']['amount'],
                            'type' => 'deposit',
                            'payment_type' => 'nomba',
                            'description' => 'Nomba deposit via wallet orderId ' . $data['order']['orderId'] . ' orderReference ' . $data['order']['orderReference'],
                            'reference' => $data['order']['orderId'],
                            'fee' => 0,
                        ]);

                        DB::commit();
                    }
                } catch (\Throwable $th) {
                    DB::rollBack();
                    Log::info($th->getMessage());
                }
            }
        }

        return response()->json(['message' => 'Webhook received'], 200);
    }
}
