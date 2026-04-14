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

class StockOutController extends Controller
{
    public function index()
    {
        $materials = Material::where('is_active', true)
            ->where('current_stock', '>', 0)
            ->orderBy('material_name')
            ->get();

        $recentOut = StockTransaction::with(['material', 'user'])
            ->where('type', 'out')
            ->latest('transaction_date')
            ->latest('id')
            ->limit(5)
            ->get();

        return view('gudang.stock-out', compact('materials', 'recentOut'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'material_id'      => 'required|exists:materials,id',
            'quantity'          => 'required|integer|min:1',
            'transaction_date'  => 'required|date',
            'notes'             => 'nullable|string|max:500',
        ]);

        $material = Material::findOrFail($validated['material_id']);

        // Check sufficient stock
        if ($material->current_stock < $validated['quantity']) {
            return back()->withInput()->withErrors([
                'quantity' => "Stok tidak cukup. Stok tersedia: {$material->current_stock} {$material->unit}",
            ]);
        }

        DB::transaction(function () use ($validated, $material) {
            // Generate transaction code
            $prefix = SystemSetting::getValue('transaction_auto_number_prefix', 'PW-TX');
            $lastTx = StockTransaction::orderBy('id', 'desc')->first();
            $nextNum = $lastTx ? ((int) substr($lastTx->transaction_code, -4)) + 1 : 1;
            $txCode = sprintf('%s-%04d', $prefix, $nextNum);

            $totalAmount = $validated['quantity'] * $material->unit_price;

            StockTransaction::create([
                'transaction_code'  => $txCode,
                'material_id'       => $material->id,
                'user_id'           => auth()->id(),
                'type'              => 'out',
                'quantity'          => $validated['quantity'],
                'unit_price'        => $material->unit_price,
                'total_amount'      => $totalAmount,
                'batch_number'      => null,
                'notes'             => $validated['notes'] ?? null,
                'transaction_date'  => $validated['transaction_date'],
            ]);

            // Update material stock
            $material->decrement('current_stock', $validated['quantity']);
            $material->refresh();

            // Generate alert if stock is now below minimum
            if ($material->current_stock < $material->minimum_stock) {
                $existingAlert = StockAlert::where('material_id', $material->id)
                    ->where('is_resolved', false)
                    ->first();

                if (!$existingAlert) {
                    $alertType = ($material->current_stock <= $material->minimum_stock * 0.5) ? 'critical' : 'warning';

                    StockAlert::create([
                        'material_id'   => $material->id,
                        'alert_type'    => $alertType,
                        'message'       => "Stok {$material->material_name} tersisa {$material->current_stock} {$material->unit} — di bawah minimum {$material->minimum_stock} {$material->unit}",
                        'current_stock' => $material->current_stock,
                        'minimum_stock' => $material->minimum_stock,
                    ]);
                }
            }

            // Log activity
            ActivityLog::create([
                'user_id'     => auth()->id(),
                'action'      => 'create',
                'module'      => 'stock_out',
                'description' => "Input stok keluar: {$material->material_name} {$validated['quantity']} {$material->unit}",
                'ip_address'  => request()->ip(),
            ]);
        });

        return redirect()->route('gudang.stock-out')
            ->with('success', 'Transaksi stok keluar berhasil disimpan.');
    }
}
