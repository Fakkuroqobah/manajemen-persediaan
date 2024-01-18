@extends('layouts.index')

@section('title', 'Penjualan')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Penjualan</li>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('content')
<a href="#" class="btn btn-primary mb-3 float-right" data-toggle="modal" data-target="#modal-tambah">Tambah</a>
<div class="clearfix"></div>

<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="table" style="width: 100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama customer</th>
                        <th>Nama kasir</th>
                        <th>List barang</th>
                        <th>Tanggal jual</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

{{-- modal --}}
<div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="form-tambah">
                <div class="modal-body">
                    <div class="alert alert-danger error-message d-none" role="alert">
                        <ul class="m-0"></ul>
                    </div>

                    <div class="form-group">
                        <label for="">Customer</label>
                        <select name="id_customer" class="form-control" id="">
                            <option value="">Pilih customer</option>
                            @foreach ($customer as $item)
                                <option value="{{ $item->id_customer }}">{{ $item->nama_customer }}</option>
                            @endforeach    
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Kasir</label>
                        <select name="id_kasir" class="form-control" id="">
                            <option value="">Pilih kasir</option>
                            @foreach ($kasir as $item)
                                <option value="{{ $item->id_kasir }}">{{ $item->nama_kasir }}</option>
                            @endforeach    
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Barang</label>
                        <select name="id_barang" class="form-control" id="">
                            <option value="">Pilih barang</option>
                            @foreach ($barang as $item)
                                <option value="{{ $item->id_barang }}">{{ $item->nama_barang }}</option>
                            @endforeach    
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Jumlah barang</label>
                        <input type="number" name="jumlah" class="form-control" placeholder="Keluaran jumlah barang" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal jual</label>
                        <input type="date" name="tanggal" class="form-control" placeholder="Keluaran tanggal jual" autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" name="close-modal" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="form-edit">
                <div class="modal-body">
                    <div class="alert alert-danger error-message d-none" role="alert">
                        <ul class="m-0"></ul>
                    </div>

                    <div class="form-group">
                        <label for="">Barang</label>
                        <select name="id_barang" class="form-control" id="">
                            <option value="">Pilih barang</option>
                            @foreach ($barang as $item)
                                <option value="{{ $item->id_barang }}">{{ $item->nama_barang }}</option>
                            @endforeach    
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Jumlah barang</label>
                        <input type="number" name="jumlah" class="form-control" placeholder="Keluaran jumlah barang" autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" name="close-modal" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-nota" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cetak Nota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="form-edit">
                <div class="modal-body">
                    <div class="alert alert-danger error-message d-none" role="alert">
                        <ul class="m-0"></ul>
                    </div>

                    <div class="form-group">
                        <label for="">Jumlah bayar</label>
                        <input type="number" name="jumlah_bayar" class="form-control" id="jumlah_bayar" placeholder="Masukan jumlah uang pembayaran" autofocus>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" name="close-modal" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" name="submit" id="cetak" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
$(document).ready(function() {
    var table = $('#table').DataTable({
        processing: true,
        ajax: '{{ route("penjualan.index") }}',
        columns: [
            { data: 'DT_RowIndex', name:'DT_RowIndex', searchable: false },
            { data: 'customer.nama_customer', name: 'nama_customer' },
            { data: 'kasir.nama_kasir', name: 'nama_kasir' },
            { data: 'barang', name: 'barang' },
            { data: 'tanggal_penjualan', name: 'tanggal_penjualan' },
            { data: 'aksi', name: 'aksi', orderable: false, searchable: false },
        ],
        columnDefs: [
            { "className": "text-center", "targets": [0, 5] },
            { "width": "5%", "targets": 0 },
            { "width": "20%", "targets": 5 },
        ],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdf',
                exportOptions: {
                    columns: [0,1,2,3,4,5]
                }
            }
        ]
    });
    

    $('#table').on('click', '.edit', function(e) {
        e.preventDefault()
        $('#modal-edit button[name="submit"]').attr('data-id', $(this).attr('data-id'));
    });

    $('#table').on('click', '.nota', function(e) {
        e.preventDefault()
        $('#modal-nota button[name="submit"]').attr('data-id', $(this).attr('data-id'));
    });

    var tambah = $("#modal-tambah button[name='submit']");
    tambah.click(function(e) {
        e.preventDefault();

        tambah.attr("disabled", true);
        tambah.text('Loading');

        $('.error-message').addClass('d-none');
        $('.error-message ul').empty();

        var form = new FormData($('#form-tambah')[0]);
        form.append('aksi', 'tambah');

        var opt = {
            method: 'POST',
            aksi: 'tambah',
            url: '{{ route("penjualan.store") }}',
            table: table,
            element: tambah
        };

        var txt = {
            btnText: 'Tambah Data',
            msgAlert: 'Data berhasil ditambahkan',
            msgText: 'ditambah'
        };

        requestAjaxPost(opt, form, txt);
    });

    var edit = $("#modal-edit button[name='submit']");
    edit.click(function(e) {
        e.preventDefault();

        edit.attr("disabled", true);
        edit.text('Loading');

        $('.error-message').addClass('d-none');
        $('.error-message ul').empty();

        var form = new FormData($('#form-edit')[0]);
        form.append('aksi', 'edit');
        form.append('_method', 'PATCH');

        var url = "{{ route('penjualan.update', ':id') }}";
        url = url.replace(':id', $(this).attr('data-id'));

        var opt = {
            method: 'POST',
            aksi: 'edit',
            url: url,
            table: table,
            element: edit
        };

        var txt = {
            btnText: 'Simpan',
            msgAlert: 'Data berhasil diedit',
            msgText: 'diedit'
        };

        requestAjaxPost(opt, form, txt);
    });


    $('#cetak').on('click', function(e) {
        e.preventDefault();

        var url = "{{ route('nota', ['id' => ':id', 'jumlah' => ':jumlah']) }}";
        url = url.replace(':id', $(this).attr('data-id'));
        url = url.replace(':jumlah', $('#jumlah_bayar').val());

        window.location.href = url;
    });

    $('#table').on('click', '.delete', function(event) {
        var url = "{{ route('penjualan.destroy', ':id') }}";
        url = url.replace(':id', $(this).attr('data-id'));

        var opt = {
            url: url,
            method: 'DELETE',
            aksi: 'hapus',
            table: table
        };
        
        var txt = {
            msgAlert: "Data akan dihapus!",
            msgText: "hapus",
            msgTitle: 'Data berhasil dihapus'
        };

        requestAjaxDelete(opt, txt);
    });
});
</script>
@endpush