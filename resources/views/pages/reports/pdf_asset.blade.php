<!DOCTYPE html>
<html>
<head>
    <title>Laporan Aset Tetap</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 2px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        .footer { margin-top: 30px; text-align: right; font-size: 10px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>SISTEM INFORMASI INVENTARIS KAMPUS</h1>
        <p>Laporan Data Aset Tetap & Inventaris</p>
        <p>Per Tanggal: {{ date('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th>Kode Aset</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Lokasi / Ruangan</th>
                <th>Kondisi</th>
                <th>Status</th>
                <th>Harga Beli</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($assets as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->unit_code }}</td>
                <td>{{ $item->inventory->name }} <br> <small>{{ $item->model_name }}</small></td>
                <td>{{ $item->inventory->category->name }}</td>
                <td>{{ $item->room->name }}</td>
                <td>{{ ucfirst($item->condition) }}</td>
                <td>{{ ucfirst($item->status) }}</td>
                <td style="text-align: right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
            </tr>
            @php $total += $item->price; @endphp
            @endforeach
            
            <tr style="font-weight: bold; background-color: #f9f9f9;">
                <td colspan="7" style="text-align: right">TOTAL NILAI ASET</td>
                <td style="text-align: right">Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak oleh: {{ Auth::user()->name }} pada {{ date('d-m-Y H:i') }}</p>
    </div>

</body>
</html>