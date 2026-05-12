<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $providers = Provider::paginate(10);
        return response()->json($providers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Not needed for API
        return response()->json(['message' => 'Use POST to /providers'], 405);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_proveedor' => 'required|string|min:0|max:255',
            'telefono' => 'required|string',
            'correo' => 'required|string|min:0|max:255|unique:providers',
            'activo' => 'required|boolean',
        ]);

        $provider = Provider::create([
            'nombre_proveedor' => $request->nombre_proveedor,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'activo' => $request->activo,
        ]);

        return response()->json(['data' => $provider], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Provider $provider)
    {
        return redirect()->route('providers.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Provider $provider)
    {
        // Not needed for API
        return response()->json(['data' => $provider]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Provider $provider)
    {
        $request->validate([
            'nombre_proveedor' => 'required|string|min:0|max:255',
            'telefono' => 'required|string',
            'correo' => 'required|string|min:0|max:255|unique:providers,correo,' . $provider->id,
            'activo' => 'required|boolean',
        ]);

        $provider->update([
            'nombre_proveedor' => $request->nombre_proveedor,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'activo' => $request->activo,
        ]);

        return response()->json(['data' => $provider]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Provider $provider)
    {
        $provider->delete();
        return response()->json(['message' => 'Provider deleted successfully'], 200);
    }
}
