<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Opcional pero recomendado
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Requisito: Definimos los campos que se pueden llenar desde el formulario
    protected $fillable = [
        'description',
        'status',
        'evidence_path',
    ];

    /**
     * Tip de 6to semestre: 
     * Si quieres que siempre se ordenen de último a primero por defecto
     */
    protected static function booted()
    {
        static::addGlobalScope('latest', function ($builder) {
            $builder->latest();
        });
    }
}