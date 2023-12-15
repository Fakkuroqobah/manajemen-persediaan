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
            <table class="table table-bordered table-hover" id="table" style="width: 100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama customer</th>
                        <th>Jenis barang</th>
                        <th>Nama barang</th>
                        <th>Tanggal keluar</th>
                        <th>Jumlah barang keluar</th>
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
                        <label for="">Tanggal barang keluar</label>
                        <input type="date" name="tanggal" class="form-control" placeholder="Keluaran tannggal barang keluar" autocomplete="off">
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
                <h5 class="modal-title">Edit</h5>
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
                        <label for="">Customer</label>
                        <select name="id_customer" class="form-control" id="">
                            <option value="">Pilih customer</option>
                            @foreach ($customer as $item)
                                <option value="{{ $item->id_customer }}">{{ $item->nama_customer }}</option>
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
                        <label for="">Tanggal barang keluar</label>
                        <input type="date" name="tanggal" class="form-control" placeholder="Keluaran tannggal barang keluar" autocomplete="off">
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
            { data: 'barang.jenis_barang', name: 'jenis_barang' },
            { data: 'barang.nama_barang', name: 'nama_barang' },
            { data: 'tanggal_barang_keluar', name: 'tanggal_barang_keluar' },
            { data: 'jumlah_barang_keluar', name: 'jumlah_barang_keluar' },
            { data: 'aksi', name: 'aksi', orderable: false, searchable: false },
        ],
        columnDefs: [
            { "className": "text-center", "targets": [0, 6] },
            { "width": "5%", "targets": 0 },
            { "width": "20%", "targets": 6 },
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
    

    var modalEdit_id_customer = $('#modal-edit select[name="id_customer"]');
    var modalEdit_id_barang = $('#modal-edit select[name="id_barang"]');
    var modalEdit_jumlah = $('#modal-edit input[name="jumlah"]');
    var modalEdit_tanggal = $('#modal-edit input[name="tanggal"]');
    $('#modal-edit').on('hidden.bs.modal', function () {
        modalEdit_id_customer.val("");
        modalEdit_id_barang.val("");
        modalEdit_jumlah.val("");
        modalEdit_tanggal.val("");
    });
    $('#table').on('click', '.edit', function(e) {
        e.preventDefault()

        var url = "{{ route('penjualan.show', ':id') }}";
        url = url.replace(':id', $(this).attr('data-id'));

        $('#modal-edit button[name="submit"]').attr('data-id', $(this).attr('data-id'));
        modalEdit_id_customer.attr("disabled", true);
        modalEdit_id_barang.attr("disabled", true);
        modalEdit_jumlah.attr("disabled", true);
        modalEdit_tanggal.attr("disabled", true);
        
        $.ajax({
            url: url,
            method: "GET",
            cache: false,
            processData: false,
            contentType: false
        }).done(function(msg) {
            modalEdit_id_customer.attr("disabled", false);
            modalEdit_id_customer.trigger('focus');
            modalEdit_id_customer.val(msg.data.id_customer);

            modalEdit_id_barang.attr("disabled", false);
            modalEdit_id_barang.val(msg.data.id_barang);

            modalEdit_jumlah.attr("disabled", false);
            modalEdit_jumlah.val(msg.data.jumlah_barang_keluar);

            modalEdit_tanggal.attr("disabled", false);
            modalEdit_tanggal.val(msg.data.tanggal_barang_keluar);
        }).fail(function(err) {
            alert("Terjadi kesalahan pada server");
            modalEdit_id_customer.attr("disabled", false);
            modalEdit_id_barang.attr("disabled", false);
            modalEdit_jumlah.attr("disabled", false);
            modalEdit_tanggal.attr("disabled", false);
        });
    });
    $('#modal-edit').on('shown.bs.modal', function() {
        $('#modal-edit input[name="nama"]').trigger('focus');
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
            btnText: 'Edit Data',
            msgAlert: 'Data berhasil diedit',
            msgText: 'diedit'
        };

        requestAjaxPost(opt, form, txt);
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