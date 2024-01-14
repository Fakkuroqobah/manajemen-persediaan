@extends('layouts.index')

@section('title', 'Kasir')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Kasir</li>
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
                        <th>Username</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
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
                        <label for="">Nama kasir</label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukan nama kasir" autofocus autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">Alamat kasir</label>
                        <input type="text" name="alamat" class="form-control" placeholder="Masukan alamat kasir" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">Telepon kasir</label>
                        <input type="number" name="telepon" class="form-control" placeholder="Masukan telepon kasir" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">Username kasir</label>
                        <input type="text" name="username" class="form-control" placeholder="Masukan username kasir" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">Password kasir</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukan password kasir" autocomplete="off">
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
                        <label for="">Nama kasir</label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukan nama kasir" autofocus autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">Alamat kasir</label>
                        <input type="text" name="alamat" class="form-control" placeholder="Masukan alamat kasir" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">Telepon kasir</label>
                        <input type="number" name="telepon" class="form-control" placeholder="Masukan telepon kasir" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">Username kasir</label>
                        <input type="text" name="username" class="form-control" placeholder="Masukan username kasir" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">Password kasir</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukan password kasir" autocomplete="off">
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
        ajax: '{{ route("kasir.index") }}',
        columns: [
            { data: 'DT_RowIndex', name:'DT_RowIndex', searchable: false },
            { data: 'id_kasir', name: 'id_kasir' },
            { data: 'username', name: 'username' },
            { data: 'nama_kasir', name: 'nama_kasir' },
            { data: 'alamat_kasir', name: 'alamat_kasir' },
            { data: 'telepon_kasir', name: 'telepon_kasir' },
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
                    columns: [0,1,2,3,4]
                }
            }
        ]
    });
    

    var modalEdit_nama = $('#modal-edit input[name="nama"]');
    var modalEdit_alamat = $('#modal-edit input[name="alamat"]');
    var modalEdit_telepon = $('#modal-edit input[name="telepon"]');
    var modalEdit_username = $('#modal-edit input[name="username"]');
    $('#modal-edit').on('hidden.bs.modal', function () {
        modalEdit_nama.val("");
        modalEdit_alamat.val("");
        modalEdit_telepon.val("");
        modalEdit_username.val("");
    });
    $('#table').on('click', '.edit', function(e) {
        e.preventDefault()

        var url = "{{ route('kasir.show', ':id') }}";
        url = url.replace(':id', $(this).attr('data-id'));

        $('#modal-edit button[name="submit"]').attr('data-id', $(this).attr('data-id'));
        modalEdit_nama.attr("disabled", true);
        modalEdit_alamat.attr("disabled", true);
        modalEdit_telepon.attr("disabled", true);
        modalEdit_username.attr("disabled", true);
        
        $.ajax({
            url: url,
            method: "GET",
            cache: false,
            processData: false,
            contentType: false
        }).done(function(msg) {
            modalEdit_nama.attr("disabled", false);
            modalEdit_nama.trigger('focus');
            modalEdit_nama.val(msg.data.nama_kasir);

            modalEdit_alamat.attr("disabled", false);
            modalEdit_alamat.val(msg.data.alamat_kasir);

            modalEdit_telepon.attr("disabled", false);
            modalEdit_telepon.val(msg.data.telepon_kasir);

            modalEdit_username.attr("disabled", false);
            modalEdit_username.val(msg.data.username);
        }).fail(function(err) {
            alert("Terjadi kesalahan pada server");
            modalEdit_nama.attr("disabled", false);
            modalEdit_alamat.attr("disabled", false);
            modalEdit_telepon.attr("disabled", false);
            modalEdit_username.attr("disabled", false);
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
            url: '{{ route("kasir.store") }}',
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

        var url = "{{ route('kasir.update', ':id') }}";
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
        var url = "{{ route('kasir.destroy', ':id') }}";
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