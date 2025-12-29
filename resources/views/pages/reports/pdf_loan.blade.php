<!DOCTYPE html>
<html>
<head>
    <title>Laporan Peminjaman Aktif</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 16px; text-transform: uppercase; }
        .header p { margin: 2px 0; color: #555; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #444; padding: 6px; text-align: left; vertical-align: top; }
        th { background-color: #e0e0e0; }
        
        .status-telat { color: red; font-weight: bold; text-transform: uppercase; }
        .status-pinjam { color: green; font-weight: bold; text-transform: uppercase; }
        
        .footer { margin-top: 30px; text-align: right; font-size: 10px; }
        .ttd { margin-top: 50px; width: 100%; }
        .ttd-box { width: 30%; float: right; text-align: center; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Peminjaman Aset Aktif</h1>
        <p>Daftar barang yang sedang berada di luar / dipinjam</p>
        <p>Per Tanggal: {{ date('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 10%">Status</th>
                <th>Peminjam (NIM/NIP)</th>
                <th>Nama Aset</th>
                <th>Kode Unit</th>
                <th>Tgl Pinjam</th>
                <th>Tenggat Kembali</th>
                <th>No. HP</th>
            </tr>
        </thead>
        <tbody>
            @forelse($loans as $index => $loan)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                
                <td>
                    @if($loan->status == 'telat' || ($loan->status == 'dipinjam' && $loan->return_date_plan < now()))
                        <span class="status-telat">TERLAMBAT</span>
                    @else
                        <span class="status-pinjam">DIPINJAM</span>
                    @endif
                </td>

                <td>
                    <strong>{{ $loan->borrower_name }}</strong> <br>
                    <small>{{ $loan->borrower_id }}</small>
                </td>
                <td>{{ $loan->asset->inventory->name }}</td>
                <td>{{ $loan->asset->unit_code }}</td>
                <td>{{ date('d-m-Y', strtotime($loan->loan_date)) }}</td>
                
                <td style="{{ ($loan->return_date_plan < now()) ? 'color:red; font-weight:bold;' : '' }}">
                    {{ date('d-m-Y', strtotime($loan->return_date_plan)) }}
                </td>
                
                <td>{{ $loan->phone ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 20px;">
                    Tidak ada peminjaman aktif saat ini. Semua barang ada di tempat.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="ttd">
        <div class="ttd-box">
            <p>Mengetahui,<br>Kepala Bagian Umum</p>
            <br><br><br>
            <p>( ...................................... )</p>
        </div>
    </div>

</body>
</html>