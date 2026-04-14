<?php

namespace App\Http\Controllers\Logistik;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\PurchaseOrder;
use App\Models\StockAlert;
use App\Models\StockTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Active low stock alerts (unresolved)
        $activeAlerts = StockAlert::where('is_resolved', false)
            ->count();

        // Pending PO count
        $pendingPO = PurchaseOrder::where('status', 'pending')->count();

        // Total pending PO value
        $totalPOValue = PurchaseOrder::where('status', 'pending')
            ->sum('total_amount');

        // Recent PO (latest 5)
        $recentPO = PurchaseOrder::with(['creator', 'purchaseOrderItems.material'])
            ->latest()
            ->limit(5)
            ->get();

        // Today's transactions
        $today = Carbon::today();
        $todayTransactions = StockTransaction::whereDate('transaction_date', $today)
            ->count();

        // Low stock items count
        $lowStockItems = \App\Models\Material::whereColumn('current_stock', '<', 'minimum_stock')
            ->where('is_active', true)
            ->count();

        // Top 10 barang paling banyak keluar
        $topOutgoingItems = StockTransaction::select('materials.id', 'materials.material_code', 'materials.material_name', 'materials.unit', DB::raw('SUM(stock_transactions.quantity) as total_outgoing'))
            ->join('materials', 'stock_transactions.material_id', '=', 'materials.id')
            ->where('stock_transactions.type', 'out')
            ->groupBy('materials.id', 'materials.material_code', 'materials.material_name', 'materials.unit')
            ->orderByDesc('total_outgoing')
            ->limit(10)
            ->get();

        // Aktivitas terakhir
        $recentActivity = ActivityLog::with('user')
            ->latest()
            ->limit(8)
            ->get();

        return view('logistik.dashboard', compact(
            'activeAlerts',
            'pendingPO',
            'totalPOValue',
            'recentPO',
            'todayTransactions',
            'lowStockItems',
            'topOutgoingItems',
            'recentActivity'
        ));
    }
}
