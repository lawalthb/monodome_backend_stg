<?php
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletHistory;

class WalletService
{
    public static function createWalletAndHistory(User $user, $data)
    {
        // Create a new wallet
        $wallet = Wallet::create([
            'amount' => $data['amount'],
            'status' => 'active',
            'user_id' => $user->id,
        ]);

        // Create a wallet history entry
        WalletHistory::create([
            'wallet_id' => $wallet->id,
            'user_id' => $user->id,
            'type' => $data['type'],
            'payment_type' =>  $data['payment_type'],
            'amount' => $data['amount'],
            'closing_balance' => $wallet->amount,
            'fee' => $data['fees'],
            'description' => $data['description'],
        ]);

        return $wallet;
    }
}



?>
