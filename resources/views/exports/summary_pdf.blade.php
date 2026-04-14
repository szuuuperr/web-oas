<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Summary Laporan Operasional</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; max-width: 500px; margin-left: auto; margin-right: auto;}
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .header { text-align: center; margin-bottom: 30px; }
        .val { font-weight: bold; width: 100px; text-align: center;}
    </style>
</head>
<body>
    <div class="header">
        <h2>Summary Laporan Operasional Logistik</h2>
        <p>Dicetak pada: {{ date('d M Y H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Metrik Operasional</th>
                <th class="val">Nilai / Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Total Material di Gudang</td>
                <td class="val">{{ $data['totalMaterial'] }}</td>
            </tr>
            <tr>
                <td>Total Purchase Order (PO)</td>
                <td class="val">{{ $data['totalPO'] }}</td>
            </tr>
            <tr>
                <td>PO Disetujui (Approved)</td>
                <td class="val">{{ $data['poApproved'] }}</td>
            </tr>
            <tr>
                <td>PO Menunggu Persetujuan (Pending)</td>
                <td class="val">{{ $data['poPending'] }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
