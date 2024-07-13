<?php

namespace App\Services;


use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class NombaService
{


    public function  bankLookUp($accountNumber, $bankCode){

        $nomba = nombaAccessToken();

        $response = Http::withHeaders([
            'accountId' => $nomba["accountId"],
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$nomba["accessToken"],
        ])->post('https://api.nomba.com/v1/transfers/bank/lookup', [
            'accountNumber' => $accountNumber,
            'bankCode' => $bankCode,
        ]);

        // Assuming you want to retrieve the response as an array

       return $result = $response->json();

        if(isset($result['data']['checkoutLink']) && isset($result['data']['orderReference'])) {
            $checkoutLink = $result['data']['checkoutLink'];
            $orderReference = $result['data']['orderReference'];

            return [
                'status' => true,
                'checkoutLink' =>  $checkoutLink,
                'orderReference' => $orderReference
            ];
        }
        return null;

    }


    public function  bankList(){

        $nomba = nombaAccessToken();
        $response = Http::withHeaders([
            'accountId' => $nomba["accountId"],
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$nomba["accessToken"],
        ])->get('https://api.nomba.com/v1/transfers/banks');


       return  $response->json();

    }

    public function  submit($request){

        $validatedData = $request->validate([
            'amount' => 'required|numeric',
            'accountNumber' => 'required|numeric',
            'bankCode' => 'required|string',
            'accountName' => 'required|string',
            'merchantTxRef' => 'required|string',
            'senderName' => 'required|string',
            'pin' => 'required|numeric',
        ]);

        $nomba = nombaAccessToken();

        $response = Http::withHeaders([
            'accountId' => $nomba["accountId"],
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$nomba["accessToken"],
        ])->post('https://api.nomba.com/v1/transfers/bank', [
            "amount"=> $request->amount,
            "accountNumber"=> $request->accountNumber,
            "accountName"=> $request->accountName,
            "bankCode"=> $request->bankCode,
            "merchantTxRef"=> $request->merchantTxRef,
            "senderName"=> $request->senderName,
            "pin"=> $request->pin
        ]);

        return  $response->json();

    }
}
