<?php

namespace App\Http\Controllers\Logistik;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\StockAlert;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    public function index(Request $request)
    {
        $query = StockAlert::with(['material', 'resolver'])
            ->latest('created_at');

        if ($request->get('status') === 'resolved') {
            $query->where('is_resolved', true);
        } elseif ($request->get('status') === 'active') {
            $query->where('is_resolved', false);
        }

        if ($request->filled('type') && in_array($request->type, ['critical', 'warning'])) {
            $query->where('alert_type', $request->type);
        }

        $alerts = $query->paginate(15)->appends($request->query());

        $activeCount = StockAlert::where('is_resolved', false)->count();
        $criticalCount = StockAlert::where('is_resolved', false)
            ->where('alert_type', 'critical')
            ->count();
        $warningCount = StockAlert::where('is_resolved', false)
            ->where('alert_type', 'warning')
            ->count();

        $lowStockMaterials = Material::whereColumn('current_stock', '<', 'minimum_stock')
            ->where('is_active', true)
            ->with(['category'])
            ->get();

        return view('logistik.alerts', compact(
            'alerts',
            'activeCount',
            'criticalCount',
            'warningCount',
            'lowStockMaterials'
        ));
    }

    public function resolve(StockAlert $alert)
    {
        if ($alert->is_resolved) {
            return back()->with('error', 'Alert sudah resolved.');
        }

        $alert->update([
            'is_resolved' => true,
            'resolved_at' => now(),
            'resolved_by' => auth()->id(),
        ]);

        return back()->with('success', 'Alert berhasil ditandai sebagai resolved.');
    }

    public function bulkResolve(Request $request)
    {
        $alertIds = $request->get('alert_ids', []);

        if (empty($alertIds)) {
            return back()->with('error', 'Pilih alert yang akan di-resolve.');
        }

        StockAlert::whereIn('id', $alertIds)->update([
            'is_resolved' => true,
            'resolved_at' => now(),
            'resolved_by' => auth()->id(),
        ]);

        return back()->with('success', count($alertIds).' alert berhasil di-resolve.');
    }
}
