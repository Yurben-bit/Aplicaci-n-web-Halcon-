<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // Campos asignables
    protected $fillable = [
        'nombreRol',
    ];

    // Casts
    protected $casts = [
        'nombreRol' => 'string',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }

}
