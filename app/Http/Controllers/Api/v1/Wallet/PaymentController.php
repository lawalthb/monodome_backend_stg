<?php

namespace App\Http\Controllers\Api\v1\Wallet;

use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{

    public function webhooks(Request $request)
    {
        Log::info($request);

        if ($request['event'] == 'charge.success') {
            $data = $request['data'];
            $user = User::where('email', $data['customer']['email'])->first();

            if ($user) {
                if ($user->wallet) {
                    // Update the existing wallet
                    $user->wallet->update([
                        "amount" => $user->wallet->amount + ($data['amount'] / 100), // Add to the current amount
                        "status" => "success",
                    ]);
                } else {
                    // Create a new wallet
                    $wallet = new Wallet;
                    $wallet->amount = $data['amount'] / 100;
                    $wallet->status = 'success';
                    $wallet->user_id = $user->id; // Make sure to associate the wallet with the user
                    $wallet->save(); // Save the new wallet to the database
                }

                // Create a wallet history entry
                $walletHistory = new WalletHistory;
                $walletHistory->wallet_id = $user->wallet->id;
                $walletHistory->type = "deposit";
                $walletHistory->payment_type = "paystack";
                $walletHistory->amount = $data['amount'] / 100;

                $walletHistory->closing_balance = $user->wallet->amount; // Use the updated wallet balance here
                $walletHistory->fee = $data['fee']; // Set the actual fee value here
                $walletHistory->description = "Paystack deposit";

                $walletHistory->save();
            }
        }
        http_response_code(200);

        return response()->json(['message' => 'Webhook received successfully'], 200);
    }

}
