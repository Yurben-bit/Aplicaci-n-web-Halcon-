<?php

namespace App\Services;

use App\Repositories\PedidoRepository;
use Exception;

class PedidoService
{
    protected $pedidoRepository;

    public function __construct(PedidoRepository $pedidoRepository)
    {
        $this->pedidoRepository = $pedidoRepository;
    }

    public function registrarPedido(array $data)
    {
        // Forzamos que todo pedido nuevo empiece como 'Solicitado' y 'Activo'
        $data['estado'] = 'Solicitado';
        $tableData['activo'] = true;

        return $this->pedidoRepository->create($data);
    }

    public function avanzarEstado($id)
    {
        $pedido = $this->pedidoRepository->findById($id);
        
        $nuevoEstado = match ($pedido->estado) {
            'Solicitado' => 'En proceso',
            'En proceso' => 'En ruta',
            'En ruta'    => 'Entregado',
            'Entregado'  => throw new Exception("El pedido ya fue entregado."),
            default      => $pedido->estado,
        };

        return $this->pedidoRepository->update($id, ['estado' => $nuevoEstado]);
    }
}