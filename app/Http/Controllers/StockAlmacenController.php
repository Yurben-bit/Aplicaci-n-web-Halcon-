<?php

namespace App\Http\Controllers;

use App\Models\StockAlmacen;
use App\Models\Material; // Importante para cargar la lista de materiales en el form
use Illuminate\Http\Request;

class StockAlmacenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Usamos paginate(10) igual que en MaterialController
        // Eager loading con 'material' para evitar muchas consultas a la DB
        $stocks = StockAlmacen::with('material')->paginate(10);
        return view('stock_almacens.index', compact('stocks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Necesitamos los materiales para el select del formulario
        $materials = Material::all();
        return view('stock_almacens.create', compact('materials'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'materialesId' => 'required|exists:materials,id',
            'cantidadStock' => 'required|integer|min:0',
            'stockMinimo' => 'required|integer|min:0',
            'stockMaximo' => 'required|integer|min:0',
        ]);

        StockAlmacen::create([
            'materialesId' => $request->materialesId,
            'cantidadStock' => $request->cantidadStock,
            'stockMinimo' => $request->stockMinimo,
            'stockMaximo' => $request->stockMaximo,
        ]);

        return redirect()->route('stock_almacens.index')->with('success', 'Registro de stock creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(StockAlmacen $stockAlmacen)
    {
        return redirect()->route('stock_almacens.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockAlmacen $stockAlmacen)
    {
        $materials = Material::all();
        // El nombre de la variable 'stockAlmacen' debe coincidir con lo que pases a compact
        return view('stock_almacens.edit', compact('stockAlmacen', 'materials'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StockAlmacen $stockAlmacen)
    {
        $request->validate([
            'materialesId' => 'required|exists:materials,id',
            'cantidadStock' => 'required|integer|min:0',
            'stockMinimo' => 'required|integer|min:0',
            'stockMaximo' => 'required|integer|min:0',
        ]);

        $stockAlmacen->update([
            'materialesId' => $request->materialesId,
            'cantidadStock' => $request->cantidadStock,
            'stockMinimo' => $request->stockMinimo,
            'stockMaximo' => $request->stockMaximo,
        ]);

        return redirect()->route('stock_almacens.index')->with('success', 'Registro de stock actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockAlmacen $stockAlmacen)
    {
        $stockAlmacen->delete();
        return redirect()->route('stock_almacens.index')->with('success', 'Registro de stock eliminado correctamente.');
    }
}