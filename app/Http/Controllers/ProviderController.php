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
        return view('providers.index', compact('providers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('providers.create');
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

        Provider::create([
            'nombre_proveedor' => $request->nombre_proveedor,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'activo' => $request->activo,
        ]);

        return redirect()->route('providers.index')->with('success', 'Provider creado correctamente.');
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
        return view('providers.edit', compact('provider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Provider $provider)
    {
         $request->validate([
            'nombre_proveedor' => 'required|string|min:0|max:255',
            'telefono' => 'required|string',
            'correo' => 'required|string|min:0|max:255|unique:providers' . $provider->id,
            'activo' => 'required|boolean',
        ]);

        $provider->update([
            'nombre_proveedor' => $request->nombre_proveedor,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'activo' => $request->activo,
        ]);

        return redirect()->route('providers.index')->with('success', 'Provider actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Provider $provider)
    {
        $provider->delete();
        return redirect()->route('providers.index')->with('success', 'Provider eliminado correctamente.');
    }
}
