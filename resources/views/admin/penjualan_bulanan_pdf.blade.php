<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Penjualan Bulanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
    </style>
</head>

<body>
    <h3>Penjualan Bulanan - {{ $bulanName }} - Tahun {{ $tahun }}</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Harga (Rp)</th>
                <th>Jumlah Terjual</th>
                <th>Penjualan (Rp)</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_produk }}</td>
                    <td>{{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td>{{ $item->sold }}</td>
                    <td>{{ number_format($item->penjualan, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->updated_at)->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-right">Total Penjualan (Rp)</th>
                <th colspan="2">{{ number_format($totalPenjualan, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
</body>

</html>
