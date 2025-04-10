<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Sale;
use App\Models\ImportLog;
use App\Exports\SalesExport;
use App\Imports\SalesImport;


class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        Paginator::useBootstrap();
    }

    public function index(Request $request)
    {
        $sales = Sale::query();

        if ($request->filled('search')) {
            $sales->where('product_name', 'like', '%' . $request->search . '%');
        }

        $sales = $sales->paginate(10);

        // Obtener datos para el gráfico
        $salesData = Sale::selectRaw('DATE(sale_date) as date, SUM(quantity * price) as total_sales')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('sales.index', compact('sales', 'salesData'));
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

    public function export()
    {
        return Excel::download(new SalesExport, 'sales.xlsx');
    }

    public function import(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,csv',
            ]);

            $import = new SalesImport();
            Excel::import($import, $request->file('file'));

            // Guardar en la base de datos
            ImportLog::create([
                'file_name' => $request->file('file')->getClientOriginalName(),
                'total_records' => $import->getRowCount(), // Si SalesImport tiene un método para contar filas
                'status' => 'success'
            ]);

            return redirect()->back()->with('success', 'Datos importados correctamente. Total de registros: ' . $import->getRowCount() . '.');
        } catch (\Exception $e) {
            ImportLog::create([
                'file_name' => $request->file('file')->getClientOriginalName(),
                'status' => 'failed',
                'error_message' => $e->getMessage()
            ]);

            return back()->back()->with('error', 'Hubo un error en la importación.');
        }
    }
}
