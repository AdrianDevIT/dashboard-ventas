<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use Illuminate\Pagination\Paginator;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        Paginator::useBootstrap();
    }

    /*public function index()
    {
        $sales = Sale::paginate(10); // Mostrar 10 ventas por página
        return view('sales.index', compact('sales'));
    }*/

    public function index(Request $request)
    {
        $sales = Sale::query();

        if ($request->filled('search')) {
            $sales->where('product_name', 'like', '%' . $request->search . '%');
        }

        $sales = $sales->paginate(10);

        return view('sales.index', compact('sales'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sales.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0.01',
            'sale_date' => 'required|date',
        ]);

        // Crear y guardar la venta
        Sale::create($validated);

        // Redirigir a la lista de ventas
        return redirect()->route('sales.index')->with('success', 'Venta añadida correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sale = Sale::findOrFail($id);
        return view('sales.edit', compact('sale'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0.01',
            'sale_date' => 'required|date',
        ]);

        $sale = Sale::findOrFail($id);
        $sale->update($validated);

        return redirect()->route('sales.index')->with('success', 'Venta actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Venta eliminada correctamente.');
    }
}
