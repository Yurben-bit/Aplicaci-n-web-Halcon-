<?php

namespace App\Repositories;

use App\Models\EvidenciaFoto;

class EvidenciaFotoRepository
{
    /**
     * Guarda el registro de la foto en la base de datos.
     * Incluye la ruta del archivo y las coordenadas GPS si existen.
     */
    public function create(array $data)
    {
        return EvidenciaFoto::create([
            'pedidoId'  => $data['pedidoId'],
            'ruta_foto' => $data['ruta_foto'],
            'latitud'   => $data['latitud'] ?? null,
            'longitud'  => $data['longitud'] ?? null,
        ]);
    }

    /**
     * Obtiene todas las evidencias fotográficas de un pedido específico.
     */
    public function getByPedido($pedidoId)
    {
        return EvidenciaFoto::where('pedidoId', $pedidoId)->get();
    }

    /**
     * Busca una evidencia específica por su ID.
     */
    public function findById($id)
    {
        return EvidenciaFoto::findOrFail($id);
    }
}