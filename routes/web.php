<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;
use App\Exports\SalesExport;
use Maatwebsite\Excel\Facades\Excel;

//Route::get('/sales/export', [SaleController::class, 'export'])->name('sales.export');

Route::resource('sales', SaleController::class);

Route::get('/export-sales', [SaleController::class, 'export'])->name('sales.export');
Route::post('/import-sales', [SaleController::class, 'import'])->name('sales.import');


Route::get('/', function () {
    return view('welcome');
});
