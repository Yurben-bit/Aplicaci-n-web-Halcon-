<?php

namespace App\Services;

use App\Repositories\EvidenciaFotoRepository;
use Illuminate\Support\Facades\Storage;

class EvidenciaFotoService
{
    protected $repository;

    public function __construct(EvidenciaFotoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function guardarEvidencia($pedidoId, $archivo, $lat = null, $long = null)
    {
        // 1. Guardar el archivo físico en storage/app/public/evidencias
        $rutaFisica = $archivo->store('evidencias', 'public');

        // 2. Registrar en la base de datos mediante el repositorio
        return $this->repository->create([
            'pedidoId'  => $pedidoId,
            'ruta_foto' => $rutaFisica,
            'latitud'   => $lat,
            'longitud'  => $long
        ]);
    }
}