<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Purchase Order</title>
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
        <h2>Laporan Purchase Order (PO)</h2>
        <p>Dicetak pada: {{ date('d M Y H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Nomor PO</th>
                <th>Supplier</th>
                <th>Order Date</th>
                <th>Expected Date</th>
                <th>Status</th>
                <th>Total Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $po)
            <tr>
                <td>{{ $po->po_number }}</td>
                <td>{{ $po->supplier ? $po->supplier->supplier_name : '-' }}</td>
                <td>{{ $po->order_date ? $po->order_date->format('d M Y') : '-' }}</td>
                <td>{{ $po->expected_date ? $po->expected_date->format('d M Y') : '-' }}</td>
                <td>{{ ucfirst($po->status) }}</td>
                <td>Rp {{ number_format($po->total_amount, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
