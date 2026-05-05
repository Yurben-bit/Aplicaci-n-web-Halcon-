<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class RolesAndUsersSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear los Roles básicos del sistema
        $adminRole = Role::create(['nombreRol' => 'Admin']);
        $ventasRole = Role::create(['nombreRol' => 'Ventas']);
        $rutaRole = Role::create(['nombreRol' => 'Ruta']);
        $almacenRole = Role::create(['nombreRol' => 'Almacen']);

        // 2. Crear un usuario Admin (Tú)
        $admin = User::create([
            'name' => 'Miguel Alejandro',
            'email' => 'admin@halcon.com',
            'password' => Hash::make('password123'),
        ]);
        // Vincular con el rol Admin (ID 1)
        $admin->roles()->attach($adminRole->id);

        // 3. Crear un usuario de Ruta (Para probar las fotos)
        $chofer = User::create([
            'name' => 'Chofer de Ruta',
            'email' => 'ruta@halcon.com',
            'password' => Hash::make('password123'),
        ]);
        // Vincular con el rol Ruta
        $chofer->roles()->attach($rutaRole->id);
    }
}