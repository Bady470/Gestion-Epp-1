<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Area;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // 🔹 Mostrar todos los usuarios
    public function index()
    {$usuarios = User::with(['rol', 'area'])->paginate(10);

        return view('usuarios.index', compact('usuarios'));
    }

    // 🔹 Formulario para crear
    public function create()
    {
        $roles = Role::all();
        $areas = Area::all();
        return view('usuarios.create', compact('roles', 'areas'));
    }

    // 🔹 Guardar nuevo usuario
    public function store(Request $request)
{
    $validated = $request->validate([
        'nombre_completo' => 'required|string|max:100',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
        'roles_id' => 'nullable|exists:roles,id',
        'areas_id' => 'nullable|exists:areas,id',
    ]);

    $validated['password'] = bcrypt($validated['password']);

    User::create($validated);

    return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
}


    // 🔹 Formulario para editar
    public function edit(User $usuario)
    {
        $roles = Role::all();
        $areas = Area::all();
        return view('usuarios.edit', compact('usuario', 'roles', 'areas'));
    }

    // 🔹 Actualizar usuario
    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'password' => 'nullable|min:6|confirmed',
            'roles_id' => 'nullable|exists:roles,id',
            'areas_id' => 'nullable|exists:areas,id',
        ]);

        $data = $request->only(['nombre_completo', 'email', 'roles_id', 'areas_id']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $usuario->update($data);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    // 🔹 Eliminar usuario
    public function destroy(User $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
}