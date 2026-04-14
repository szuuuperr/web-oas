<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\StockTransaction;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = StockTransaction::with(['material', 'user'])
            ->latest('transaction_date')
            ->latest('id');

        // Filter by type
        if ($request->filled('type') && in_array($request->type, ['in', 'out'])) {
            $query->where('type', $request->type);
        }

        // Filter by material
        if ($request->filled('material_id')) {
            $query->where('material_id', $request->material_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('transaction_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('transaction_date', '<=', $request->date_to);
        }

        $transactions = $query->paginate(20)->appends($request->query());

        $materials = Material::where('is_active', true)
            ->orderBy('material_name')
            ->get();

        // Summary stats
        $totalIn = StockTransaction::where('type', 'in')->sum('quantity');
        $totalOut = StockTransaction::where('type', 'out')->sum('quantity');
        $totalTransactions = StockTransaction::count();

        return view('gudang.history', compact(
            'transactions',
            'materials',
            'totalIn',
            'totalOut',
            'totalTransactions'
        ));
    }
}
