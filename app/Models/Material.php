<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{

    // Campos asignables
    protected $fillable = [
        'clave_material',
        'descripcion_material',
        'precio_unitario',
        'cantidad_material',
    ];

    // Casts
    protected $casts = [
        'clave_material' => 'integer',
        'precio_unitario' => 'integer',
        'cantidad_material' => 'integer',
    ];


}
