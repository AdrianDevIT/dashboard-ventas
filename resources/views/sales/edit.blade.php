@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Venta</h2>
    <form action="{{ route('sales.update', $sale->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Producto</label>
            <input type="text" name="product_name" class="form-control" value="{{ $sale->product_name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Cantidad</label>
            <input type="number" name="quantity" class="form-control" value="{{ $sale->quantity }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Precio</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ $sale->price }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha de Venta</label>
            <input type="date" name="sale_date" class="form-control" value="{{ $sale->sale_date }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection
