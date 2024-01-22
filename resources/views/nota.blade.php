@php
    function tgl_indo($tanggal, $cetak_hari = false) {
        $hari = array ( 
            1 => 'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
            'Minggu'
        );

        $bulan = array (
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        
        $split 	  = explode('-', $tanggal);
        $tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
        
        if ($cetak_hari) {
            $num = date('N', strtotime($tanggal));
            return $hari[$num] . ', ' . $tgl_indo;
        }
        
        // variabel pecahkan 0 = tahun
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 2 = tanggal
    
        return $tgl_indo;
    }
@endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Document</title>
    <style type="text/css">
        body {
            font-family: 'Calibri'
        }
        .header {
            text-align: center;
        }
        .header img {
            float: left;
            width: 100px;
        }
        .header2 table {
            margin: auto;
        }

        .body {
            margin: 40px 0;
        }
        .body table {
            border-collapse: collapse;
        }
        .body table tr th, .body table tr td {
            border: 1px solid black;
            padding: 5px;
        }

        .ttd {
            float: right;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('logo.png') }}" style="margin-right: 10px">
        <div style="text-center">
            <h1 style="margin-top: 0; margin-bottom: 5px;">PT SINAR SEJAHTERA MANDIRI</h1>
            <p style="margin: 0">Jl. Ring Road Utara No.1679, Area Sawah, Nogotirto, Kec. Gamping, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55592</p>
        </div>
        <div style="clear: left"></div>
    </div>
    
    <hr>
    <div class="header2">
        <h3 style="text-align: center">Nota Penjualan</h3>
        <table>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>{{ date('d-m-Y H:i', strtotime($data->tanggal_penjualan)) }}</td>
            </tr>
            <tr>
                <td>Customer</td>
                <td>:</td>
                <td>{{ $data->customer->nama_customer }}</td>
            </tr>
        </table>
    </div>

    <hr>
    <div class="body">
        <table style="width: 100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID barang</th>
                    <th>Nama</th>
                    <th>Qty</th>
                    <th>Harga satuan</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                    $total = 0;
                @endphp
                @foreach ($data->barang as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->id_barang }}</td>
                        <td>{{ $item->barang->nama_barang }}</td>
                        <td>{{ $item->jumlah_barang_keluar }}</td>
                        <td>Rp.{{ $item->barang->harga_barang }}</td>
                        <td>Rp.{{ $item->jumlah_barang_keluar * $item->barang->harga_barang }}</td>
                    </tr>
                    @php
                        $total += $item->jumlah_barang_keluar * $item->barang->harga_barang;
                    @endphp
                @endforeach
                
                <tr>
                    <td colspan="5"><b>Total harga</b></td>
                    <td>Rp.{{ number_format($total) }}</td>
                </tr>
                <tr>
                    <td colspan="5"><b>Total Bayar</b></td>
                    <td>Rp.{{ number_format($jumlah) }}</td>
                </tr>
                <tr>
                    <td colspan="5"><b>Kembalian</b></td>
                    <td>Rp.{{ number_format($jumlah - $total) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>