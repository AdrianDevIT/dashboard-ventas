<?php

namespace App\Imports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SalesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    private $rowCount = 0; // Contador de filas

    public function model(array $row)
    {
        $this->rowCount++; // Incrementa el contador en cada fila importada

        return new Sale([
            'product_name' => $row['product_name'],
            'quantity' => $row['quantity'],
            'price' => $row['price'],
            'sale_date' => \Carbon\Carbon::parse($row['sale_date']),
        ]);
    }

    // Método para obtener el número de filas procesadas
    public function getRowCount()
    {
        return $this->rowCount;
    }
}
