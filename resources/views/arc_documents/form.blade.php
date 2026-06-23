@extends('adminlte::page')

@section('title', isset($arcDocument) ? 'Edit ArcDocument' : 'Tambah ArcDocument')

@section('content_header') <h1>{{ isset($arcDocument) ? 'Edit ArcDocument' : 'Tambah ArcDocument' }}</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

    <form action="{{ isset($arcDocument) ? route('arc-document.update', $arcDocument->id) : route('arc-document.store') }}"
          method="POST" enctype="multipart/form-data">

        @csrf

        @if(isset($arcDocument))
            @method('PUT')
        @endif

        <div class="form-group">
            <label>Kode</label>
            <input type="text"
                   name="code"
                   class="form-control @error('code') is-invalid @enderror"
                   value="{{ old('code', $arcDocument->code ?? '') }}"
                   required>

            @error('code')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label>Judul</label>
            <input type="text"
                   name="title"
                   class="form-control @error('title') is-invalid @enderror"
                   value="{{ old('title', $arcDocument->title ?? '') }}"
                   required>

            @error('title')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label>Deskripsi</label>
            <textarea name="description"
                      class="form-control @error('description') is-invalid @enderror"
                      required>{{ old('description', $arcDocument->description ?? '') }}</textarea>

            @error('description')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label>Register</label>
            <input type="date"
                   name="register"
                   class="form-control @error('register') is-invalid @enderror"
                   value="{{ old('register', isset($arcDocument) ? $arcDocument->register : '') }}"
                   required>

            @error('register')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror
        </div>  
        
    <div class="form-group mt-3">
        <label>Upload File</label>
        <input type="file" name="file" class="form-control">
        @if(isset($arcDocument) && $arcDocument->file_path)
            <p>File saat ini: <a href="{{ asset('storage/' . $arcDocument->file_path) }}" target="_blank">{{ $arcDocument->file_path }}</a></p>
        @endif
    </div>

        <div class="form-group mt-3">
            <label>Status</label>
            <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                <option value="">Pilih Status</option>
                <option value="pending" {{ old('status', $arcDocument->status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ old('status', $arcDocument->status ?? '') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ old('status', $arcDocument->status ?? '') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                <option value="sent" {{ old('status', $arcDocument->status ?? '') == 'sent' ? 'selected' : '' }}>Sent</option>
            </select>
            @error('status')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
                
            @enderror

        </div>

        <div class="form-group mt-3">
            <label>Kategori</label>
            <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                <option value="">Pilih Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $arcDocument->category_id ?? '') == $category->id ? 'selected' : '' }}>
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
            <label>Jenis</label>
            <select name="type" class="form-control @error('type') is-invalid @enderror" required>
                <option value="">Pilih Jenis</option>
                <option value="incoming" {{ old('type', $arcDocument->type ?? '') == 'incoming' ? 'selected' : '' }}>Incoming</option>
                <option value="outgoing" {{ old('type', $arcDocument->type ?? '') == 'outgoing' ? 'selected' : '' }}>Outgoing</option>
            </select>

            @error('type')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">
                {{ isset($arcDocument) ? 'Update' : 'Simpan' }}
            </button>

            <a href="{{ route('arc-document.index') }}"
               class="btn btn-secondary">
                Kembali
            </a>
        </div>

    </form>

</div>

</div>

@stop
