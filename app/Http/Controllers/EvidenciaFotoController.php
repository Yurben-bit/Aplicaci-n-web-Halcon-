<?php

namespace App\Http\Controllers;

use App\Services\EvidenciaFotoService;
use Illuminate\Http\Request;

class EvidenciaFotoController extends Controller
{
    protected $fotoService;

    public function __construct(EvidenciaFotoService $fotoService)
    {
        $this->fotoService = $fotoService;
    }

    /**
     * Sube una foto y la asocia a un pedido
     */
    public function store(Request $request, $pedidoId)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $evidencia = $this->fotoService->guardarEvidencia(
                $pedidoId, 
                $request->file('foto'),
                $request->latitud,
                $request->longitud
            );

            return response()->json($evidencia, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}