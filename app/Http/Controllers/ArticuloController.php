<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use Illuminate\Http\Request;

class ArticuloController extends Controller
{
    public function index()
    {
        $articulos = Articulo::all();
        return view('articulos.index', compact('articulos'));
    }

    public function create()
    {
        return view('articulos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
        ]);

        Articulo::create($request->all());
        return redirect()->route('articulos.index')->with('success', 'Creado correctamente');
    }

    public function edit($id)
    {
        $articulo = Articulo::findOrFail($id);
        return view('articulos.edit', compact('articulo'));
    }

    public function update(Request $request, $id)
    {
        $articulo = Articulo::findOrFail($id);
        $articulo->update($request->all());
        return redirect()->route('articulos.index')->with('success', 'Actualizado');
    }

    public function destroy($id)
    {
        Articulo::destroy($id);
        return redirect()->route('articulos.index')->with('success', 'Eliminado');
    }
}