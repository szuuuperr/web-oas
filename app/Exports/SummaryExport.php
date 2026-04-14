<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SummaryExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        $totalMaterial = \App\Models\Material::count();
        $totalPO = \App\Models\PurchaseOrder::count();
        $poApproved = \App\Models\PurchaseOrder::where('status', 'approved')->count();
        $poPending = \App\Models\PurchaseOrder::where('status', 'pending')->count();
        
        return [
            ['Total Material di Gudang', $totalMaterial],
            ['Total Purchase Order (PO)', $totalPO],
            ['PO Disetujui', $poApproved],
            ['PO Menunggu Persetujuan', $poPending],
        ];
    }

    public function headings(): array
    {
        return [
            'Metrik Operasional',
            'Nilai / Jumlah',
        ];
    }
}
