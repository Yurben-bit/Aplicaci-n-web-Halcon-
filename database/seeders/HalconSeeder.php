<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class HalconSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear Roles
        $admin = Role::create(['name' => 'Admin']);
        $ventas = Role::create(['name' => 'Ventas']);
        $ruta = Role::create(['name' => 'Ruta']);

        // 2. Crear Usuario Admin
        $userAdmin = User::create([
            'name' => 'Miguel Admin',
            'email' => 'admin@halcon.com',
            'password' => bcrypt('password'),
        ]);
        $userAdmin->assignRole($admin);

        // 3. Crear Usuario de Ruta (El que subirá las fotos)
        $userRuta = User::create([
            'name' => 'Chofer Halcon',
            'email' => 'ruta@halcon.com',
            'password' => bcrypt('password'),
        ]);
        $userRuta->assignRole($ruta);
        
        // Aquí podrías agregar Clientes de prueba también
    }
}