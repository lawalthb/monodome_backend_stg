<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Models\WalletHistory;
use App\Traits\ApiStatusTrait;
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

        $wallet = Wallet::findOrFail($id);
        $wallet->amount += $request->input('amount');
        $wallet->save();

        // Record the transaction in wallet history
        WalletHistory::create([
            'user_id' => $wallet->user_id,
            'wallet_id' => $wallet->id,
            'type' => 'topup',
            'payment_type' => 'wallet',
            'amount' => $request->input('amount'),
            'closing_balance' => $wallet->amount,
            'fee' => 0,
            'description' => 'Wallet top-up',
        ]);

        return $this->success(new WalletResource($wallet), "Wallet balance topped up successfully");
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

}
