<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Models\WalletHistory;
use App\Http\Controllers\Controller;
use App\Http\Resources\WalletResource;
use App\Http\Resources\WalletHistoryResource;

class WalletController extends Controller
{
    public function index(Request $request)
    {
        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);
        $wallet = Wallet::where(function ($q) use ($key) {
            $q->whereHas('user', function ($userQuery) use ($key) {
                $userQuery->where('full_name', 'like', "%{$key}%");
            })->orWhere('status', 'like', "%{$key}%")->orWhere('nin_number', 'like', "%{$key}%");
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
                $userQuery->where('full_name', 'like', "%{$key}%");
            })->orWhere('status', 'like', "%{$key}%")->orWhere('nin_number', 'like', "%{$key}%");
        })
            ->latest()
            ->paginate($perPage);

        return $this->success(['walletHistory' => WalletHistoryResource::collection($walletHistory)], "Wallet History details");

    }
}
