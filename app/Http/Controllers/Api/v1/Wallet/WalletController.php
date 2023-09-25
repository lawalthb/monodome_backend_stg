<?php

namespace App\Http\Controllers\Api\v1\Wallet;

use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use App\Http\Controllers\Controller;

class WalletController extends Controller
{
    use ApiStatusTrait, FileUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wallet = Wallet::where('user_id', auth()->user()->id)->get();

        return $this->success(['wallet' => $wallet], "Wallet Dashboard details");

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
}
