@extends('adminlte::page')

@section('title', isset($invLocations) ? 'Edit invLocations' : 'Tambah invLocations')

@section('content_header') <h1>{{ isset($invLocations) ? 'Edit invLocations' : 'Tambah invLocations' }}</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

    <form action="{{ isset($invLocations) ? route('inv-location.update', $invLocations->id) : route('inv-location.store') }}"
          method="POST">

        @csrf

        @if(isset($invLocations))
            @method('PUT')
        @endif

        <div class="form-group">
            <label>Nama</label>
            <input type="text"
                   name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $invLocations->name ?? '') }}"
                   required>

            @error('name')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label>Description</label>
            <textarea name="description"
                      class="form-control @error('description') is-invalid @enderror"
                      required>{{ old('description', $invLocations->description ?? '') }}</textarea>

            @error('description')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">
                {{ isset($invLocations) ? 'Update' : 'Simpan' }}
            </button>

            <a href="{{ route('inv-location.index') }}"
               class="btn btn-secondary">
                Kembali
            </a>
        </div>

    </form>

</div>

</div>

@stop
