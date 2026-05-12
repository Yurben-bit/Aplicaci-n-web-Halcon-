<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use Illuminate\Http\Request;

class ArticuloController extends Controller
{
    public function index()
    {
        $articulos = Articulo::paginate(10);
        return response()->json($articulos);
    }

    public function create()
    {
        // Not needed for API
        return response()->json(['message' => 'Use POST to /articulos'], 405);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
        ]);

        $articulo = Articulo::create($request->all());
        return response()->json(['data' => $articulo], 201);
    }

    public function edit($id)
    {
        $articulo = Articulo::findOrFail($id);
        return response()->json(['data' => $articulo]);
    }

    public function update(Request $request, $id)
    {
        $articulo = Articulo::findOrFail($id);
        $articulo->update($request->all());
        return response()->json(['data' => $articulo]);
    }

    public function destroy($id)
    {
        Articulo::destroy($id);
        return response()->json(['message' => 'Article deleted successfully'], 200);
    }
}