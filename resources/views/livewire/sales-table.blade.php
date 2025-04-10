<div>
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    <!-- Modal de edición -->
    <div class="modal fade" id="editSaleModal" tabindex="-1" wire:ignore.self data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Venta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="updateSale">
                        <div class="mb-3">
                            <label for="product_name" class="form-label">Producto</label>
                            <input type="text" class="form-control" id="product_name" wire:model="sale.product_name"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="quantity" wire:model="sale.quantity"
                                min="1" required>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Precio</label>
                            <input type="number" class="form-control" id="price" wire:model="sale.price"
                                step="0.01" min="0" required>
                        </div>

                        <div class="mb-3">
                            <label for="sale_date" class="form-label">Fecha de venta</label>
                            <input type="date" class="form-control" id="sale_date" wire:model="sale.sale_date"
                                required>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">
                                <span wire:loading.remove>Actualizar venta</span>
                                <span wire:loading>
                                    <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                                    Procesando...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <label for="startDate" class="form-label">Desde:</label>
            <input type="date" id="startDate" wire:model.live.debounce.500ms="startDate" class="form-control">
        </div>
        <div class="col">
            <label for="endDate" class="form-label">Hasta:</label>
            <input type="date" id="endDate" wire:model.live.debounce.500ms="endDate" class="form-control">
        </div>
    </div>

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
                <th colspan="2">Acciones</th>
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
                    <td>{{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y') }}</td>
                    <td>
                        <button wire:click="editSale({{ $sale->id }})" class="btn btn-sm btn-primary">
                            Editar
                        </button>
                    </td>
                    <td>
                        <button wire:click="deleteSale({{ $sale->id }})"
                            wire:confirm="¿Seguro que quieres eliminar esta venta?" class="btn btn-sm btn-danger">
                            Eliminar
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div>
        {{ $sales->links() }}
    </div>
</div>
