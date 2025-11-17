<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Mostrar todos los usuarios.
     */
    public function index()
    {
        $users = User::all(); // o paginación: User::paginate(10)
        return view('users.index', compact('users'));
    }

    /**
     * Mostrar formulario para crear un nuevo usuario.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Guardar un nuevo usuario en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role'     => ['required', Rule::in(['admin', 'mesero', 'recepcionista', 'chef'])],
            'phone'    => 'nullable|string|max:20',
            'active'   => 'nullable|boolean',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'phone'    => $request->phone,
            'active'   => $request->active ?? true,
        ]);

        return redirect()->route('users.index')
                         ->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Mostrar un usuario específico.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Mostrar formulario para editar un usuario.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Actualizar un usuario existente.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => ['required', Rule::in(['admin', 'mesero', 'recepcionista', 'chef'])],
            'phone' => 'nullable|string|max:20',
            'active'=> 'nullable|boolean',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name   = $request->name;
        $user->email  = $request->email;
        $user->role   = $request->role;
        $user->phone  = $request->phone;
        $user->active = $request->active ?? true;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')
                         ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Eliminar un usuario.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')
                         ->with('success', 'Usuario eliminado correctamente.');
    }
}
