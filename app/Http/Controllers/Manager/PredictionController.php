<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Material;
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

        $selectedMaterialId = $request->get('material_id');
        if (! $selectedMaterialId && $materials->count() > 0) {
            $selectedMaterialId = $materials->first()->id;
        }

        $predictions = [];
        $chartData = null;
        $forecastLogs = [];
        $selectedMaterial = null;

        foreach ($materials as $material) {
            $isTarget = ($material->id == $selectedMaterialId);
            $result = $this->calculateSMA($material, $period, $horizon, $isTarget);
            $predictions[$material->id] = $result['summary'];

            if ($isTarget) {
                $chartData = $result['chartData'];
                $forecastLogs = $result['forecastLogs'];
                $selectedMaterial = $material;
            }
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

        return view('manager.prediction', compact(
            'materialsWithPredictions',
            'predictions',
            'period',
            'horizon',
            'selectedMaterialId',
            'selectedMaterial',
            'chartData',
            'forecastLogs',
            'materials'
        ));
    }

    private function calculateSMA($material, $period = 3, $horizon = 14, $generateDetails = false)
    {
        $startDate = Carbon::now()->subDays(14)->startOfDay();

        $transactions = \App\Models\StockTransaction::where('material_id', $material->id)
            ->where('type', 'out')
            ->where('transaction_date', '>=', $startDate)
            ->orderBy('transaction_date')
            ->get()
            ->groupBy(function ($tx) {
                return $tx->transaction_date->format('Y-m-d');
            });

        $dailyTotals = [];
        // Fill last 14 days with 0 if no transaction
        for ($i = 14; $i >= 0; $i--) {
            $d = Carbon::now()->subDays($i)->format('Y-m-d');
            $dailyTotals[$d] = 0;
        }

        foreach ($transactions as $date => $txs) {
            if (isset($dailyTotals[$date])) {
                $dailyTotals[$date] = $txs->sum('quantity');
            }
        }

        $sma = 0;
        $actualValues = array_values($dailyTotals);

        if (count($actualValues) >= $period) {
            $recentDays = array_slice($actualValues, -$period);
            $sma = array_sum($recentDays) / $period;
        } elseif (count($actualValues) > 0) {
            $sma = array_sum($actualValues) / count($actualValues);
        }

        if ($sma == 0) {
            $sma = $material->minimum_stock / 30; // fallback logic
        }

        $daysRemaining = null;
        $runoutDate = null;

        if ($sma > 0 && $material->current_stock > 0) {
            $daysRemaining = floor($material->current_stock / $sma);
            $runoutDate = Carbon::now()->addDays($daysRemaining);
        }

        $chartData = null;
        $forecastLogs = [];

        if ($generateDetails) {
            $chartData = [
                'labels' => [],
                'actual' => [],
                'forecast' => [],
            ];

            // Historical
            foreach ($dailyTotals as $date => $val) {
                $chartData['labels'][] = Carbon::parse($date)->format('M d');
                $chartData['actual'][] = $val;
                $chartData['forecast'][] = null;
            }
            // Last historical point connects to forecast
            $lastIdx = count($chartData['actual']) - 1;
            $chartData['forecast'][$lastIdx] = $chartData['actual'][$lastIdx];

            // Future
            $currentStock = $material->current_stock;
            for ($i = 1; $i <= $horizon; $i++) {
                $futureDate = Carbon::now()->addDays($i);
                $chartData['labels'][] = $futureDate->format('M d');
                $chartData['actual'][] = null;
                $chartData['forecast'][] = $sma;

                $predictedUsage = $sma;
                $currentStock -= $predictedUsage;

                $status = 'Aman';
                if ($currentStock <= 0) {
                    $status = 'Habis';
                } elseif ($currentStock <= $material->minimum_stock) {
                    $status = 'Kritikal';
                } elseif ($currentStock <= $material->minimum_stock * 1.5) {
                    $status = 'Peringatan';
                }

                $forecastLogs[] = [
                    'date' => $futureDate,
                    'demand' => round($predictedUsage),
                    'predicted_balance' => round($currentStock),
                    'status' => $status,
                ];
            }
        }

        return [
            'summary' => [
                'sma' => round($sma, 2),
                'days_remaining' => $daysRemaining,
                'runout_date' => $runoutDate,
                'current_stock' => $material->current_stock,
                'minimum_stock' => $material->minimum_stock,
            ],
            'chartData' => $chartData,
            'forecastLogs' => $forecastLogs,
        ];
    }

    private function getStockStatus($material, $pred)
    {
        if ($material->current_stock <= 0) {
            return 0;
        }

        if ($material->current_stock < $material->minimum_stock) {
            return 1;
        }

        if ($pred && $pred['days_remaining'] !== null) {
            if ($pred['days_remaining'] <= 7) {
                return 2;
            }
        }

        return 3;
    }
}
