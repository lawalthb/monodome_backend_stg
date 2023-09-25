<?php

namespace App\Http\Controllers\Api\v1\Wallet;

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
    use ApiStatusTrait, FileUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wallet = Wallet::where('user_id', auth()->user()->id)->get();

        return $this->success(['wallet' => WalletResource::collection($wallet)], "Wallet Dashboard details");

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function wallet_history(){

        $walletHistory = WalletHistory::where('user_id', auth()->user()->id)->get();

        return $this->success(['walletHistory' => WalletHistoryResource::collection($walletHistory)], "Wallet History details");

    }
}
