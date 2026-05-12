<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $fillable = [
        'nombre_proveedor',
        'telefono',
        'correo',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];
}
