@extends('adminlte::page')

@section('title', isset($invTransaction) ? 'Edit invTransactions' : 'Tambah invTransactions')

@section('content_header') <h1>{{ isset($invTransaction) ? 'Edit invTransaction' : 'Tambah invTransaction' }}</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

    <form action="{{ isset($invTransaction) ? route('inv-transaction.update', $invTransaction->id) : route('inv-transaction.store') }}"
          method="POST">

        @csrf

        @if(isset($invTransaction))
            @method('PUT')
        @endif

        <div class="form-group">
            <label>Type</label>
            <input type="text"
                   name="type"
                   class="form-control @error('type') is-invalid @enderror"
                   value="{{ old('type', $invTransaction->type ?? '') }}"
                   required>

            @error('type')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label>Status</label>
            <input type="text"
                   name="status"
                   class="form-control @error('status') is-invalid @enderror"
                   value="{{ old('status', $invTransaction->status ?? '') }}"
                   required>

            @error('status')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror
        </div>



        <div class="mt-4">
            <button type="submit" class="btn btn-primary">
                {{ isset($invTransaction) ? 'Update' : 'Simpan' }}
            </button>

            <a href="{{ route('inv-transaction.index') }}"
               class="btn btn-secondary">
                Kembali
            </a>
        </div>

    </form>

</div>

</div>

@stop
