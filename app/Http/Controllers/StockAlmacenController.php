<?php

namespace App\Http\Controllers;

use App\Models\StockAlmacen;
use Illuminate\Http\Request;

class StockAlmacenController extends Controller
{
    // Mostrar lista de stock
    public function index()
    {
        $stocks = StockAlmacen::with('material')->get();
        return view('stock.index', compact('stocks'));
    }

    // Guardar nuevo registro de stock
    public function store(Request $request)
    {
        $request->validate([
            'materialesId' => 'required|exists:materiales,id',
            'cantidadStock' => 'required|integer',
            'stockMinimo' => 'required|integer',
            'stockMaximo' => 'required|integer',
        ]);

        StockAlmacen::create($request->all());

        return redirect()->back()->with('success', 'Stock actualizado correctamente.');
    }

    // Actualizar stock existente
    public function update(Request $request, $id)
    {
        $stock = StockAlmacen::findOrFail($id);
        $stock->update($request->all());

        return redirect()->back()->with('success', 'Stock modificado.');
    }
}