<?php

use Illuminate\Support\Facades\Route;

/*

Roles que se deben enrutar:

nombreRol => Admin
nombreRol => Ventas
nombreRol => Compras
nombreRol => Almacen
nombreRol => Ruta
nombreRol => Cliente

*/

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\RutaController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\OrderController;

// Rutas para cada rol

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

Route::middleware(['auth', 'role:Cliente'])->group(function () {
    Route::get('/cliente/dashboard', [ClienteController::class, 'dashboard'])->name('cliente.dashboard');
});

Route::middleware(['auth', 'role:Ruta'])->group(function () {
    Route::get('/ruta/dashboard', [RutaController::class, 'dashboard'])->name('ruta.dashboard');
});

Route::middleware(['auth', 'role:Almacen'])->group(function () {
    Route::get('/almacen/dashboard', [AlmacenController::class, 'dashboard'])->name('almacen.dashboard');
});

Route::middleware(['auth', 'role:Ventas'])->group(function () {
    Route::get('/ventas/dashboard', [VentaController::class, 'dashboard'])->name('ventas.dashboard');
});

Route::middleware(['auth', 'role:Compras'])->group(function () {
    Route::get('/compras/dashboard', [CompraController::class, 'dashboard'])->name('compras.dashboard');
});

use App\Http\Controllers\MaterialController;
use App\Http\Controllers\StockAlmacenController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;


// 1. Ruta Raíz: Apunta a nuestra nueva interfaz de CoreUI
Route::get('/', function () {
    $user = auth()->user(); // Obtener el usuario autenticado

    // Redirigir a la vista correspondiente según el rol del usuario

    if ($user->hasRole('Admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('Ventas')) {
        return redirect()->route('ventas.dashboard');
    } elseif ($user->hasRole('Compras')) {
        return redirect()->route('compras.dashboard');
    } elseif ($user->hasRole('Almacen')) {
        return redirect()->route('almacen.dashboard');
    } elseif ($user->hasRole('Ruta')) {
        return redirect()->route('ruta.dashboard');
    } elseif ($user->hasRole('Cliente')) {
        return redirect()->route('cliente.dashboard');
    }

})->middleware('auth');

// 2. Rutas del andamiaje de Autenticación (Login, Registro, Recuperación)
Auth::routes();

// 3. Ruta de inicio post-autenticación
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Rutas para los recursos principales (CRUD)

// Se restringe el acceso a estas rutas dado el rol del usuario
// Excepto para el rol 'Admin' que tiene acceso a todo

// OBSOLETO

// Se utiliza sanctum para la autenticación de API,
// por lo que estas rutas no son necesarias ya que el frontend consume la API directamente. 
// Sin embargo, se mantenien para propósitos de desarrollo.

// // 4. Resource Routes for Users
// Route::middleware(['auth', 'role:Admin'])->group(function () {
//     Route::resource('users', UserController::class);
// });

// // Route::resource('users', App\Http\Controllers\UserController::class)->middleware('auth');

// // 5. Resource Routes for Materials

// Route::middleware(['auth', 'role:Admin,Almacen'])->group(function () {
//     Route::resource('materials', MaterialController::class);
// });
// // Route::resource('materials', App\Http\Controllers\MaterialController::class)->middleware('auth');

// // 6. Resource Routes for stockAlmacenes
// Route::middleware(['auth', 'role:Admin,Almacen'])->group(function () {
//     Route::resource('stockAlmacenes', StockAlmacenController::class);
// });
// // Route::resource('stockAlmacenes', App\Http\Controllers\StockAlmacenController::class)->middleware('auth');

// // 7. Resource Routes for Providers

// Route::middleware(['auth', 'role:Admin,Compras'])->group(function () {
//     Route::resource('providers', ProviderController::class);
// });
// // Route::resource('providers', App\Http\Controllers\ProviderController::class)->middleware('auth');

// // 8. Resource Routes for Roles
// Route::middleware(['auth', 'role:Admin'])->group(function () {
//     Route::resource('roles', RoleController::class);
// });

// // Route::resource('roles', App\Http\Controllers\RoleController::class)->middleware('auth');

// // 9. Resource Routes for Orders
// Route::middleware(['auth'])->group(function () {
//     Route::resource('orders', OrderController::class);
// });

// // 10. Resource Routes for Articulos
// Route::middleware(['auth'])->group(function () {
//     Route::resource('articulos', ArticuloController::class);
// });

// use App\Http\Controllers\ArticuloController;
// Route::resource('articulos', ArticuloController::class);