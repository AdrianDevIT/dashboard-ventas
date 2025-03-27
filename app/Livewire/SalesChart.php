<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class SalesChart extends Component
{
    public $salesData = [];

    public function mount()
    {
        $locale = App::getLocale();

        $sales = Sale::selectRaw('MONTH(sale_date) as month, SUM(quantity) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        foreach ($sales as $sale) {
            $monthName = Carbon::create()->month($sale->month)->locale($locale)->translatedFormat('F');
            $salesData[$monthName] = $sale->total;
        }

        $this->salesData = $salesData;
    }

    public function render()
    {
        return view('livewire.sales-chart');
    }
}
