<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockAlmacen extends Model
{
    // Definimos el nombre real de la tabla si no quieres usar el plural de Laravel
    protected $table = 'stockAlmacenes';

    // Campos que permitimos que se llenen desde un formulario o API
    protected $fillable = [
        'materialesId',
        'cantidadStock',
        'stockMinimo',
        'stockMaximo',
    ];

    // Desactivamos los timestamps si no los vas a usar, o los dejamos si quieres control de creación/edición
    public $timestamps = true;

    /**
     * Casting de atributos.
     * Esto asegura que al acceder a estas propiedades, Laravel las convierta 
     * automáticamente al tipo de dato correcto.
     */
    protected $casts = [
        'materialesId'  => 'integer',
        'cantidadStock' => 'integer',
        'stockMinimo'   => 'integer',
        'stockMaximo'   => 'integer',
    ];

    /**
     * Relación: Un registro de stock pertenece a un Material.
     */
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'materialesId');
    }
}