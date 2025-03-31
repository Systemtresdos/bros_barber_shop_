<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'rol' => 'required|in:admin,barbero,cliente',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'foto_perfil' => 'nullable|image|max:2048',
            'status' => 'sometimes|boolean'
        ]);
    
        // Manejo de la imagen
        if($request->hasFile('foto_perfil')) {
            $validated['foto_perfil'] = $request->file('foto_perfil')->store('perfiles', 'public');
        }
    
        // Hash de la contraseña
        $validated['password'] = bcrypt($validated['password']);
    
        User::create($validated);
    
        return redirect()->route('admin.users.index')->with('success', 'Usuario creado correctamente');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->usuario_id.',usuario_id',
            'password' => 'nullable|confirmed|min:8',
            'rol' => 'required|in:admin,barbero,cliente',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'foto_perfil' => 'nullable|image|max:2048',
            'status' => 'sometimes|boolean'
        ]);
    
        // Manejo de la imagen (actualización)
        if($request->hasFile('foto_perfil')) {
            // Eliminar imagen anterior si existe
            if($user->foto_perfil) {
                Storage::disk('public')->delete($user->foto_perfil);
            }
            $validated['foto_perfil'] = $request->file('foto_perfil')->store('perfiles', 'public');
        }
    
        // Actualizar contraseña solo si se proporcionó
        if(empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = bcrypt($validated['password']);
        }
    
        $user->update($validated);
    
        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado correctamente');
    }
}