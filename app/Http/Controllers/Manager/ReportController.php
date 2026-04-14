<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Material;
use App\Models\StockTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Default date range: current month
        $dateFrom = $request->get('date_from', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $categoryId = $request->get('category_id');
        $type = $request->get('type'); // 'in', 'out', or null for all

        // Base query
        $query = StockTransaction::with(['material', 'user'])
            ->whereBetween('transaction_date', [$dateFrom, $dateTo]);

        if ($type && in_array($type, ['in', 'out'])) {
            $query->where('type', $type);
        }

        // Get transactions with pagination
        $transactions = $query->latest('transaction_date')
            ->latest('id')
            ->paginate(20)
            ->appends($request->query());

        // Aggregate by material for summary
        $materialSummary = StockTransaction::with(['material'])
            ->whereBetween('transaction_date', [$dateFrom, $dateTo])
            ->when($type && in_array($type, ['in', 'out']), function ($q) use ($type) {
                $q->where('type', $type);
            })
            ->get()
            ->groupBy('material_id')
            ->map(function ($txs) {
                return [
                    'material' => $txs->first()->material,
                    'total_in' => $txs->where('type', 'in')->sum('quantity'),
                    'total_out' => $txs->where('type', 'out')->sum('quantity'),
                    'total_value_in' => $txs->where('type', 'in')->sum('total_amount'),
                    'total_value_out' => $txs->where('type', 'out')->sum('total_amount'),
                ];
            })
            ->filter(function ($item) {
                return $item['material'] !== null;
            })
            ->sortByDesc(function ($item) {
                return $item['total_out'];
            });

        // Overall summary
        $totalMasuk = StockTransaction::where('type', 'in')
            ->whereBetween('transaction_date', [$dateFrom, $dateTo])
            ->sum('quantity');

        $totalKeluar = StockTransaction::where('type', 'out')
            ->whereBetween('transaction_date', [$dateFrom, $dateTo])
            ->sum('quantity');

        $totalValueMasuk = StockTransaction::where('type', 'in')
            ->whereBetween('transaction_date', [$dateFrom, $dateTo])
            ->sum('total_amount');

        $totalValueKeluar = StockTransaction::where('type', 'out')
            ->whereBetween('transaction_date', [$dateFrom, $dateTo])
            ->sum('total_amount');

        // Categories for filter
        $categories = Category::orderBy('name')->get();

        return view('manager.reports', compact(
            'transactions',
            'materialSummary',
            'totalMasuk',
            'totalKeluar',
            'totalValueMasuk',
            'totalValueKeluar',
            'dateFrom',
            'dateTo',
            'categoryId',
            'type',
            'categories'
        ));
    }
}
