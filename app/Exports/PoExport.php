<?php

namespace App\Exports;

use App\Models\PurchaseOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PoExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return PurchaseOrder::with('supplier')->get();
    }

    public function headings(): array
    {
        return [
            'ID PO',
            'Nomor PO',
            'Nama Supplier',
            'Total Harga',
            'Status',
            'Tanggal PO',
            'Estimasi Tiba'
        ];
    }

    public function map($po): array
    {
        return [
            $po->id,
            $po->po_number,
            $po->supplier ? $po->supplier->supplier_name : '-',
            $po->total_amount,
            ucfirst($po->status),
            $po->order_date ? $po->order_date->format('Y-m-d') : '-',
            $po->expected_date ? $po->expected_date->format('Y-m-d') : '-'
        ];
    }
}
