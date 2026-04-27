<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\Api\AuthController;

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Credenciales incorrectas',
        ], 401);
    }

    // Cargar roles desde la tabla pivote
    $user->load('roles');

    // Obtener el primer rol
    $role = $user->roles->first()->nombreRol ?? null;

    // Crear token Sanctum
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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();

    return response()->json([
        'message' => 'Sesión cerrada correctamente'
    ]);
});


// Ruta para registrar un nuevo usuario
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

// Route::middleware(['auth:sanctum', 'role:admin'])->get('/admin-only', function (Request $request) {
//     return response()->json([
//         'message' => 'Acceso concedido a la ruta admin-only',
//     ]);
// });

// php artisan route:clear
// php artisan route:list
// php artisan serve