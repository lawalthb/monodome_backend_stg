<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use App\Services\WalletService;
use Illuminate\Support\Str;

class PayStackService
{
    private $secretKey;

    public function __construct()
    {
        $this->secretKey = Setting::where('slug', 'secretkey')->first()->value;
    }

    public function bankList()
    {
        $response = Http::withToken($this->secretKey)->get('https://api.paystack.co/bank', [
            'currency' => 'NGN'
        ]);

        return $response->successful() ? $response->json() : $response->json();
    }

    public function bankLookUp($accountNumber, $bankCode)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->secretKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.paystack.co/transferrecipient', [
            'type' => 'nuban',
            'name' => auth()->user()->full_name,
            'account_number' => $accountNumber,
            'bank_code' => $bankCode,
            'currency' => 'NGN',
        ]);

        return $response->successful() ? $response->json() : response()->json(['error' => 'Failed to create transfer recipient'], $response->status());
    }

    public function submit($request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'recipient' => 'required|string',
            'reason' => 'nullable|string',
        ]);

        $user = auth()->user();
        $wallet = $user->wallet;

        if ($wallet->amount < $request->amount) {
            return response()->json(['error' => 'Insufficient funds in wallet'], 400);
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->secretKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.paystack.co/transfer', [
            'source' => 'balance',
            'amount' => $request->amount * 100,
            'reference' => Str::uuid(),
            'recipient' => $request->recipient,
            'reason' => $request->reason,
        ]);

        if ($response->successful()) {
            if ($response['data']['status'] == "otp") {
                return $response->json();
            }

            // Deduct the amount from the user's wallet
            WalletService::updateWallet($user, [
                'amount' => $request->amount,
                'type' => 'debit',
                'payment_type' => 'wallet',
                'description' => 'Transfer to recipient',
                'fee' => 0,
            ]);

            return response()->json(['message' => 'Transfer has been queued', 'data' => $response->json()]);
        } else {
            return response()->json(['error' => 'Failed to initiate transfer'], $response->status());
        }
    }

    public function finalizeTransfer($request)
    {
        $validated = $request->validate([
            'otp' => 'required|numeric|min:1',
            'transferCode' => 'required|string',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->secretKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.paystack.co/transfer/finalize_transfer', [
            'transfer_code' => $request->transferCode,
            'otp' => $request->otp,
        ]);

        if ($response->successful()) {
            $user = auth()->user();
            $transferAmount = $this->getTransferAmount($request->transferCode);

            // Deduct the amount from the user's wallet
            WalletService::updateWallet($user, [
                'amount' => $transferAmount / 100, // Amount is in kobo, convert to Naira
                'type' => 'debit',
                'payment_type' => 'wallet',
                'description' => 'Transfer to recipient',
                'fee' => 0,
            ]);

            return response()->json(['message' => 'Transfer finalized successfully', 'data' => $response->json()]);
        } else {
            return response()->json(['error' => 'Failed to finalize transfer'], $response->status());
        }
    }

    public function getTransferDetailsByCode($transferCode)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->secretKey,
            'Content-Type' => 'application/json',
        ])->get('https://api.paystack.co/transfer/' . $transferCode);

        if ($response->successful()) {
            return $response->json();
        } else {
            throw new \Exception('Failed to retrieve transfer details by code');
        }
    }

    public function getTransferDetailsByReference($reference)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->secretKey,
            'Content-Type' => 'application/json',
        ])->get('https://api.paystack.co/transfer/verify/' . $reference);

        if ($response->successful()) {
            return $response->json();
        } else {
            throw new \Exception('Failed to retrieve transfer details by reference');
        }
    }

    private function getTransferAmount($transferCode)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->secretKey,
            'Content-Type' => 'application/json',
        ])->get('https://api.paystack.co/transfer/' . $transferCode);

        if ($response->successful()) {
            $data = $response->json();
            return $data['data']['amount'];
        }

        throw new \Exception('Failed to retrieve transfer amount');
    }

    // New Methods
    public function resendOtp($transferCode, $reason)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->secretKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.paystack.co/transfer/resend_otp', [
            'transfer_code' => $transferCode,
            'reason' => $reason,
        ]);

        return $response->successful() ? $response->json() : response()->json(['error' => 'Failed to resend OTP'], $response->status());
    }

    public function disableOtp()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->secretKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.paystack.co/transfer/disable_otp');

        return $response->successful() ? $response->json() : response()->json(['error' => 'Failed to disable OTP'], $response->status());
    }

    public function disableOtpFinalize($otp)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->secretKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.paystack.co/transfer/disable_otp_finalize', [
            'otp' => $otp,
        ]);

        return $response->successful() ? $response->json() : response()->json(['error' => 'Failed to finalize OTP disable'], $response->status());
    }
}
