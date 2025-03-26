<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sale;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sale::create([
            'product_name' => 'Producto A',
            'quantity' => 10,
            'price' => 20.50,
            'total' => 10 * 20.50,
            'sale_date' => now()->subDays(2),
        ]);

        Sale::create([
            'product_name' => 'Producto B',
            'quantity' => 5,
            'price' => 15.75,
            'total' => 5 * 15.75,
            'sale_date' => now()->subDays(1),
        ]);

        Sale::create([
            'product_name' => 'Producto C',
            'quantity' => 8,
            'price' => 12.99,
            'total' => 8 * 12.99,
            'sale_date' => now(),
        ]);
    }
}
