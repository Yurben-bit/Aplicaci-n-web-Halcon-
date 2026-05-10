<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // GET /api/roles
    public function index()
    {
        return Role::select('id', 'nombreRol')->get();
    }

    // POST /api/roles
    public function store(Request $request)
    {
        $request->validate([
            'nombreRol' => 'required|string|max:50|unique:roles'
        ]);

        $role = Role::create([
            'nombreRol' => $request->nombreRol
        ]);

        return response()->json($role, 201);
    }

    // PUT /api/roles/{id}
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'nombreRol' => 'required|string|max:50|unique:roles,nombreRol,' . $role->id
        ]);

        $role->update([
            'nombreRol' => $request->nombreRol
        ]);

        return response()->json($role);
    }

    // DELETE /api/roles/{id}
    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json(['success' => true]);
    }
}
