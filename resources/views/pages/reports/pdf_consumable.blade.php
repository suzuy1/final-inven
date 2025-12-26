<!DOCTYPE html>
<html>
<head>
    <title>Laporan Stok BHP</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 16px; text-transform: uppercase; }
        .header p { margin: 2px 0; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #444; padding: 6px; text-align: left; vertical-align: top; }
        th { background-color: #e0e0e0; font-weight: bold; }
        
        /* Highlight baris yang stoknya kritis */
        .critical { color: red; font-weight: bold; }
        
        .footer { margin-top: 30px; text-align: right; font-size: 10px; font-style: italic; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Stok Barang Habis Pakai (BHP)</h1>
        <p>Kategori: Medis, ATK, Kebersihan, dll</p>
        <p>Per Tanggal: {{ date('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 15%">Kode Batch</th>
                <th>Nama Barang</th>
                <th>Merk / Tipe</th>
                <th>Lokasi Simpan</th>
                <th style="width: 10%; text-align: center;">Sisa Stok</th>
                <th style="width: 15%">Tgl Kadaluarsa</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stocks as $index => $item)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $item->batch_code }}</td>
                <td>
                    {{ $item->consumable->name }} <br>
                    <small style="color: #555;">({{ $item->consumable->unit }})</small>
                </td>
                <td>{{ $item->model_name }}</td>
                <td>{{ $item->room->name }}</td>
                
                <td style="text-align: center; {{ $item->current_stock < 5 ? 'color:red; font-weight:bold;' : '' }}">
                    {{ $item->current_stock }}
                </td>

                <td style="{{ ($item->expiry_date && $item->expiry_date < now()->addMonth()) ? 'color:red;' : '' }}">
                    {{ $item->expiry_date ? date('d-m-Y', strtotime($item->expiry_date)) : '-' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak oleh Sistem Informasi Inventaris pada {{ date('d-m-Y H:i') }}
    </div>

</body>
</html>