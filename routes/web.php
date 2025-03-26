<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;

Route::resource('sales', SaleController::class);

Route::get('/', function () {
    return view('welcome');
});
