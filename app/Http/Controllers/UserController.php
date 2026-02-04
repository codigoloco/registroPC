<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Muestra la lista de usuarios paginada.
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(10);
        return view('gestion-usuarios', compact('users'));
    }

    /**
     * Crea un nuevo usuario.
     */
    public function saveUser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string'],
            'id_estatus' => ['required', 'integer'],
        ]);

        User::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'id_estatus' => $request->id_estatus,
        ]);

        return redirect()->back()->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Actualiza un usuario existente.
     */
    public function updateUser(Request $request)
    {
        $user = User::where('email', $request->email)->firstOrFail();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string'],
            'id_estatus' => ['required', 'integer'],
        ];

        if ($request->filled('password')) {
            $rules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
        }

        $request->validate($rules);

        $data = [
            'name' => $request->name,
            'lastname' => $request->lastname,
            'role' => $request->role,
            'id_estatus' => $request->id_estatus,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Busca un usuario por email.
     */
    public function findByEmail($email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        return response()->json([
            'name' => $user->name,
            'lastname' => $user->lastname,
            'email' => $user->email,
            'role' => $user->role,
            'id_estatus' => $user->id_estatus,
        ]);
    }
}
