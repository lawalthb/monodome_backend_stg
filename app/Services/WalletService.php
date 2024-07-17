<?php

namespace App\Services;


use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletHistory;
use Illuminate\Support\Facades\DB;

class WalletService
{
    public static function createWalletAndHistory(User $user, $data)
    {
         $wallet = null;
        if ($user) {
            if ($user->wallet) {
                // Update the existing wallet
                $user->wallet->update([
                    "amount" => $user->wallet->amount +  $data['amount'],
                    "status" => "active",
                ]);

                // Create a wallet history entry
                $walletHistory = new WalletHistory;
                $walletHistory->wallet_id = $user->wallet->id;
                $walletHistory->user_id =  $user->id;
                $walletHistory->type =  $data['type'];
                $walletHistory->paystack_reference =  $data["reference"];
                $walletHistory->payment_type = $data['payment_type'];
                $walletHistory->amount = $data['amount'] / 100;
                $walletHistory->closing_balance = $user->wallet->amount;
                $walletHistory->fee = $data['fees'];
                $walletHistory->description =  $data['description'];
                $walletHistory->save();

            } else {
                // Create a new wallet
                $wallet = new Wallet;
                $wallet->amount =  $data['amount'];
                $wallet->status = 'active';
                $wallet->user_id = $user->id;
                $wallet->save();

                // Create a wallet history entry
                $walletHistory = new WalletHistory;
                $walletHistory->wallet_id = $wallet->id;
                $walletHistory->user_id = $user->id;
                $walletHistory->type =  $data['type'];
                $walletHistory->payment_type = $data['payment_type'];
                $walletHistory->amount = $data['amount'] / 100;
                $walletHistory->closing_balance = $wallet->amount;
                $walletHistory->fee = $data['fees'];
                $walletHistory->description =  $data['description'];
                $walletHistory->save();

            }
            DB::commit();

            $message = "Your wallet has been successfully updated. New balance: " . $wallet->amount;
            $user->notify(new WalletActivityNotification($message));


            return $wallet;
        }
    }



    public static function updateWallet(User $user, $data)
    {
        DB::beginTransaction();
        try {
            // Fetch or create the user's wallet
            $wallet = $user->wallet ?: new Wallet(['user_id' => $user->id, 'amount' => 0, 'status' => 'active']);

            // Update wallet amount
            $newAmount = ($data['type'] === 'credit' || $data['type'] === 'deposit') ? $wallet->amount + $data['amount'] : $wallet->amount - $data['amount'];
            if ($newAmount < 0) {
                throw new \Exception('Insufficient funds in wallet');
            }
            $wallet->amount = $newAmount;
            $wallet->save();

            // Create a wallet history entry
            $walletHistory = new WalletHistory;
            $walletHistory->wallet_id = $wallet->id;
            $walletHistory->user_id = $user->id;
            $walletHistory->type = $data['type'];
            $walletHistory->payment_type = $data['payment_type'];
            $walletHistory->amount = $data['amount'];
            $walletHistory->closing_balance = $wallet->amount;
            $walletHistory->fee = $data['fee'] ?? 0;
            $walletHistory->description = $data['description'];
            $walletHistory->paystack_reference = $data['reference'] ?? null;
            $walletHistory->save();

            DB::commit();

            $message = "There has been a wallet " . $data['type'] . ". New balance: " . $wallet->amount;
            $user->notify(new WalletActivityNotification($message));

            return $wallet;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}



?>
