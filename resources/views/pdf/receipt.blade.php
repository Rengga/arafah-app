<!DOCTYPE html>
<html>
<head>
    <title>Resi Pembayaran</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        td, th { border: 1px solid #000; padding: 5px; }
    </style>
</head>
<body>

<h2>Resi Pembayaran</h2>

<p>ID Resep: {{ $data->id }}</p>

<table>
    <thead>
        <tr>
            <th>Nama Obat</th>
            <th>Qty</th>
            <th>Harga</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @php $grand = 0; @endphp

        @foreach($data->items as $item)
            @php 
                $total = $item->qty * $item->price;
                $grand += $total;
            @endphp
            <tr>
                <td>{{ $item->medicine_name }}</td>
                <td>{{ $item->qty }}</td>
                <td>{{ number_format($item->price) }}</td>
                <td>{{ number_format($total) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<h3>Total: Rp {{ number_format($grand) }}</h3>

</body>
</html>