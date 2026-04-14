<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Material;
use App\Models\StockAlert;
use App\Models\StockTransaction;
use App\Models\SystemSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockInController extends Controller
{
    public function index()
    {
        $materials = Material::where('is_active', true)
            ->orderBy('material_name')
            ->get();

        $recentIn = StockTransaction::with(['material', 'user'])
            ->where('type', 'in')
            ->latest('transaction_date')
            ->latest('id')
            ->limit(5)
            ->get();

        return view('gudang.stock-in', compact('materials', 'recentIn'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'material_id'      => 'required|exists:materials,id',
            'quantity'          => 'required|integer|min:1',
            'unit_price'        => 'required|numeric|min:0',
            'transaction_date'  => 'required|date',
            'batch_number'      => 'nullable|string|max:100',
            'notes'             => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($validated) {
            $material = Material::findOrFail($validated['material_id']);

            // Generate transaction code
            $prefix = SystemSetting::getValue('transaction_auto_number_prefix', 'PW-TX');
            $lastTx = StockTransaction::orderBy('id', 'desc')->first();
            $nextNum = $lastTx ? ((int) substr($lastTx->transaction_code, -4)) + 1 : 1;
            $txCode = sprintf('%s-%04d', $prefix, $nextNum);

            // Create transaction
            $totalAmount = $validated['quantity'] * $validated['unit_price'];

            StockTransaction::create([
                'transaction_code'  => $txCode,
                'material_id'       => $material->id,
                'user_id'           => auth()->id(),
                'type'              => 'in',
                'quantity'          => $validated['quantity'],
                'unit_price'        => $validated['unit_price'],
                'total_amount'      => $totalAmount,
                'batch_number'      => $validated['batch_number'] ?? null,
                'notes'             => $validated['notes'] ?? null,
                'transaction_date'  => $validated['transaction_date'],
            ]);

            // Update material stock
            $material->increment('current_stock', $validated['quantity']);

            // Resolve any active alerts if stock is now above minimum
            if ($material->current_stock >= $material->minimum_stock) {
                StockAlert::where('material_id', $material->id)
                    ->where('is_resolved', false)
                    ->update([
                        'is_resolved' => true,
                        'resolved_at' => now(),
                        'resolved_by' => auth()->id(),
                    ]);
            }

            // Log activity
            ActivityLog::create([
                'user_id'     => auth()->id(),
                'action'      => 'create',
                'module'      => 'stock_in',
                'description' => "Input stok masuk: {$material->material_name} {$validated['quantity']} {$material->unit}",
                'ip_address'  => request()->ip(),
            ]);
        });

        return redirect()->route('gudang.stock-in')
            ->with('success', 'Transaksi stok masuk berhasil disimpan.');
    }
}
