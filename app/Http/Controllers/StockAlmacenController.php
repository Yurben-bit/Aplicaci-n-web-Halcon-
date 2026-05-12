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
        return response()->json($stocks);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Not needed for API
        return response()->json(['message' => 'Use POST to /stockAlmacenes'], 405);
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

        $stock = StockAlmacen::create([
            'materialesId' => $request->materialesId,
            'cantidadStock' => $request->cantidadStock,
            'stockMinimo' => $request->stockMinimo,
            'stockMaximo' => $request->stockMaximo,
        ]);

        return response()->json(['data' => $stock], 201);
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
        // Not needed for API
        return response()->json(['data' => $stockAlmacen]);
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

        return response()->json(['data' => $stockAlmacen]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockAlmacen $stockAlmacen)
    {
        $stockAlmacen->delete();
        return response()->json(['message' => 'Stock record deleted successfully'], 200);
    }
}