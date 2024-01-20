<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Models\WalletHistory;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\WalletResource;
use App\Http\Resources\WalletHistoryResource;

class WalletController extends Controller
{

    use ApiStatusTrait,FileUploadTrait;

    public function index(Request $request)
    {
        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);
        $wallet = Wallet::where(function ($q) use ($key) {
            $q->whereHas('user', function ($userQuery) use ($key) {
                $userQuery->where('full_name', 'like', "%{$key}%")->orWhere('phone_number', 'like', "%{$key}%");
            })->orWhere('status', 'like', "%{$key}%");
        })
            ->latest()
            ->paginate($perPage);

            $totalAmount = $wallet->sum('amount');
             return $this->success([
                 'wallet' => WalletResource::collection($wallet),
                 'total_amount' => $totalAmount],
                 "Wallet Dashboard details"
                );
    }

    public function wallet_history(Request $request){

        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $walletHistory = WalletHistory::where(function ($q) use ($key) {
            $q->whereHas('user', function ($userQuery) use ($key) {
                $userQuery->where('full_name', 'like', "%{$key}%")->orWhere('phone_number', 'like', "%{$key}%");
            })->orWhere('status', 'like', "%{$key}%");
        })
            ->latest()
            ->paginate($perPage);

            $totalAmount = $walletHistory->sum('amount');
            $totalFee = $walletHistory->sum('fee');
            $totalCloseBalance = $walletHistory->sum('closing_balance');

        return $this->success([
            'walletHistory' => WalletHistoryResource::collection($walletHistory),
            'total_walletHistory_amount' => $totalAmount,
            'total_walletHistory_fee' => $totalFee,
            'total_walletHistory_closeBalance' => $totalCloseBalance,
            ],
            "Wallet History details");

    }
}
