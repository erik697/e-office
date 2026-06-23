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
            <label>Transaction Date</label>
            <input type="date"
                   name="register"
                   class="form-control @error('register') is-invalid @enderror"
                   value="{{ old('register', isset($invTransaction) ? $invTransaction->register : '') }}"
                   required>

            @error('register')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label>Transaction Type</label>
            <input type="text"
                   name="transaction_type"
                   class="form-control @error('transaction_type') is-invalid @enderror"
                   value="{{ old('transaction_type', $invTransaction->transaction_type ?? '') }}"
                   required>

            @error('transaction_type')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror
        </div>
        
        <div class="card">
    <div class="card-header">
        <button type="button" id="btn-add-row" class="btn btn-success">
            <i class="fas fa-plus"></i> Tambah Produk
        </button>
    </div>


<div class="card-body">

    <table class="table table-bordered" id="product-table">
        <thead>
            <tr>
                <th width="50">No</th>
                <th>Produk</th>
                <th width="150">Qty</th>
                <th width="80">Aksi</th>
            </tr>
        </thead>
        <tbody>
@foreach($invTransaction->products as $index => $item)
            <tr>
                <td class="row-number">{{ $index + 1 }}</td>

                <td>
                    <select name="product_id[]"
                            class="form-control"
                            required>
                        <option value="">Pilih Produk</option>

                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ $item->id == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </td>

                <td>
                    <input type="number"
                           name="quantity[]"
                           class="form-control"
                           min="1"
                           value="{{ $item->pivot->quantity }}"
                           required>
                </td>

                <td>
                    <button type="button"
                            class="btn btn-danger btn-remove-row">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
@endforeach
        </tbody>
    </table>

</div>

</div>


        <div class="form-group">
            <label>Note</label>
            <input type="text"
                   name="note"
                   class="form-control @error('note') is-invalid @enderror"
                   value="{{ old('note', $invTransaction->note ?? '') }}"
                   required>

            @error('note')
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

@section('js')
<script>

$(function(){

    $('#btn-add-row').click(function(){

        let row = `
            <tr>
                <td class="row-number"></td>

                <td>
                    <select name="product_id[]" class="form-control" required>
                        <option value="">Pilih Produk</option>

                        @foreach($products as $product)
                            <option value="{{ $product->id }}">
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </td>

                <td>
                    <input type="number"
                           name="quantity[]"
                           class="form-control"
                           min="1"
                           value="1"
                           required>
                </td>

                <td>
                    <button type="button"
                            class="btn btn-danger btn-remove-row">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;

        $('#product-table tbody').append(row);

        renumberRows();
    });

    $(document).on('click', '.btn-remove-row', function(){

        if ($('#product-table tbody tr').length > 1) {
            $(this).closest('tr').remove();
            renumberRows();
        }

    });

    function renumberRows() {

        $('#product-table tbody tr').each(function(index){

            $(this)
                .find('.row-number')
                .text(index + 1);

        });

    }

});
</script>
@stop