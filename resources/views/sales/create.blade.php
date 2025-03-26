<!-- resources/views/sales/create.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Añadir nueva venta</h2>
        
        <!-- El formulario para agregar una venta -->
        <form action="{{ route('sales.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="product_name">Producto</label>
                <input type="text" class="form-control" id="product_name" name="product_name" required>
            </div>

            <div class="form-group">
                <label for="quantity">Cantidad</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>

            <div class="form-group">
                <label for="price">Precio</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="sale_date">Fecha de venta</label>
                <input type="date" class="form-control" id="sale_date" name="sale_date" required>
            </div>

            <button type="submit" class="btn btn-primary">Añadir venta</button>
        </form>
    </div>
@endsection
