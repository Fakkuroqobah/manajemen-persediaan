@extends('layouts.index')

@section('title', 'Retur')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Retur</li>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.modal-content {
    position: relative;
}
.modal-content .overlay {
    position: absolute;
    width: 100%;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #000000a6;
    z-index: 99;
}
</style>
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
                        <th>Barang</th>
                        <th>Tanggal retur</th>
                        <th>Deskripsi</th>
                        <th>Jumlah</th>
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
            <div class="loading overlay d-none">
                <div class="">
                    <h3 class="text-white text-center mt-5">Loading...</h3>
                </div>
            </div>
            
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
                        <label for="">Penjualan</label>
                        <select name="id_penjualan" class="form-control select-barang" id="id_penjualan">
                            <option value="">Pilih penjualan</option>
                            @foreach ($barang as $item)
                                <option value="{{ $item->id_penjualan }}">ID: {{ $item->id_penjualan }}, Customer: {{ $item->customer->nama_customer }}, Total Barang: {{ $item->barang->count() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Barang</label>
                        <select name="id_penjualan_detail" class="form-control select-barang" id="id_penjualan_detail">
                            <option value="">Pilih barang yang di retur</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal retur</label>
                        <input type="date" name="tanggal" class="form-control" placeholder="Keluaran tanggal barang keluar" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">Deskripsi</label>
                        <textarea name="deskripsi" id="" cols="30" rows="3" class="form-control" placeholder="Masukan deskripsi"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Jumlah</label>
                        <input type="number" name="jumlah" class="form-control" placeholder="Masukan jumlah" autocomplete="off">
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
                        <label for="">Penjualan</label>
                        <select name="id_penjualan" class="form-control" id="">
                            <option value="">Pilih penjualan</option>
                            @foreach ($barang as $item)
                                <option value="{{ $item->id_penjualan }}">ID: {{ $item->id_penjualan }}, Customer: {{ $item->customer->nama_customer }}</option>
                            @endforeach    
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal retur</label>
                        <input type="date" name="tanggal" class="form-control" placeholder="Keluaran tannggal barang keluar" autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" name="close-modal" class="btn btn-secondary mt-3" data-dismiss="modal">Tutup</button>
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

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
function updateEl(data) {
    var url = "{{ route('find', ['id' => ':id']) }}";
        url = url.replace(':id', data.val());

    $('.loading').removeClass('d-none');

    var $select = $('#id_penjualan_detail');
    $select.empty();
    $select.append($(`<option value=''>--Pilih--</option>`));

    return $.ajax({
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        url: url,
        method: "GET"
    }).done(function(data) {
        var newOptions = data.data;

        if(newOptions.length > 0){
            for(var i=0; i < newOptions.length; i++){
                $select.append($(`<option value='${newOptions[i].id_penjualan_detail}'>${newOptions[i].barang.nama_barang} - ${newOptions[i].jumlah_barang_keluar} barang</option>`));
            }
        }

        $('.loading').addClass('d-none');
    }).fail(function(){
        $('.loading').addClass('d-none');
    });
}
$(document).ready(function() {
    $('.select-barang').select2({ width: '100%' });

    $('#id_penjualan').change( function(){
        updateEl($(this));
    });

    var table = $('#table').DataTable({
        processing: true,
        ajax: '{{ route("retur.index") }}',
        columns: [
            { data: 'DT_RowIndex', name:'DT_RowIndex', searchable: false },
            { data: 'penjualan.barang_keluar.customer.nama_customer', name: 'nama_customer' },
            { data: 'penjualan.barang.nama_barang', name: 'nama_barang' },
            { data: 'tanggal_barang_retur', name: 'tanggal_barang_retur' },
            { data: 'deskripsi', name: 'deskripsi' },
            { data: 'jumlah', name: 'jumlah' },
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
    

    var modalEdit_id_barang = $('#modal-edit select[name="id_barang"]');
    var modalEdit_tanggal = $('#modal-edit input[name="tanggal"]');
    $('#modal-edit').on('hidden.bs.modal', function () {
        modalEdit_id_barang.val("");
        modalEdit_tanggal.val("");
    });
    $('#table').on('click', '.edit', function(e) {
        e.preventDefault()

        var url = "{{ route('penjualan.show', ':id') }}";
        url = url.replace(':id', $(this).attr('data-id'));

        $('#modal-edit button[name="submit"]').attr('data-id', $(this).attr('data-id'));
        modalEdit_id_barang.attr("disabled", true);
        modalEdit_tanggal.attr("disabled", true);
        
        $.ajax({
            url: url,
            method: "GET",
            cache: false,
            processData: false,
            contentType: false
        }).done(function(msg) {
            modalEdit_id_barang.attr("disabled", false);
            modalEdit_id_barang.trigger('focus');
            modalEdit_id_barang.val(msg.data.id_barang);

            modalEdit_tanggal.attr("disabled", false);
            modalEdit_tanggal.val(msg.data.tanggal_penjualan);
        }).fail(function(err) {
            alert("Terjadi kesalahan pada server");
            modalEdit_id_barang.attr("disabled", false);
            modalEdit_tanggal.attr("disabled", false);
        });
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
            url: '{{ route("retur.store") }}',
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

        var url = "{{ route('retur.update', ':id') }}";
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
        var url = "{{ route('retur.destroy', ':id') }}";
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