<?php

namespace App\Exports;

use App\Models\Material;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class InventoryExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Material::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Kode Material',
            'Nama Material',
            'Spesifikasi',
            'Sisa Stok',
            'Batas Minimum',
            'Satuan',
            'Harga Satuan',
            'Catatan'
        ];
    }

    public function map($material): array
    {
        return [
            $material->id,
            $material->material_code,
            $material->material_name,
            $material->spec,
            $material->current_stock,
            $material->minimum_stock,
            $material->unit,
            $material->unit_price,
            $material->remarks
        ];
    }
}
