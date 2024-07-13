<?php

namespace App\Http\Controllers\Api\v1\Wallet;

use Illuminate\Http\Request;
use App\Services\NombaService;
use App\Services\PayStackService;
use App\Http\Controllers\Controller;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;

class BankController extends Controller
{
    use ApiStatusTrait, FileUploadTrait;

    private $nombaService;
    private $payStackService;

    public function __construct(NombaService $nombaService, PayStackService $payStackService)
    {
        $this->nombaService = $nombaService;
        $this->payStackService = $payStackService;
    }

    public function list(Request $request)
    {
        $service = $this->determineService($request);

        return $service->bankList();
    }

    public function lookup(Request $request)
    {
        $validatedData = $request->validate([
            'accountNumber' => 'required|numeric',
            'bankCode' => 'required|string',
        ]);

        $service = $this->determineService($request);

        return $service->bankLookUp($validatedData['accountNumber'], $validatedData['bankCode']);
    }

    public function submit(Request $request)
    {
        $service = $this->determineService($request);

        return $service->submit($request);
    }

    public function finalizeTransfer(Request $request)
    {
        $service = $this->determineService($request);

        return $service->finalizeTransfer($request);
    }

    public function getTransferByCode(Request $request, $transferCode)
    {
        $service = $this->determineService($request);

        return $service->getTransferDetailsByCode($transferCode);
    }

    public function getTransferByReference(Request $request, $reference)
    {
        $service = $this->determineService($request);

        return $service->getTransferDetailsByReference($reference);
    }

    public function resendOtp(Request $request)
    {
        $validatedData = $request->validate([
            'transferCode' => 'required|string',
            'reason' => 'required|string',
        ]);

        $service = $this->determineService($request);

        return $service->resendOtp($validatedData['transferCode'], $validatedData['reason']);
    }

    public function disableOtp(Request $request)
    {
        $service = $this->determineService($request);

        return $service->disableOtp();
    }

    public function disableOtpFinalize(Request $request)
    {
        $validatedData = $request->validate([
            'otp' => 'required|numeric',
        ]);

        $service = $this->determineService($request);

        return $service->disableOtpFinalize($validatedData['otp']);
    }


    public function enableOtp(Request $request)
    {
        $service = $this->determineService($request);

        return $service->enableOtp();
    }

    private function determineService(Request $request)
    {
        $routeName = $request->route()->getName();

        if (str_contains($routeName, 'nomba')) {
            return $this->nombaService;
        }

        if (str_contains($routeName, 'paystack')) {
            return $this->payStackService;
        }

        throw new \Exception('Service not found.');
    }
}
