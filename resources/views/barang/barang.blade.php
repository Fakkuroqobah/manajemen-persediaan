@extends('layouts.index')

@section('title', 'Barang')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Barang</li>
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
                        <th>Id</th>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th>Stok</th>
                        <th>Harga</th>
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
                        <label for="">Gambar barang</label>
                        <input type="file" name="gambar" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Nama barang</label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukan nama barang" autofocus autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">Jenis barang</label>
                        <input type="text" name="jenis" class="form-control" placeholder="Masukan jenis barang" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">Stok barang</label>
                        <input type="number" name="stok" class="form-control" placeholder="Masukan stok barang" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">Harga barang</label>
                        <input type="number" name="harga" class="form-control" placeholder="Masukan harga barang" autocomplete="off">
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
                        <label for="">Gambar barang</label>
                        <input type="file" name="gambar" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Nama barang</label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukan nama barang" autofocus autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">Jenis barang</label>
                        <input type="text" name="jenis" class="form-control" placeholder="Masukan jenis barang" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">Stok barang</label>
                        <input type="number" name="stok" class="form-control" placeholder="Masukan stok barang" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">Harga barang</label>
                        <input type="number" name="harga" class="form-control" placeholder="Masukan harga barang" autocomplete="off">
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
        ajax: '{{ route("barang.index") }}',
        columns: [
            { data: 'DT_RowIndex', name:'DT_RowIndex', searchable: false },
            { data: 'id_barang', name: 'id_barang' },
            { data: 'gambar_barang', name: 'gambar_barang' },
            { data: 'nama_barang', name: 'nama_barang' },
            { data: 'jenis_barang', name: 'jenis_barang' },
            { data: 'stok_barang', name: 'stok_barang' },
            { data: 'harga_barang', name: 'harga_barang' },
            { data: 'aksi', name: 'aksi', orderable: false, searchable: false },
        ],
        columnDefs: [
            { "className": "text-center", "targets": [0, 7] },
            { "width": "5%", "targets": 0 },
            { "width": "20%", "targets": 7 },
        ],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdf',
                exportOptions: {
                    columns: [0,1,2,3,4,5,6]
                }
            }
        ]
    });
    

    var modalEdit_nama = $('#modal-edit input[name="nama"]');
    var modalEdit_jenis = $('#modal-edit input[name="jenis"]');
    var modalEdit_stok = $('#modal-edit input[name="stok"]');
    var modalEdit_harga = $('#modal-edit input[name="harga"]');
    $('#modal-edit').on('hidden.bs.modal', function () {
        modalEdit_nama.val("");
        modalEdit_jenis.val("");
        modalEdit_stok.val("");
        modalEdit_harga.val("");
    });
    $('#table').on('click', '.edit', function(e) {
        e.preventDefault()

        var url = "{{ route('barang.show', ':id') }}";
        url = url.replace(':id', $(this).attr('data-id'));

        $('#modal-edit button[name="submit"]').attr('data-id', $(this).attr('data-id'));
        modalEdit_nama.attr("disabled", true);
        modalEdit_jenis.attr("disabled", true);
        modalEdit_stok.attr("disabled", true);
        modalEdit_harga.attr("disabled", true);
        
        $.ajax({
            url: url,
            method: "GET",
            cache: false,
            processData: false,
            contentType: false
        }).done(function(msg) {
            modalEdit_nama.attr("disabled", false);
            modalEdit_nama.trigger('focus');
            modalEdit_nama.val(msg.data.nama_barang);

            modalEdit_jenis.attr("disabled", false);
            modalEdit_jenis.val(msg.data.jenis_barang);

            modalEdit_stok.attr("disabled", false);
            modalEdit_stok.val(msg.data.stok_barang);

            modalEdit_harga.attr("disabled", false);
            modalEdit_harga.val(msg.data.harga_barang);
        }).fail(function(err) {
            alert("Terjadi kesalahan pada server");
            modalEdit_nama.attr("disabled", false);
            modalEdit_jenis.attr("disabled", false);
            modalEdit_stok.attr("disabled", false);
            modalEdit_harga.attr("disabled", false);
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
            url: '{{ route("barang.store") }}',
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

        var url = "{{ route('barang.update', ':id') }}";
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
        var url = "{{ route('barang.destroy', ':id') }}";
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