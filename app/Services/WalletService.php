<?php

namespace App\Services;


use App\Models\User;
use App\Models\Wallet;
use App\Models\KycLimit;
use App\Models\WalletHistory;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use App\Notifications\WalletActivityNotification;

class WalletService
{

    use FileUploadTrait, ApiStatusTrait;

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

            $message = "Your wallet has been successfully updated. New balance: " . $user->wallet->amount;
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

            // Check if the wallet status is active
            if ($wallet->status !== 'active') {
                throw new \Exception('Wallet is not active. Please contact support.');
            }

            // Fetch the user's KYC level and the corresponding limits
            $kycLevel = $user->kyc_level;
           $kycLimit = KycLimit::where('kyc_level', $kycLevel)->firstOrFail();

            // Calculate the new wallet amount
            $newAmount = ($data['type'] === 'credit' || $data['type'] === 'deposit') ? $wallet->amount + $data['amount'] : $wallet->amount - $data['amount'];

            // Validate the transaction amount based on KYC level limits
            if ($newAmount < 0) {
                throw new \Exception('Insufficient funds in wallet');
            }
            if ($data['amount'] < $kycLimit->min_limit || $data['amount'] > $kycLimit->max_limit) {
                throw new \Exception('Transaction amount must be between ' . $kycLimit->min_limit . ' and ' . $kycLimit->max_limit . ' based on your KYC level');
            }

            // Update wallet amount
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
