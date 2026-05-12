<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // GET /api/users
    public function index()
    {
        $users = User::with('roles')->get()->map(function ($u) {
            return [
                'id' => (string) $u->id,
                'name' => $u->name,
                'email' => $u->email,
                'username' => $u->username,
                'role' => $u->roles->first()->nombreRol ?? null,
                'active' => $u->active,
                'company' => $u->company,
                'phone' => $u->phone,
                'address' => $u->address,
                'customerNumber' => $u->customer_number,
            ];
        });

        return response()->json($users);
    }

    // POST /api/users
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role'     => 'required|integer|exists:roles,id',
            'company'  => 'nullable|string|max:255',
            'phone'    => 'nullable|string|max:50',
            'address'  => 'nullable|string|max:255',
            'customerNumber' => 'nullable|string|max:50',
            'active'   => 'sometimes|boolean',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'company'  => $request->company,
            'phone'    => $request->phone,
            'address'  => $request->address,
            'customer_number' => $request->customerNumber,
            'active'   => $request->boolean('active', true),
        ]);

        $user->roles()->sync([$request->role]);

        return response()->json([
            'id' => (string) $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'username' => $user->username,
            'role' => $request->role,
            'active' => $user->active,
            'company' => $user->company,
            'phone' => $user->phone,
            'address' => $user->address,
            'customerNumber' => $user->customer_number,
        ], 201);
    }

    // PUT /api/users/{id}
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email'    => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role'     => 'required|integer|exists:roles,id',
            'company'  => 'nullable|string|max:255',
            'phone'    => 'nullable|string|max:50',
            'address'  => 'nullable|string|max:255',
            'customerNumber' => 'nullable|string|max:50',
            'active'   => 'sometimes|boolean',
        ]);

        $user->name     = $request->name;
        $user->username = $request->username;
        $user->email    = $request->email;
        $user->company  = $request->company;
        $user->phone    = $request->phone;
        $user->address  = $request->address;
        $user->customer_number = $request->customerNumber;

        if ($request->has('active')) {
            $user->active = $request->boolean('active');
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        $user->roles()->sync([$request->role]);

        return response()->json([
            'id' => (string) $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'username' => $user->username,
            'role' => $request->role,
            'active' => $user->active,
            'company' => $user->company,
            'phone' => $user->phone,
            'address' => $user->address,
            'customerNumber' => $user->customer_number,
        ]);
    }

    // DELETE /api/users/{id}
    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return response()->json(['error' => 'No puedes eliminarte a ti mismo.'], 403);
        }

        $user->delete();

        return response()->json(['success' => true]);
    }

    public function changePassword(Request $request, User $user)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8',
        ]);

        // Verificar contraseña actual
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['error' => 'Incorrect current password'], 422);
        }

        // Actualizar contraseña
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['success' => true]);
    }
    
}
