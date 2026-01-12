<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller; 
use App\Models\User;
use Spatie\Permission\Models\Role;

class UsuariosController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Ver usuarios')->only(['index', 'show']);
        $this->middleware('permission:Crear usuarios')->only(['create', 'store']);
        $this->middleware('permission:Editar usuarios')->only(['edit', 'update']);
        $this->middleware('permission:Eliminar usuarios')->only('destroy');
    }

    public function index()
    {
        // Traemos usuarios con sus roles
        $users = User::with('roles')->get();
        $roles = Role::all();

        return view('usuarios.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->syncRoles([$request->role]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('usuarios.edit', compact('user', 'roles'));
    }

   public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'role' => 'required|string',
        // Quitamos 'confirmed' porque no tenemos password_confirmation en el formulario
        'password' => 'nullable|string|min:6'
    ]);

    $user->name = $request->name;
    $user->email = $request->email;

    // Si el campo contraseña no está vacío, la actualizamos
    if (!empty($request->password)) {
        $user->password = bcrypt($request->password);
    }

    $user->save();

    // Asignar el único rol seleccionado
    $user->syncRoles([$request->role]);

    return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
}

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
