@extends('adminlte::page')

@section('title', isset($arcCategories) ? 'Edit ArcCategories' : 'Tambah ArcCategories')

@section('content_header') <h1>{{ isset($arcCategories) ? 'Edit ArcCategories' : 'Tambah ArcCategories' }}</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

    <form action="{{ isset($arcCategories) ? route('arc-category.update', $arcCategories->id) : route('arc-category.store') }}"
          method="POST">

        @csrf

        @if(isset($arcCategories))
            @method('PUT')
        @endif

        <div class="form-group">
            <label>Nama</label>
            <input type="text"
                   name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $arcCategories->name ?? '') }}"
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
                   value="{{ old('email', $arcCategories->email ?? '') }}"
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
                   value="{{ old('phone', $arcCategories->phone ?? '') }}">

            @error('phone')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror
        </div> --}}

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">
                {{ isset($arcCategories) ? 'Update' : 'Simpan' }}
            </button>

            <a href="{{ route('arc-category.index') }}"
               class="btn btn-secondary">
                Kembali
            </a>
        </div>

    </form>

</div>

</div>

@stop
