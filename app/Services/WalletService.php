<?php
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletHistory;
use Illuminate\Support\Facades\DB;

class WalletService
{
    public static function createWalletAndHistory(User $user, $data)
    {
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
            return $wallet;
        }
    }
}



?>
