<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\User;
use App\Models\Wallet;
use App\Models\LoadType;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserRoleResource;

class DashboardController extends Controller
{

    use ApiStatusTrait,FileUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     // Total users
     $totalUsers = User::count();

     // Users per role
     $roles = Role::all();
     $usersPerRole = [];
     foreach ($roles as $role) {
         $usersPerRole[$role->name] = $role->users()->count();
     }

     // Total wallets
     $totalWallets = Wallet::count();
     $totalWalletBalance = Wallet::sum('amount');

     // Load statistics
     $loadTypes = LoadType::all();
     $loadsPerType = [];
     foreach ($loadTypes as $loadType) {
         $loadsPerType[$loadType->name] = $loadType->loadboards()->count();
     }

     $totalTransactions = DB::table('wallet_histories')->count();
     $totalFees = DB::table('wallet_histories')->sum('fee');

     return response()->json([
         'total_users' => $totalUsers,
         'users_per_role' => $usersPerRole,
         'total_wallets' => $totalWallets,
         'total_wallet_balance' => $totalWalletBalance,
         'loads_per_type' => $loadsPerType,
         'total_transactions' => $totalTransactions,
         'total_fees' => $totalFees,
     ]);

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
