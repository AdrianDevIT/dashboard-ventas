<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Builder;

class SalesTable extends Component
{
    use WithPagination;

    public string $search = '';
    public $sortField = 'id';
    public $sortDirection = 'asc';

    protected $queryString = [
        'search' => ['except' => '', 'as' => 'q'], // 'q' es opcional, puedes mantener 'search'
        'sortField' => ['except' => 'id'],
        'sortDirection' => ['except' => 'asc'],
    ];

    protected $paginationTheme = 'bootstrap';

    public function query(): Builder
    {
        return Sale::query()
            ->when($this->search, function ($query) {
                $query->where('product_name', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function updatedSearch()
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
}
