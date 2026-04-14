<?php

namespace App\Http\Controllers\Logistik;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\StockTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PredictionController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', 3);
        $horizon = $request->get('horizon', 14);
        $statusFilter = $request->get('status');

        $materials = Material::where('is_active', true)
            ->with(['category', 'supplier'])
            ->get();

        $predictions = [];

        foreach ($materials as $material) {
            $prediction = $this->calculateSMA($material, $period, $horizon);
            $predictions[$material->id] = $prediction;
        }

        $materialsWithPredictions = Material::where('is_active', true)
            ->with(['category'])
            ->get()
            ->map(function ($material) use ($predictions) {
                $pred = $predictions[$material->id] ?? null;
                $material->predicted_daily_usage = $pred['sma'] ?? 0;
                $material->days_remaining = $pred['days_remaining'] ?? null;
                $material->estimated_runout_date = $pred['runout_date'] ?? null;
                $material->stock_status = $this->getStockStatus($material, $pred);

                return $material;
            })
            ->sortByDesc('stock_status');

        if ($statusFilter !== null && $statusFilter !== '') {
            $materialsWithPredictions = $materialsWithPredictions->where('stock_status', $statusFilter);
        }

        return view('logistik.prediction', compact(
            'materialsWithPredictions',
            'predictions',
            'period',
            'horizon'
        ));
    }

    private function calculateSMA($material, $period = 3, $horizon = 14)
    {
        // Get stock transactions (type=out) for the last 30 days
        $startDate = Carbon::now()->subDays(30)->startOfDay();

        $transactions = StockTransaction::where('material_id', $material->id)
            ->where('type', 'out')
            ->where('transaction_date', '>=', $startDate)
            ->orderBy('transaction_date')
            ->get()
            ->groupBy(function ($tx) {
                return $tx->transaction_date->format('Y-m-d');
            });

        // Calculate daily totals
        $dailyTotals = [];
        foreach ($transactions as $date => $txs) {
            $dailyTotals[$date] = $txs->sum('quantity');
        }

        // Calculate SMA
        $sma = 0;
        if (count($dailyTotals) >= $period) {
            $recentDays = array_slice($dailyTotals, -$period);
            $sma = array_sum($recentDays) / $period;
        } elseif (count($dailyTotals) > 0) {
            $sma = array_sum($dailyTotals) / count($dailyTotals);
        }

        // If no transactions, use minimum_stock / 30 as estimate
        if ($sma == 0) {
            $sma = $material->minimum_stock / 30;
        }

        // Calculate days remaining
        $daysRemaining = null;
        $runoutDate = null;

        if ($sma > 0 && $material->current_stock > 0) {
            $daysRemaining = floor($material->current_stock / $sma);
            $runoutDate = Carbon::now()->addDays($daysRemaining);
        }

        return [
            'sma' => round($sma, 2),
            'days_remaining' => $daysRemaining,
            'runout_date' => $runoutDate,
            'current_stock' => $material->current_stock,
            'minimum_stock' => $material->minimum_stock,
        ];
    }

    private function getStockStatus($material, $pred)
    {
        if ($material->current_stock <= 0) {
            return 0; // Critical
        }

        if ($material->current_stock < $material->minimum_stock) {
            return 1; // Low Stock
        }

        if ($pred && $pred['days_remaining'] !== null) {
            if ($pred['days_remaining'] <= 7) {
                return 2; // Warning - will run out soon
            }
        }

        return 3; // Safe
    }

    public function getPredictionJson(Request $request)
    {
        $materialId = $request->get('material_id');
        $period = $request->get('period', 3);
        $horizon = $request->get('horizon', 14);

        $material = Material::findOrFail($materialId);
        $prediction = $this->calculateSMA($material, $period, $horizon);

        // Get historical data for chart
        $startDate = Carbon::now()->subDays(30)->startOfDay();

        $transactions = StockTransaction::where('material_id', $material->id)
            ->where('type', 'out')
            ->where('transaction_date', '>=', $startDate)
            ->orderBy('transaction_date')
            ->get()
            ->groupBy(function ($tx) {
                return $tx->transaction_date->format('Y-m-d');
            });

        $historicalData = [];
        foreach ($transactions as $date => $txs) {
            $historicalData[] = [
                'date' => $date,
                'quantity' => $txs->sum('quantity'),
            ];
        }

        // Generate prediction data
        $predictionData = [];
        $currentStock = $material->current_stock;

        for ($i = 1; $i <= $horizon; $i++) {
            $currentStock -= $prediction['sma'];
            $predictionData[] = [
                'day' => $i,
                'predicted_stock' => max(0, round($currentStock, 2)),
            ];
        }

        return response()->json([
            'material' => $material,
            'prediction' => $prediction,
            'historical' => $historicalData,
            'forecast' => $predictionData,
        ]);
    }
}
