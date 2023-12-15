@extends('layouts.index')

@section('title', 'Laporan')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Laporan</li>
@endsection

@push('styles')
@endpush

@section('content')
<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <form action="{{ route('download') }}" method="get">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Tipe</label>
                        <select name="tipe" class="form-control">
                            <option value="masuk">Barang Masuk</option>
                            <option value="keluar">Penjualan</option>
                            <option value="retur">Retur</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Dari Tanggal</label>
                        <input type="date" name="mulai" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Sampai Tanggal</label>
                        <input type="date" name="selesai" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Tombol</label>
                        <button type="submit" class="btn btn-primary d-block">Cetak</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
@endpush