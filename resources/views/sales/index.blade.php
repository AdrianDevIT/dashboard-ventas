@extends('layouts.app')

@section('title', 'Lista de Ventas')

@section('content')
    <div class="container">
        <h1 class="mb-4">Listado de Ventas</h1>

        @livewire('sales-table')
    </div>

    <div class="container">
        <h1>Lista de Ventas</h1>

        <a href="{{ route('sales.export') }}" class="btn btn-primary mb-2">
            <i class="fas fa-file-excel"></i> Exportar a Excel
        </a>

        <div class="text-end">
            <i class="fas fa-question-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="top"
                title="Formato esperado: Encabezados en la primera fila (product_name, quantity, price, sale_date). Archivos en formato .xlsx o .csv.">
            </i>
        </div>

        <form action="{{ route('sales.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-2">
                <input type="file" class="form-control" name="file" id="file" required>
            </div>
            <button type="submit" class="btn btn-success w-100 mb-2">
                <i class="fas fa-file-import"></i> Importar Datos
            </button>
        </form>

        @livewire('sales-chart')

        <div class="card mb-4">
            <div class="card-header">Ventas Diarias</div>
            <div class="card-body">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const ctx = document.getElementById('salesChart').getContext('2d');
                const salesData = @json($salesData);

                const labels = salesData.map(sale => sale.date);
                const data = salesData.map(sale => sale.total_sales);

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total Vendido (€)',
                            data: data,
                            borderColor: 'blue',
                            backgroundColor: 'rgba(0, 0, 255, 0.2)',
                            fill: true,
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
        </script>

        <div class="d-flex flex-column align-items-end gap-2 mb-2">
            <a href="{{ route('sales.create') }}" class="btn btn-primary">Añadir venta</a>
            <form action="{{ route('sales.index') }}" method="GET">
                <input type="text" name="search" placeholder="Buscar por producto"
                    value="{{ request()->get('search') }}">
                <button type="submit">Buscar</button>
            </form>
        </div>
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
                @foreach ($sales as $sale)
                    <tr>
                        <td>{{ $sale->id }}</td>
                        <td>{{ $sale->product_name }}</td>
                        <td>{{ $sale->quantity }}</td>
                        <td>{{ $sale->price }}</td>
                        <td>{{ number_format($sale->quantity * $sale->price, 2) }}</td>
                        <td>{{ $sale->sale_date }}</td>
                        <td>
                            <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-warning">Editar</a>
                        </td>
                        <td>
                            <form action="{{ route('sales.destroy', $sale->id) }}" method="POST"
                                onsubmit="return confirm('¿Seguro que quieres eliminar esta venta?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">
        {{ $sales->links() }}
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endsection
