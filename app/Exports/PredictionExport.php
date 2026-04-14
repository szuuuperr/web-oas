<?php

namespace App\Exports;

use App\Models\Material;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PredictionExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Material::all();
    }

    public function headings(): array
    {
        return [
            'ID Material',
            'Kode Material',
            'Nama Material',
            'Stok Saat Ini',
            'Prediksi Metode',
            'Periode Data Historis',
            'Catatan Khusus'
        ];
    }

    public function map($material): array
    {
        return [
            $material->id,
            $material->material_code,
            $material->material_name,
            $material->current_stock,
            'Simple Moving Average (SMA)',
            'Terakhir 14 Hari',
            $material->current_stock < $material->minimum_stock ? 'Perlu Restock Segera' : 'Aman'
        ];
    }
}
