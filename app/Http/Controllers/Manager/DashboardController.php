<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Material;
use App\Models\Notification;
use App\Models\PurchaseOrder;
use App\Models\StockAlert;
use App\Models\StockTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total materials
        $totalMaterials = Material::where('is_active', true)->count();

        // Total stock value
        $totalStockValue = Material::where('is_active', true)
            ->selectRaw('SUM(current_stock * unit_price) as total')
            ->value('total') ?? 0;

        // Total stock units
        $totalStockUnits = Material::where('is_active', true)
            ->sum('current_stock');

        // Pending PO count
        $pendingPO = PurchaseOrder::where('status', 'pending')->count();

        // Pending PO value
        $pendingPOValue = PurchaseOrder::where('status', 'pending')
            ->sum('total_amount');

        // Approved this month
        $approvedThisMonth = PurchaseOrder::where('status', 'approved')
            ->whereMonth('approved_at', Carbon::now()->month)
            ->whereYear('approved_at', Carbon::now()->year)
            ->count();

        // Active alerts
        $activeAlerts = StockAlert::where('is_resolved', false)->count();

        // Low stock items
        $lowStockItems = Material::whereColumn('current_stock', '<', 'minimum_stock')
            ->where('is_active', true)
            ->count();

        // Recent activity (transactions last 7 days)
        $recentTransactions = StockTransaction::with(['material', 'user'])
            ->latest('transaction_date')
            ->limit(10)
            ->get();

        // Monthly trend data (last 6 months)
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthlyData[] = [
                'month' => $month->format('M'),
                'in' => StockTransaction::where('type', 'in')
                    ->whereMonth('transaction_date', $month->month)
                    ->whereYear('transaction_date', $month->year)
                    ->sum('quantity'),
                'out' => StockTransaction::where('type', 'out')
                    ->whereMonth('transaction_date', $month->month)
                    ->whereYear('transaction_date', $month->year)
                    ->sum('quantity'),
            ];
        }

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

        // Unread notifications
        $unreadNotifications = Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->count();

        return view('manager.dashboard', compact(
            'totalMaterials',
            'totalStockValue',
            'totalStockUnits',
            'pendingPO',
            'pendingPOValue',
            'approvedThisMonth',
            'activeAlerts',
            'lowStockItems',
            'recentTransactions',
            'monthlyData',
            'unreadNotifications',
            'topOutgoingItems',
            'recentActivity'
        ));
    }
}
