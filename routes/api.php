<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Role;

use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\StockAlmacenController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\PurchaseRequestController;

// CORS Preflight handler
Route::options('{any}', function () {
    return response()->json([], 200);
})->where('any', '.*');

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
    $roleId = $user->roles->first()?->id;

    $token = $user->createToken('frontend-token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user'  => [
            'id'       => $user->id,
            'name'     => $user->name,
            'username' => $user->username,   // Nombre de usuario
            'email'    => $user->email,
            'role'     => $role,             // nombre del rol
            'role_id'  => $roleId,           // ID del rol
            'phone'    => $user->phone ?? null, // si existe
            'active'   => $user->active,
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
        'username' => ['required', 'string', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8'],
        'company' => ['nullable', 'string', 'max:255'],
        'phone' => ['nullable', 'string', 'max:50'],
        'address' => ['nullable', 'string', 'max:255'],
    ]);

    $customerRole = Role::whereIn('nombreRol', ['Cliente', 'Customer'])->first();
    $customerCount = User::where('customer_number', 'like', 'CUST-%')->count() + 1;

    $user = User::create([
        'name' => $request->name,
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'company' => $request->company,
        'phone' => $request->phone,
        'address' => $request->address,
        'customer_number' => 'CUST-' . str_pad((string) $customerCount, 3, '0', STR_PAD_LEFT),
        'active' => true,
    ]);

    if ($customerRole) {
        $user->roles()->sync([$customerRole->id]);
    }

    $token = $user->createToken('frontend-token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user'  => $user,
    ]);
});

Route::get('/purchaseRequests/latest/{materialId}', [PurchaseRequestController::class, 'latestByMaterial']);

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
        ->middleware('role:Admin,Almacen,Compras');

    // PROVIDERS (Admin, Compras)
    Route::apiResource('providers', ProviderController::class)
        ->middleware('role:Admin,Compras');

    // STOCK (Admin, Almacen)
    Route::apiResource('stockAlmacenes', StockAlmacenController::class)
        ->parameters([
            'stockAlmacenes' => 'stockAlmacen'
        ])
        ->middleware('role:Admin,Almacen,Compras');

    // ORDERS (todos los roles autenticados)
    Route::apiResource('orders', OrderController::class);

    // ARTICULOS (todos los roles autenticados)
    Route::apiResource('articulos', ArticuloController::class);

    // PURCHASE REQUESTS (Admin, Compras)
    Route::apiResource('purchaseRequests', PurchaseRequestController::class)
        ->middleware('role:Admin,Compras,Almacen');

    // Cambiar contraseña (todos los roles autenticados)
    Route::post('/users/{user}/change-password', [UserController::class, 'changePassword'])
    ->middleware('role:Admin,Cliente,Ventas,Compras,Almacen,Ruta');
});
