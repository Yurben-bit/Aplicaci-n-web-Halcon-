<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Models\User;

use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\StockAlmacenController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ArticuloController;

// LOGIN
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Credenciales incorrectas'], 401);
    }

    $user->load('roles');
    $role = $user->roles->first()?->nombreRol;

    $token = $user->createToken('frontend-token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user'  => [
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
            'role'  => $role
        ],
    ]);
});

// USER AUTH
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// LOGOUT
Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $token = $request->user()->currentAccessToken();
    if ($token) $token->delete();

    return response()->json(['message' => 'Sesión cerrada correctamente']);
});

// REGISTER
Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'unique:users'],
        'password' => ['required', 'string', 'min:8'],
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    $token = $user->createToken('frontend-token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user'  => $user,
    ]);
});

// CRUDs protegidos
Route::middleware(['auth:sanctum'])->group(function () {

    // USERS (Admin)
    Route::apiResource('users', UserController::class)
        ->middleware('role:Admin');

    // ROLES (Admin)
    Route::apiResource('roles', RoleController::class)
        ->middleware('role:Admin');

    // MATERIALS (Admin, Almacen)
    Route::apiResource('materials', MaterialController::class)
        ->middleware('role:Admin,Almacen');

    // PROVIDERS (Admin, Compras)
    Route::apiResource('providers', ProviderController::class)
        ->middleware('role:Admin,Compras');

    // STOCK (Admin, Almacen)
    Route::apiResource('stockAlmacenes', StockAlmacenController::class)
        ->middleware('role:Admin,Almacen');

    // ORDERS (todos los roles autenticados)
    Route::apiResource('orders', OrderController::class);

    // ARTICULOS (todos los roles autenticados)
    Route::apiResource('articulos', ArticuloController::class);
});