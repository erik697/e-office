@extends('adminlte::page')

@section('title', isset($invProducts) ? 'Edit invProducts' : 'Tambah invProducts')

@section('content_header') <h1>{{ isset($invProducts) ? 'Edit invProducts' : 'Tambah invProducts' }}</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

    <form action="{{ isset($invProducts) ? route('inv-product.update', $invProducts->id) : route('inv-product.store') }}"
          method="POST">

        @csrf

        @if(isset($invProducts))
            @method('PUT')
        @endif

        <div class="form-group">
            <label>Code</label>
            <input type="text"
                   name="code"
                   class="form-control @error('code') is-invalid @enderror"
                   value="{{ old('code', $invProducts->code ?? '') }}"
                   required>

            @error('code')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label>Nama</label>
            <input type="text"
                   name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $invProducts->name ?? '') }}"
                   required>

            @error('name')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label>Category</label>
            <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                <option value="">Pilih Category</option>
                @foreach($invCategories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $invProducts->category_id ?? '') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            @error('category_id')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror
        </div>
        <div class="form-group mt-3">
            <label>Description</label>
            <textarea name="description"
                      class="form-control @error('description') is-invalid @enderror"
                      required>{{ old('description', $invProducts->description ?? '') }}</textarea>

            @error('description')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror
        </div>
        <div class="form-group mt-3">
            <label>Location</label>
            <select name="location_id" class="form-control @error('location_id') is-invalid @enderror" required>
                <option value="">Pilih Location</option>
                @foreach($invLocations as $location)
                    <option value="{{ $location->id }}" {{ old('location_id', $invProducts->location_id ?? '') == $location->id ? 'selected' : '' }}>
                        {{ $location->name }}
                    </option>
                @endforeach
            </select>

            @error('location_id')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">
                {{ isset($invProducts) ? 'Update' : 'Simpan' }}
            </button>

            <a href="{{ route('inv-product.index') }}"
               class="btn btn-secondary">
                Kembali
            </a>
        </div>

    </form>

</div>

</div>

@stop
