<?php

namespace App\Http\Controllers\Api\v1\Wallet;

use App\Models\Card;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Services\NombaService;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use App\Http\Requests\CardRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Notifications\SendNotification;

class BankController extends Controller
{

    use ApiStatusTrait, FileUploadTrait;

    public function __construct(private NombaService $nombaService){

    }

    public function list()
    {

       return $this->nombaService->bankList();

    }

    public function lookup(Request $request)
    {

        $validatedData = $request->validate([
            'accountNumber' => 'required|numeric',
            'bankCode' => 'required|string',
        ]);

        return $this->nombaService->bankLookUp($request->accountNumber, $request->bankCode);

    }

    public function submit(Request $request)
    {

        $validatedData = $request->validate([
            'amount' => 'required|numeric',
            'accountNumber' => 'required|numeric',
            'bankCode' => 'required|string',
            'accountName' => 'required|string',
            'merchantTxRef' => 'required|string',
            'senderName' => 'required|string',
            'pin' => 'required|numeric',
        ]);

        return $this->nombaService->submit($request);

    }



}
