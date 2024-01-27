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
        <table>
            <tr>
                <td>Nama Laporan</td>
                <td>:</td>
                @if ($tipe == 'barang')
                    <td>Stok Barang</td>
                @elseif ($tipe == 'masuk')
                    <td>Laporan Barang Masuk</td>
                @elseif ($tipe == 'keluar')
                    <td>Laporan Penjualan</td>
                @else
                    <td>Laporan Retur</td>
                @endif
            </tr>
            <tr>
                <td>Dari Tanggal</td>
                <td>:</td>
                <td>{{ date('d-m-Y', strtotime($mulai)) }}</td>
            </tr>
            <tr>
                <td>Sampai Tanggal</td>
                <td>:</td>
                <td>{{ date('d-m-Y', strtotime($selesai)) }}</td>
            </tr>
        </table>
    </div>

    <hr>
    <div class="body">
        <table style="width: 100%">
            <thead>
                <tr>
                    @if ($tipe == 'barang')
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th>Harga</th>
                        <th>Stok</th>
                    @elseif ($tipe == 'masuk')
                        <th>No</th>
                        <th>Nama supplier</th>
                        <th>Jenis barang</th>
                        <th>Nama barang</th>
                        <th>Tanggal masuk</th>
                        <th>Jumlah barang masuk</th>
                    @elseif ($tipe == 'keluar')
                        <th>No</th>
                        <th>Nama customer</th>
                        <th>Nama kasir</th>
                        <th>List barang</th>
                        <th>Tanggal jual</th>
                    @else
                        <th>No</th>
                        <th>Nama customer</th>
                        <th>Barang</th>
                        <th>Deskripsi</th>
                        <th>Jumlah</th>
                        <th>Tanggal retur</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                    $total = 0;
                @endphp
                @foreach ($data as $item)
                    @if ($tipe == 'barang')
                        @php
                            $src = $item->gambar_barang;
                        @endphp
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{!! '<img src="'. public_path("storage/$src") .'" style="width: 120px">' !!}</td>
                            <td>{{ $item->nama_barang }}</td>
                            <td>{{ $item->jenis_barang }}</td>
                            <td>Rp.{{ number_format($item->harga_barang) }}</td>
                            <td>{{ $item->stok_barang }}</td>
                        </tr>
                        @php
                            $total += $item->stok_barang;
                        @endphp
                    @elseif ($tipe == 'masuk')
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->supplier->nama_supplier }}</td>
                            <td>{{ $item->barang->jenis_barang }}</td>
                            <td>{{ $item->barang->nama_barang }}</td>
                            <td>{{ $item->tanggal_barang_masuk }}</td>
                            <td>{{ $item->jumlah_barang_masuk }}</td>
                        </tr>
                        @php
                            $total += $item->jumlah_barang_masuk;
                        @endphp
                    @elseif ($tipe == 'keluar')
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->customer->nama_customer }}</td>
                            <td>{{ $item->kasir->nama_kasir }}</td>
                            <td>
                                <table style="width: 100%">
                                    @php
                                        $total2 = 0;
                                    @endphp
                                    <tr>
                                        <th>Nama barang</th>
                                        <th>Jumlah</th>
                                        <th>Harga satuan</th>
                                        <th>Total</th>
                                    </tr>
                                    {{-- {{dd($item)}} --}}
                                    @foreach ($item->barang as $val)
                                        @php
                                            $total += $val->jumlah_barang_keluar * $val->barang->harga_barang;
                                            $total2 += $val->jumlah_barang_keluar * $val->barang->harga_barang;
                                        @endphp
                                        <tr>
                                            <td>{{ $val->barang->nama_barang }}</td>
                                            <td>{{ $val->jumlah_barang_keluar }}</td>
                                            <td>Rp.{{ number_format($val->barang->harga_barang) }}</td>
                                            <td>Rp.{{ number_format($val->jumlah_barang_keluar * $val->barang->harga_barang) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3">Total:</td>
                                        <td>Rp.{{ number_format($total2) }}</td>
                                    </tr>
                                </table>
                            </td>
                            <td>{{ $item->tanggal_penjualan }}</td>
                        </tr>
                    @else
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->penjualan->barangKeluar->customer->nama_customer }}</td>
                            <td>{{ $item->penjualan->barang->nama_barang }}</td>
                            <td>{{ $item->deskripsi }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>{{ $item->tanggal_barang_retur }}</td>
                        </tr>
                        @php
                            $total += $item->jumlah;
                        @endphp
                    @endif
                @endforeach
                
                <tr>
                    @if ($tipe == 'barang')
                        <td colspan="5"><b>Total stok barang</b></td>
                        <td>{{ $total }}</td>
                    @elseif ($tipe == 'masuk')
                        <td colspan="5"><b>Total barang masuk</b></td>
                        <td>{{ $total }}</td>
                    @elseif ($tipe == 'keluar')
                        <td colspan="4"><b>Total penjualan</b></td>
                        <td>Rp.{{ number_format($total) }}</td>
                    @else
                        <td colspan="5"><b>Total retur</b></td>
                        <td>{{ $total }}</td>
                    @endif
                </tr>
            </tbody>
        </table>
    </div>

    <hr>
    <div class="ttd">
        <p><b>Yogyakarta, {{ tgl_indo(date('Y-m-d')) }}</b></p>
        <p><b>Pimpinan PT Sinar Sejahtera Mandiri</b></p>
        <br>
        <br>
        <p>(.........................................................)</p>
    </div>
</body>
</html>