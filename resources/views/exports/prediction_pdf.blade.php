<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Analisis Prediksi Stok</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #f4f4f4; }
        .header { text-align: center; margin-bottom: 30px; }
        .critical { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Analisis Prediksi Stok (Simple Moving Average)</h2>
        <p>Dicetak pada: {{ date('d M Y H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Material</th>
                <th>Sisa Stok Saat Ini</th>
                <th>Metode Analisa</th>
                <th>Basis Data Historis</th>
                <th>Rekomendasi / Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $item->material_code }}</td>
                <td>{{ $item->material_name }}</td>
                <td>{{ $item->current_stock }}</td>
                <td>Simple Moving Average (SMA)</td>
                <td>14 Hari Terakhir</td>
                <td class="{{ $item->current_stock < $item->minimum_stock ? 'critical' : '' }}">
                    {{ $item->current_stock < $item->minimum_stock ? 'PERLU RESTOCK' : 'Aman' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
