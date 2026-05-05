<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// IMPORTANTE: Asegúrate de que esta línea exista para que reconozca el modelo Role
use App\Models\Role; 

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relación con el modelo Role.
     */
    public function roles()
    {
        // Si tu tabla pivote se llama 'role_user' y las llaves son 'user_id' y 'role_id'
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    /**
     * Verificar si el usuario tiene un rol específico.
     */
    public function hasRole($roleName)
    {        
        // Usamos where('nombreRol', ...) porque así lo definiste en tu modelo Role
        return $this->roles()->where('nombreRol', $roleName)->exists();
    }
}