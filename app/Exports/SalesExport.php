<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Sale::all(['id', 'sale_date', 'product_name', 'quantity', 'price']);
    }

    public function headings(): array
    {
        return ['ID', 'Fecha', 'Producto', 'Cantidad', 'Precio'];
    }
}