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
        //api
    }

    public function wallet_history(){

        $walletHistory = WalletHistory::where('user_id', auth()->user()->id)->get();

        return $this->success(['walletHistory' => WalletHistoryResource::collection($walletHistory)], "Wallet History details");

    }

    public function update_pin(Request $request){

        $request->validate([
          'pin' => 'required|numeric|digits:4'
        ]);

        $wallet = Wallet::where('user_id', auth()->user()->id)->first();

        $wallet->pin = $request->pin;

        if($wallet->save()){
          $walletHistory = WalletHistory::where('wallet_id', $wallet->id)->get();

          if($walletHistory->isEmpty()){
            return $this->success(['walletHistory' => []], "Wallet pin updated successfully");
          }else{
            return $this->success(['walletHistory' => WalletResource::collection($walletHistory)], "Wallet pin updated successfully");
          }
        }else{
          return $this->error(null, 'Error Wallet pin details', 422);
        }
      }

     public function checkPinExists(){

            // Find the wallet by its ID
            $wallet = Wallet::where('user_id', auth()->user()->id)->first();

            // Check if the wallet exists and if the PIN is null
            if ($wallet && is_null($wallet->pin)) {
                // PIN is null
                return true;
            } else {
                // PIN is not null
                return false;
            }
     }
}
