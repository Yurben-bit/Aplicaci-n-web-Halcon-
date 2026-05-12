<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materials = Material::paginate(10);
        return response()->json($materials);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Not needed for API
        return response()->json(['message' => 'Use POST to /materials'], 405);
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

        $material = Material::create([
            'clave_material' => $request->clave_material,
            'descripcion_material' => $request->descripcion_material,
            'precio_unitario' => $request->precio_unitario,
            'cantidad_material' => $request->cantidad_material,
        ]);

        return response()->json(['data' => $material], 201);
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
    public function edit(Material $material)
    {
        // Not needed for API - return material data for PUT/PATCH
        return response()->json(['data' => $material]);
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

        return response()->json(['data' => $material]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        $material->delete();
        return response()->json(['message' => 'Material deleted successfully'], 200);
    }
}
