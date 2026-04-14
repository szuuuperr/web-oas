<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Inventaris</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #f4f4f4; }
        .header { text-align: center; margin-bottom: 30px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ isset($title) ? 'Laporan ' . $title : 'Laporan Inventaris Stok' }}</h2>
        <p>Dicetak pada: {{ date('d M Y H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Material</th>
                <th>Spesifikasi</th>
                <th>Sisa Stok</th>
                <th>Min Stok</th>
                <th>Satuan</th>
                <th>Harga Satuan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $item->material_code }}</td>
                <td>{{ $item->material_name }}</td>
                <td>{{ $item->spec }}</td>
                <td>{{ $item->current_stock }}</td>
                <td>{{ $item->minimum_stock }}</td>
                <td>{{ $item->unit }}</td>
                <td>Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
