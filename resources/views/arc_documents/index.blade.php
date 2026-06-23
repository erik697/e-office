@extends('adminlte::page')

@section('title', 'arc-document')

@section('content_header')
<div class="d-flex justify-content-between">
    <h1>Dokumen Arsip</h1>

    <a href="{{ route('arc-document.create') }}"
       class="btn btn-primary">
       
        {{-- <i class="fas fa-plus"></i> Tambah Data  {!! QrCode::size(50)->generate($user->id) !!} --}}
    </a>
</div>
@stop


@section('content')

<div class="card">
    <div class="card-body">
    <div class="row mb-3">
    <div class="col-md-3">
        <label>Kategori</label>
        <select id="filter_category" class="form-control">
            <option value="">Semua Kategori</option>
            {{-- @foreach($categories as $category)
                <option value="{{ $category->id }}">
                    {{ $category->name }}
                </option>
            @endforeach --}}
        </select>
    </div>

    <div class="col-md-3">
        <label>Status</label>
        <select id="filter_status" class="form-control">
            <option value="">Semua Status</option>
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
            <option value="sent">Sent</option>
        </select>
    </div>
    <div class="col-md-3">
        <label>Jenis Dokumen</label>
        <select id="filter_type" class="form-control">
            <option value="">Semua Jenis</option>
            <option value="Incoming">Incoming</option>
            <option value="Outgoing">Outgoing</option>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-3">
        <label>Tanggal Awal</label>
        <input type="date" id="date_from" class="form-control">
    </div>

    <div class="col-md-3">
        <label>Tanggal Akhir</label>
        <input type="date" id="date_to" class="form-control">
    </div>

    <div class="col-md-2 d-flex align-items-end">
        <button id="btn-filter" class="btn btn-primary">
            Filter
        </button>
    </div>

    <div class="col-md-2 d-flex align-items-end">
        <button id="btn-reset" class="btn btn-secondary">
            Reset
        </button>
    </div>
</div>
    </div>

    <div class="card-body">
@if(session('success'))
    <x-adminlte-alert theme="success" title="Sukses" dismissable>
        {{ session('success') }}
    </x-adminlte-alert>
@endif

        <table id="arc-document-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Register</th>
                    <th>Status</th>
                    <th>Kategori</th>
                    <th>Jenis</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
        </table>

    </div>
</div>

@stop

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('js')

<script>

    let table = $('#arc-document-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        scrollX: true,

        ajax: {
        url: "{{ route('arc-document.data') }}",
        data: function(d) {
            d.category_id = $('#filter_category').val();
            d.status = $('#filter_status').val();
            d.type = $('#filter_type').val();
            d.date_from = $('#date_from').val();
            d.date_to = $('#date_to').val(); 
        }
    },
        

        columns: [
            {
                data: null,
                name: 'no',
                searchable: false,
                orderable: false,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            // { data: 'id', name: 'id' },
            { data: 'code', name: 'code' },
            { data: 'title', name: 'title' },
            { data: 'description', name: 'description' },
            { data: 'register', name: 'register' },
            { data: 'status', name: 'status' },
            { data: 'category.name', name: 'category.name' },
            { data: 'type', name: 'type' },

            // { data: 'email', name: 'email' },
            // { data: 'created_at', name: 'created_at' },
            {
                data: 'action',
                name: 'action',
                searchable: false,
                orderable: false
            }
        ],

        pageLength: 10,
        dom: 'Bfrtip',

        buttons: [
            'copy',
            'csv',
            'excel',
            'pdf',
            'print'
        ],

        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            paginate: {
                previous: "Sebelumnya",
                next: "Berikutnya"
            }
        }
    });


$(document).on('click', '.btn-edit', function () {

    let id = $(this).data('id');

        window.location.href = '/arc-document/' + id + '/edit';

});

$(document).on('click', '.btn-delete', function () {

    let id = $(this).data('id');

    if(confirm('Hapus data?')) {

        $.ajax({
            url: '/arc-document/' + id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                alert('Data berhasil dihapus');
                $('#arc-document-table').DataTable().ajax.reload();
            },
            error: function(xhr) {
                console.log(xhr);
                console.log(xhr.status);
                console.log(xhr.responseText);
                alert('Gagal menghapus data');
            }
        });

    }

});

$(document).on('click', '.btn-detail', function () {

    let id = $(this).data('id');

    window.location.href = '/arc-document/' + id;

});

$('#filter_category, #filter_status, #filter_type').change(function() {
    table.ajax.reload();
});

$('#btn-filter').click(function () {
    table.ajax.reload();
});

$('#btn-reset').click(function () {
    $('#date_from').val('');
    $('#date_to').val('');
    table.ajax.reload();
});

</script>


@stop
