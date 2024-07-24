<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\WalletHistory;
use App\Traits\ApiStatusTrait;
use App\Services\WalletService;
use App\Traits\FileUploadTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\WalletResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\WalletHistoryResource;

class WalletController extends Controller
{

    use ApiStatusTrait,FileUploadTrait;

    public function index(Request $request)
    {
        $key = $request->input('search');
        $status = $request->input('status');
        $minAmount = $request->input('min_amount');
        $maxAmount = $request->input('max_amount');
        $perPage = $request->input('per_page', 10);

        $wallet = Wallet::where(function ($q) use ($key, $status, $minAmount, $maxAmount) {
            if ($key) {
                $q->whereHas('user', function ($userQuery) use ($key) {
                    $userQuery->where('full_name', 'like', "%{$key}%")
                              ->orWhere('phone_number', 'like', "%{$key}%");
                })->orWhere('status', 'like', "%{$key}%");
            }
            if ($status) {
                $q->where('status', $status);
            }
            if ($minAmount) {
                $q->where('amount', '>=', $minAmount);
            }
            if ($maxAmount) {
                $q->where('amount', '<=', $maxAmount);
            }
        })
        ->latest()
        ->paginate($perPage);

        $totalAmount = $wallet->sum('amount');
        return $this->success([
            'total_amount' => $totalAmount,
            'wallet' => WalletResource::collection($wallet),
        ],
        "Wallet Dashboard details");
    }


    public function wallet_history(Request $request){

        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $walletHistory = WalletHistory::where(function ($q) use ($key) {
            $q->whereHas('user', function ($userQuery) use ($key) {
                $userQuery->where('full_name', 'like', "%{$key}%")->orWhere('phone_number', 'like', "%{$key}%");
            });
        })
            ->latest()
            ->paginate($perPage);

            $totalAmount = $walletHistory->sum('amount');
            $totalFee = $walletHistory->sum('fee');
            $totalCloseBalance = $walletHistory->sum('closing_balance');

        return $this->success([
            'total_walletHistory_amount' => $totalAmount,
            'total_walletHistory_fee' => $totalFee,
            'total_walletHistory_closeBalance' => $totalCloseBalance,
            'walletHistory' => WalletHistoryResource::collection($walletHistory),
            ],
            "Wallet History details");

    }

    public function update_pin(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'pin' => 'required|string|min:4|max:6',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), "Validation Error", 422);
        }

        $wallet = Wallet::findOrFail($id);
        $wallet->pin = $request->input('pin');
        $wallet->save();

        return $this->success(new WalletResource($wallet), "Wallet pin updated successfully");
    }

    public function topup_balance(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), "Validation Error", 422);
        }

        $user = User::findOrFail($id);
        $data = [
            'amount' => $request->input('amount'),
            'type' => 'topup',
            'payment_type' => 'wallet',
            'description' => 'Wallet top-up',
            'fees' => 0,
            'reference' => Str::uuid()
        ];

        WalletService::createWalletAndHistory($user, $data);

        return $this->success(new WalletResource($user->wallet), "Wallet balance topped up successfully");
    }

    public function update_wallet_status(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:Active,Inactive',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), "Validation Error", 422);
        }

        $wallet = Wallet::findOrFail($id);
        $wallet->status = $request->input('status');
        $wallet->save();

        $statusMessage = $wallet->status == 'Active' ? 'Wallet enabled successfully' : 'Wallet disabled successfully';

        return $this->success(new WalletResource($wallet), $statusMessage);
    }

    public function transfer_balance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from_wallet_id' => 'required|exists:wallets,id',
            'to_wallet_id' => 'required|exists:wallets,id',
            'amount' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), "Validation Error", 422);
        }

        $fromWallet = Wallet::findOrFail($request->input('from_wallet_id'));
        $toWallet = Wallet::findOrFail($request->input('to_wallet_id'));
        $amount = $request->input('amount');

        if ($fromWallet->amount < $amount) {
            return $this->error('', "Insufficient balance", 422);
        }

        WalletService::updateWallet($fromWallet->user, [
            'type' => 'debit',
            'amount' => $amount,
            'payment_type' => 'transfer',
            'description' => 'Transfer to wallet ID ' . $toWallet->id,
        ]);

        WalletService::updateWallet($toWallet->user, [
            'type' => 'credit',
            'amount' => $amount,
            'payment_type' => 'transfer',
            'description' => 'Transfer from wallet ID ' . $fromWallet->id,
        ]);

        return $this->success([], "Balance transferred successfully");
    }


    public function withdraw(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), "Validation Error", 422);
        }

        $user = User::findOrFail($id);
        $amount = $request->input('amount');

        WalletService::updateWallet($user, [
            'type' => 'debit',
            'amount' => $amount,
            'payment_type' => 'withdrawal',
            'description' => 'Wallet withdrawal',
        ]);

        return $this->success(new WalletResource($user->wallet), "Withdrawal successful");
    }



    public function wallet_statistics()
    {
        $totalUsers = User::count();
        $totalWallets = Wallet::count();
        $totalBalance = Wallet::sum('amount');

        // Calculate total credit and debit
        $totalCredit = WalletHistory::where('type', 'credit')->sum('amount');
        $totalDebt = WalletHistory::where('type', 'debit')->sum('amount');

        return $this->success([
            'total_users' => $totalUsers,
            'total_wallets' => $totalWallets,
            'total_balance' => $totalBalance,
            'total_credit' => $totalCredit,
            'total_debt' => $totalDebt,
        ], "Wallet statistics retrieved successfully");
    }

    public function list_all_wallets(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $wallets = Wallet::paginate($perPage);

        return $this->success(WalletResource::collection($wallets), "All wallets retrieved successfully");
    }

    /**
     * Get a single user's wallet and wallet history.
     *
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function userWalletAndHistory($userId)
    {
        // Fetch the user
        $user = User::findOrFail($userId);

        // Fetch the user's wallet
        $wallet = Wallet::where('user_id', $userId)->firstOrFail();

        // Fetch the user's wallet history
        $walletHistory = WalletHistory::where('user_id', $userId)->latest()->get();

        // Calculate total amounts for the wallet history
        $totalAmount = $walletHistory->sum('amount');
        $totalFee = $walletHistory->sum('fee');
        $totalCloseBalance = $walletHistory->sum('closing_balance');

        return $this->success([
            'wallet' => new WalletResource($wallet),
            'total_walletHistory_amount' => $totalAmount,
            'total_walletHistory_fee' => $totalFee,
            'total_walletHistory_closeBalance' => $totalCloseBalance,
            'walletHistory' => WalletHistoryResource::collection($walletHistory),
        ], "User wallet and wallet history details retrieved successfully");
    }
}
