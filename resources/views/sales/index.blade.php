@extends('layouts.app')

@section('title', 'Lista de Ventas')

@section('content')
    <div class="container">
        <h1>Lista de Ventas</h1>
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $sale)
                    <tr>
                        <td>{{ $sale->id }}</td>
                        <td>{{ $sale->product_name }}</td>
                        <td>{{ $sale->quantity }}</td>
                        <td>{{ $sale->price }}</td>
                        <td>{{ $sale->total }}</td>
                        <td>{{ $sale->sale_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

