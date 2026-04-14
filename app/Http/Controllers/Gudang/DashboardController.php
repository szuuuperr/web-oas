<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\StockAlert;
use App\Models\StockTransaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Summary statistics
        $totalItems = Material::where('is_active', true)->count();
        $totalStock = Material::where('is_active', true)->sum('current_stock');

        $todayIn = StockTransaction::where('type', 'in')
            ->whereDate('transaction_date', $today)
            ->sum('quantity');

        $todayOut = StockTransaction::where('type', 'out')
            ->whereDate('transaction_date', $today)
            ->sum('quantity');

        // Low stock alerts (unresolved)
        $alertCount = StockAlert::where('is_resolved', false)->count();

        $lowStockItems = Material::whereColumn('current_stock', '<', 'minimum_stock')
            ->where('is_active', true)
            ->orderByRaw('current_stock / NULLIF(minimum_stock, 0) ASC')
            ->limit(5)
            ->get();

        // Recent transactions
        $recentTransactions = StockTransaction::with(['material', 'user'])
            ->latest('transaction_date')
            ->latest('id')
            ->limit(10)
            ->get();

        return view('gudang.dashboard', compact(
            'totalItems',
            'totalStock',
            'todayIn',
            'todayOut',
            'alertCount',
            'lowStockItems',
            'recentTransactions'
        ));
    }
}
