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
        'invoice_number',
        'customer_name',
        'customer_number',
        'fiscal_data',
        'order_date',
        'delivery_address',
        'notes',
        'status',
        'evidence_path',
        'loaded_unit_photo',
        'delivery_evidence_photo',
        'loaded_photo_timestamp',
        'delivered_photo_timestamp',
        'delivery_notes',
        'items',
        'total_amount',
        'deleted',
        'missing_items',
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'items' => 'array',
        'total_amount' => 'decimal:2',
        'deleted' => 'boolean',
        'missing_items' => 'array',
    ];

    protected static function booted()
    {
        static::addGlobalScope('latest', function ($builder) {
            $builder->latest();
        });
    }
}