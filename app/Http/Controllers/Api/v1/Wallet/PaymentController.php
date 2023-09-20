<?php

namespace App\Http\Controllers\Api\v1\Wallet;

use App\Models\Card;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Models\WalletHistory;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{

    public function webhooks(Request $request)
    {

        if ($request['event'] == 'charge.success') {
            $data = $request['data'];
            $user = User::where('email', $data['customer']['email'])->first();

            if ($user) {
                if ($user->wallet) {
                    // Update the existing wallet
                    $user->wallet->update([
                        "amount" => $user->wallet->amount + ($data['amount'] / 100),
                        "status" => "success",
                    ]);
                } else {
                    // Create a new wallet
                    $wallet = new Wallet;
                    $wallet->amount = $data['amount'] / 100;
                    $wallet->status = 'success';
                    $wallet->user_id = $user->id;
                    $wallet->save();
                }

                // Create a wallet history entry
                $walletHistory = new WalletHistory;
                $walletHistory->wallet_id = $user->wallet->id;
                $walletHistory->type = "deposit";
                $walletHistory->payment_type = "paystack";
                $walletHistory->amount = $data['amount'] / 100;

                $walletHistory->closing_balance = $user->wallet->amount;
                $walletHistory->fee = $data['fee'];
                $walletHistory->description = "Paystack deposit";

                $walletHistory->save();

                //$last4Digits = substr($cardNumber, -4);

                $card = Card::where('user_id', $user->id)
               // ->where('bin', $request->input('bin'))
               // ->where('last4', $request->input('last4'))
                ->first();

                if($card){
                $card->auth_token =  $data['authorization']['authorization_code'];
                $card->customer_code = $data['customer']['customer_code'];

                $card->save();
            }
            }
        }
        http_response_code(200);

        return response()->json(['message' => 'Webhook received successfully'], 200);
    }

}
