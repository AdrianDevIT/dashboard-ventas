<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;

class SalesExport implements FromCollection
{
    public function collection()
    {
        return Sale::all(['sale_date', 'product_name', 'quantity', 'price']);
    }
}