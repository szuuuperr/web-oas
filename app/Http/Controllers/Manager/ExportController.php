<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\InventoryExport;
use App\Exports\PoExport;
use App\Exports\PredictionExport;
use App\Exports\SummaryExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Material;
use App\Models\PurchaseOrder;

class ExportController extends Controller
{
    public function index()
    {
        return view('manager.export');
    }

    public function download(Request $request)
    {
        $type = $request->query('type');
        $format = $request->query('format');

        $fileName = 'Laporan_' . ucfirst($type) . '_' . date('Y-m-d_His');

        if ($format === 'excel') {
            if ($type === 'inventaris') {
                return Excel::download(new InventoryExport, $fileName . '.xlsx');
            } elseif ($type === 'po') {
                return Excel::download(new PoExport, $fileName . '.xlsx');
            } elseif ($type === 'prediksi') {
                return Excel::download(new PredictionExport, $fileName . '.xlsx');
            } else {
                return Excel::download(new SummaryExport, $fileName . '.xlsx');
            }
        } elseif ($format === 'pdf') {
            if ($type === 'inventaris') {
                $data = Material::all();
                $pdf = Pdf::loadView('exports.inventory_pdf', compact('data'));
                return $pdf->download($fileName . '.pdf');
            } elseif ($type === 'po') {
                $data = PurchaseOrder::with('supplier')->get();
                $pdf = Pdf::loadView('exports.po_pdf', compact('data'));
                return $pdf->download($fileName . '.pdf');
            } elseif ($type === 'prediksi') {
                $data = Material::all();
                $pdf = Pdf::loadView('exports.prediction_pdf', compact('data'));
                return $pdf->download($fileName . '.pdf');
            } else {
                $data = [
                    'totalMaterial' => Material::count(),
                    'totalPO' => PurchaseOrder::count(),
                    'poApproved' => PurchaseOrder::where('status', 'approved')->count(),
                    'poPending' => PurchaseOrder::where('status', 'pending')->count()
                ];
                $pdf = Pdf::loadView('exports.summary_pdf', compact('data'));
                return $pdf->download($fileName . '.pdf');
            }
        }

        return redirect()->back()->with('error', 'Format atau tipe laporan tidak valid.');
    }
}
