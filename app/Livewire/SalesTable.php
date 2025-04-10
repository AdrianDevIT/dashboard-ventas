<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class SalesTable extends Component
{
    use WithPagination;

    public string $search = '';
    public $sortField = 'id';
    public $sortDirection = 'asc';
    public $startDate;
    public $endDate;
    public $sale;

    protected $queryString = [
        'search' => ['except' => '', 'as' => 'q'], // 'q' es opcional, puedes mantener 'search'
        'sortField' => ['except' => 'id'],
        'sortDirection' => ['except' => 'asc'],
        'startDate',
        'endDate'
    ];

    //protected $listeners = ['deleteSale'];
    protected $listeners = ['saleDeleted' => '$refresh'];
    protected $dates = ['sale_date'];
    protected $paginationTheme = 'bootstrap';

    public function query(): Builder
    {
        return Sale::query()
            ->when($this->search, function ($query) {
                $query->where('product_name', 'like', '%' . $this->search . '%');
            })
            ->when($this->startDate, function ($query) {
                $query->whereDate('sale_date', '>=', $this->startDate);
            })
            ->when($this->endDate, function ($query) {
                $query->whereDate('sale_date', '<=', $this->endDate);
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStartDate()
    {
        $this->resetPage();
    }

    public function updatedEndDate()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function render()
    {
        $sales = $this->query()->paginate(10);

        return view('livewire.sales-table', [
            'sales' => $sales
        ]);
    }

    public function deleteSale($id)
    {
        try {
            $sale = Sale::findOrFail($id);
            $sale->delete();
            $this->resetPage();
            session()->flash('message', 'Venta eliminada correctamente.');
        } catch (\Exception $e) {
            session()->flash('message', 'No se pudo eliminar la venta: ' . $e->getMessage());
        }
    }

    public function editSale($id)
    {
        $sale = Sale::findOrFail($id);

        $this->sale = [
            'id' => $sale->id,
            'product_name' => $sale->product_name,
            'quantity' => $sale->quantity,
            'price' => $sale->price,
            'sale_date' => Carbon::parse($sale->sale_date)->format('Y-m-d') // Asegúrate de formatear la fecha
        ];

        $this->dispatch('openModal');
    }

    public function updateSale()
    {
        $this->validate([
            'sale.product_name' => 'required|string|max:255',
            'sale.quantity' => 'required|numeric|min:1',
            'sale.price' => 'required|numeric|min:0',
            'sale.sale_date' => 'required|date',
        ]);

        try {
            // Encuentra el modelo y actualiza sus atributos
            $sale = Sale::findOrFail($this->sale['id']);

            $sale->update([
                'product_name' => $this->sale['product_name'],
                'quantity' => $this->sale['quantity'],
                'price' => $this->sale['price'],
                'sale_date' => $this->sale['sale_date']
            ]);

            $this->dispatch('closeModal');
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Venta actualizada correctamente.'
            ]);

        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Error al actualizar: ' . $e->getMessage()
            ]);
        }
    }

    public function resetModal()
    {
        $this->reset('sale'); // Limpia los datos del formulario
    }

    public function refreshInputs()
    {
        $this->dispatchBrowserEvent('refresh-inputs');
    }
}
