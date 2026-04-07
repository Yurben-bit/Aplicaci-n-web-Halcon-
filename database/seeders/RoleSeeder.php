<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
    # Administrado, Ventas, Compras, Almacen, Ruta, Cliente/usuario

    public function run()
    {
        Role::create(['nombreRol' => 'Admin']);
        Role::create(['nombreRol' => 'Ventas']);
        Role::create(['nombreRol' => 'Compras']);
        Role::create(['nombreRol' => 'Almacen']);
        Role::create(['nombreRol' => 'Ruta']);
        Role::create(['nombreRol' => 'Cliente']);
    }
}
