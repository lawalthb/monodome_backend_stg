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

       $loadStats = $this->getLoadStatistics();


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
           'load_stats' => $loadStats,
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


    // Method to get order transactions for chart data
    public function getOrderTransactionStats(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Filter orders by date range if provided
        $orders = Order::query();
        if ($startDate) {
            $orders->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $orders->whereDate('created_at', '<=', $endDate);
        }

        // Group by day and sum the amounts
        $orderStats = $orders->select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(amount) as total_amount'),
            DB::raw('COUNT(*) as total_orders')
        )
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        return response()->json([
            'data' => $orderStats
        ]);
    }

    // Method to get wallet transaction statistics
    public function getWalletTransactionStats(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Filter wallet histories by date range if provided
        $walletHistories = DB::table('wallet_histories')->where(function($query) use ($startDate, $endDate) {
            if ($startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            }
            if ($endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            }
        });

        // Group by day and sum the amounts
        $walletStats = $walletHistories->select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(amount) as total_amount'),
            DB::raw('COUNT(*) as total_transactions'),
            DB::raw('SUM(fee) as total_fees')
        )
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        return response()->json([
            'data' => $walletStats
        ]);
    }


    private function getLoadStatistics()
    {
        $periods = [
            'daily' => DB::raw('DATE(created_at)'),
            'weekly' => DB::raw('YEARWEEK(created_at)'),
            'monthly' => DB::raw('YEAR(created_at), MONTH(created_at)'),
            'yearly' => DB::raw('YEAR(created_at)')
        ];

        $loadTypes = LoadType::all();
        $stats = [];

        foreach ($loadTypes as $loadType) {
            $loadTypeStats = [];

            foreach ($periods as $periodName => $period) {
                $loadTypeStats[$periodName] = LoadBoard::where('load_type_id', $loadType->id)
                    ->select($period, DB::raw('COUNT(*) as count'))
                    ->groupBy($period)
                    ->get()
                    ->pluck('count', $periodName === 'daily' ? 'DATE(created_at)' : ($periodName === 'weekly' ? 'YEARWEEK(created_at)' : ($periodName === 'monthly' ? 'MONTH(created_at)' : 'YEAR(created_at)')))
                    ->toArray();
            }

            $stats[$loadType->name] = $loadTypeStats;
        }

        return $stats;
    }
}


