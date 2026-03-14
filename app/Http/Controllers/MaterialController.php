<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() // USAR
    {
        $materials = Material::paginate(10);
        return view('materials.index', compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() // USAR
    {
        return view('materials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'clave_material' => 'required|integer|unique:materials',
            'descripcion_material' => 'required|string',
            'precio_unitario' => 'required|integer|min:0',
            'cantidad_material' => 'required|integer|min:0',
        ]);

        Material::create([
            'clave_material' => $request->clave_material,
            'descripcion_material' => $request->descripcion_material,
            'precio_unitario' => $request->precio_unitario,
            'cantidad_material' => $request->cantidad_material,
        ]);

        return redirect()->route('materials.index')->with('success', 'Material creado correctamente.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Material $material)
    {
        return redirect()->route('materials.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Material $material) // USAR
    {
        return view('materials.edit', compact('material'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Material $material)
    {
        $request->validate([
            'clave_material' => 'required|integer|unique:materials,clave_material,' . $material->id,
            'descripcion_material' => 'required|string',
            'precio_unitario' => 'required|integer|min:0',
            'cantidad_material' => 'required|integer|min:0',
        ]);

        $material->update([
            'clave_material' => $request->clave_material,
            'descripcion_material' => $request->descripcion_material,
            'precio_unitario' => $request->precio_unitario,
            'cantidad_material' => $request->cantidad_material,
        ]);

        return redirect()->route('materials.index')->with('success', 'Material actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        $material->delete();
        return redirect()->route('materials.index')->with('success', 'Material eliminado correctamente.');
    }
}
