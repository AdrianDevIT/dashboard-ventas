<div>
    <input type="text" wire:model.live.debounce.500ms="search" class="form-control mb-3"
        placeholder="Buscar producto...">

    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th wire:click="sortBy('id')" style="cursor: pointer;">
                    ID
                    @if ($sortField === 'id')
                        @if ($sortDirection === 'asc')
                            ↑
                        @else
                            ↓
                        @endif
                    @endif
                </th>
                <th wire:click="sortBy('product_name')" style="cursor: pointer;">
                    Producto
                    @if ($sortField === 'product_name')
                        @if ($sortDirection === 'asc')
                            ↑
                        @else
                            ↓
                        @endif
                    @endif
                </th>
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
                </tr>
            @endforeach
        </tbody>
    </table>

    <div>
        {{ $sales->links() }}
    </div>
</div>
