<?php

use Illuminate\Support\Facades\Route;

// 1. Ruta Raíz: Apunta a nuestra nueva interfaz de CoreUI
Route::get('/', function () {
    return view('dashboard');
})->middleware('auth');

// 2. Rutas del andamiaje de Autenticación (Login, Registro, Recuperación)
Auth::routes();

// 3. Ruta de inicio post-autenticación
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// 4. Resource Routes for Users
Route::resource('users', App\Http\Controllers\UserController::class)->middleware('auth');

// 5. Resource Routes for Materials
Route::resource('materials', App\Http\Controllers\MaterialController::class)->middleware('auth');

// 6. Resource Routes for stockAlmacenes
Route::resource('stockAlmacenes', App\Http\Controllers\StockAlmacenController::class)->middleware('auth');

// 7. Resource Routes for Providers
Route::resource('providers', App\Http\Controllers\ProviderController::class)->middleware('auth');

// 8. Resource Routes for Orders
Route::resource('orders', App\Http\Controllers\OrderController::class)->middleware('auth');