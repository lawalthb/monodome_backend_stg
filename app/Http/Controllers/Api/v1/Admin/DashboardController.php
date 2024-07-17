<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Driver;
use App\Models\Wallet;
use App\Models\LoadType;
use App\Models\LoadBoard;
use App\Models\DriverManger;
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

       // Total wallets and total wallet balance
       $totalWallets = Wallet::count();
       $totalWalletBalance = Wallet::sum('amount');

       // Load statistics per type
       $loadTypes = LoadType::all();
       $loadsPerType = [];
       foreach ($loadTypes as $loadType) {
           $loadsPerType[$loadType->name] = $loadType->loadboards()->count();
       }

       // Total transactions and fees in WalletHistory
       $totalTransactions = DB::table('wallet_histories')->count();
       $totalFees = DB::table('wallet_histories')->sum('fee');

       // Total orders
       $totalOrders = Order::count();

       // Statistics for LoadBoards
       $totalLoadBoards = LoadBoard::count();
       $pendingLoadBoards = LoadBoard::where('status', 'pending')->count();
       $activeLoadBoards = LoadBoard::where('status', 'active')->count();
       $completedLoadBoards = LoadBoard::where('status', 'completed')->count();

       // Total drivers and driver managers
       $totalDrivers = Driver::count();
       $totalDriverManagers = DriverManger::count();

       return response()->json([
           'total_users' => $totalUsers,
           'users_per_role' => $usersPerRole,
           'total_wallets' => $totalWallets,
           'total_wallet_balance' => $totalWalletBalance,
           'loads_per_type' => $loadsPerType,
           'total_transactions' => $totalTransactions,
           'total_fees' => $totalFees,
           'total_orders' => $totalOrders,
           'total_load_boards' => $totalLoadBoards,
           'pending_load_boards' => $pendingLoadBoards,
           'active_load_boards' => $activeLoadBoards,
           'completed_load_boards' => $completedLoadBoards,
           'total_drivers' => $totalDrivers,
           'total_driver_managers' => $totalDriverManagers,
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
