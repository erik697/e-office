@extends('adminlte::page')

@section('title', isset($dsrCategories) ? 'Edit DsrCategories' : 'Tambah DsrCategories')

@section('content_header') <h1>{{ isset($dsrCategories) ? 'Edit DsrCategories' : 'Tambah DsrCategories' }}</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

    <form action="{{ isset($dsrCategories) ? route('dsr-category.update', $dsrCategories->id) : route('dsr-category.store') }}"
          method="POST">

        @csrf

        @if(isset($dsrCategories))
            @method('PUT')
        @endif

        <div class="form-group">
            <label>Nama</label>
            <input type="text"
                   name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $dsrCategories->name ?? '') }}"
                   required>

            @error('name')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">
                {{ isset($dsrCategories) ? 'Update' : 'Simpan' }}
            </button>

            <a href="{{ route('dsr-category.index') }}"
               class="btn btn-secondary">
                Kembali
            </a>
        </div>

    </form>

</div>

</div>

@stop
