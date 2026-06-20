@extends('adminlte::page')

@section('title', 'inv-location')

@section('content_header')
<div class="d-flex justify-content-between">
    <h1>Lokasi Inventaris</h1>

    <a href="{{ route('inv-location.create') }}"
       class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Data
    </a>
</div>
@stop


@section('content')

<div class="card">
    <div class="card-body">
@if(session('success'))
    <x-adminlte-alert theme="success" title="Sukses" dismissable>
        {{ session('success') }}
    </x-adminlte-alert>
@endif

        <table id="inv-location-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Description</th>
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
$(function () {

    $('#inv-location-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,

        ajax: "{{ route('inv-location.data') }}",

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
            { data: 'name', name: 'name' },
            // { data: 'email', name: 'email' },
            // { data: 'created_at', name: 'created_at' },
            { data: 'description', name: 'description' },
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

});

$(document).on('click', '.btn-edit', function () {

    let id = $(this).data('id');

        window.location.href = '/inv-location/' + id + '/edit';

});

$(document).on('click', '.btn-delete', function () {

    let id = $(this).data('id');

    if(confirm('Hapus data?')) {

        $.ajax({
            url: '/inv-location/' + id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                alert('Data berhasil dihapus');
                $('#inv-location-table').DataTable().ajax.reload();
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

    window.location.href = '/inv-location/' + id;

});
</script>


@stop
