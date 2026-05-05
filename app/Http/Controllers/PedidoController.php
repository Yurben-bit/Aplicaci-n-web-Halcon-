<?php

namespace App\Http\Controllers;

use App\Services\PedidoService;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    protected $pedidoService;

    public function __construct(PedidoService $pedidoService)
    {
        $this->pedidoService = $pedidoService;
    }

    /**
     * Muestra la lista de pedidos (opcional para vista index)
     */
    public function index()
    {
        // En un futuro aquí llamarías al servicio para listar
        return response()->json(['message' => 'Lista de pedidos']);
    }

    /**
     * Registra un nuevo pedido en el sistema
     */
    public function store(Request $request)
    {
        try {
            $pedido = $this->pedidoService->registrarPedido($request->all());
            return response()->json($pedido, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Avanza el estado del pedido según el flujo lógico
     */
    public function updateStatus($id)
    {
        try {
            $pedido = $this->pedidoService->avanzarEstado($id);
            return response()->json($pedido);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}