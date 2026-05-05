<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Importación de Controladores Previos
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\RutaController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\StockAlmacenController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\HomeController;

// Importación de NUEVOS Controladores (Rama miguelvirus)
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\EvidenciaFotoController;

/*
|--------------------------------------------------------------------------
| Rutas de Autenticación y Raíz
|--------------------------------------------------------------------------
*/

Auth::routes();

Route::get('/', function () {
    if (!auth()->check()) {
        return redirect('/login');
    }
    
    $user = auth()->user();

    // Redirección por Roles
    if ($user->hasRole('Admin')) return redirect()->route('admin.dashboard');
    if ($user->hasRole('Ventas')) return redirect()->route('ventas.dashboard');
    if ($user->hasRole('Compras')) return redirect()->route('compras.dashboard');
    if ($user->hasRole('Almacen')) return redirect()->route('almacen.dashboard');
    if ($user->hasRole('Ruta')) return redirect()->route('ruta.dashboard');
    if ($user->hasRole('Cliente')) return redirect()->route('cliente.dashboard');
    
    return redirect()->route('home');
})->middleware('auth');

Route::get('/home', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Dashboards por Rol
|--------------------------------------------------------------------------
*/

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

/*
|--------------------------------------------------------------------------
| Módulo de Pedidos y Evidencias (Metodología MSR)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    
    // Solo Ventas y Admin pueden crear y ver pedidos
    Route::middleware(['role:Admin,Ventas'])->group(function () {
        Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
        Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store');
    });

    // Ruta y Almacen pueden actualizar el estado del pedido
    Route::middleware(['role:Admin,Almacen,Ruta'])->group(function () {
        Route::patch('/pedidos/{id}/status', [PedidoController::class, 'updateStatus'])->name('pedidos.status');
    });

    // Solo RUTA puede subir fotos de evidencia
    Route::middleware(['role:Admin,Ruta'])->group(function () {
        Route::post('/pedidos/{id}/evidencias', [EvidenciaFotoController::class, 'store'])->name('pedidos.evidencias.store');
    });
});

/*
|--------------------------------------------------------------------------
| Recursos del Sistema (CRUDs)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
});

Route::middleware(['auth', 'role:Admin,Almacen'])->group(function () {
    Route::resource('materials', MaterialController::class);
    Route::resource('stockAlmacenes', StockAlmacenController::class);
});

Route::middleware(['auth', 'role:Admin,Compras'])->group(function () {
    Route::resource('providers', ProviderController::class);
});

Route::resource('orders', OrderController::class)->middleware('auth');
Route::resource('articulos', ArticuloController::class)->middleware('auth');