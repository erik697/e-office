@extends('adminlte::page')

@section('title', isset($invCategories) ? 'Edit invCategories' : 'Tambah invCategories')

@section('content_header') <h1>{{ isset($invCategories) ? 'Edit invCategories' : 'Tambah invCategories' }}</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

    <form action="{{ isset($invCategories) ? route('inv-category.update', $invCategories->id) : route('inv-category.store') }}"
          method="POST">

        @csrf

        @if(isset($invCategories))
            @method('PUT')
        @endif

        <div class="form-group">
            <label>Nama</label>
            <input type="text"
                   name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $invCategories->name ?? '') }}"
                   required>

            @error('name')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror
        </div>

        {{-- <div class="form-group mt-3">
            <label>Email</label>
            <input type="email"
                   name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email', $invCategories->email ?? '') }}"
                   required>

            @error('email')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label>No HP</label>
            <input type="text"
                   name="phone"
                   class="form-control @error('phone') is-invalid @enderror"
                   value="{{ old('phone', $invCategories->phone ?? '') }}">

            @error('phone')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror
        </div> --}}

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">
                {{ isset($invCategories) ? 'Update' : 'Simpan' }}
            </button>

            <a href="{{ route('inv-category.index') }}"
               class="btn btn-secondary">
                Kembali
            </a>
        </div>

    </form>

</div>

</div>

@stop
