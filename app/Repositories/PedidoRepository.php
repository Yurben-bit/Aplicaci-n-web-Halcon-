<?php

namespace App\Repositories;

use App\Models\Pedido;

class PedidoRepository
{
    // Obtener todos los pedidos activos para la lista principal
    public function getAll()
    {
        return Pedido::where('activo', true)
                    ->orderBy('created_at', 'desc')
                    ->get();
    }

    // Buscar un pedido por su ID con sus fotos
    public function findById($id)
    {
        return Pedido::with('evidencias')->findOrFail($id);
    }

    // Guardar un nuevo pedido en la BD
    public function create(array $data)
    {
        return Pedido::create($data);
    }

    // Actualizar datos o estado
    public function update($id, array $data)
    {
        $pedido = $this->findById($id);
        $pedido->update($data);
        return $pedido;
    }
}