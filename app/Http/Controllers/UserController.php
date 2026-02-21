<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Muestra la lista de usuarios paginada.
     */
    public function index()
    {
        $users = User::with('rol')->orderBy('id', 'desc')->paginate(10);
        $roles = Role::all();
        return view('gestion-usuarios', compact('users', 'roles'));
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
            'id_rol' => ['required', 'integer', 'exists:roles,id'],
            'id_estatus' => ['required', 'integer'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_rol' => $request->id_rol,
            'id_estatus' => $request->id_estatus,
        ]);

        // Guardar auditoria (sin password)
        $userData = $user->toArray();
        unset($userData['password']);

        Auditoria::create([
            'id_usuario' => Auth::id(),
            'id_caso' => null,
            'sentencia' => 'INSERT_USER',
            'estado_final' => json_encode(['nota' => 'Usuario creado.', 'datos' => $userData]),
            'ip' => $request->ip(),
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
            'id_rol' => ['required', 'integer', 'exists:roles,id'],
            'id_estatus' => ['required', 'integer'],
        ];

        if ($request->filled('password')) {
            $rules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
        }

        $request->validate($rules);

        $data = [
            'name' => $request->name,
            'lastname' => $request->lastname,
            'id_rol' => $request->id_rol,
            'id_estatus' => $request->id_estatus,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $estadoInicial = $user->toArray();
        unset($estadoInicial['password']);
        
        $user->update($data);

        // Guardar auditoria
        $userData = $user->fresh()->toArray();
        unset($userData['password']);

        Auditoria::create([
            'id_usuario' => Auth::id(),
            'id_caso' => null,
            'sentencia' => 'UPDATE_USER',
            'estado_inicial' => json_encode($estadoInicial),
            'estado_final' => json_encode($userData),
            'ip' => $request->ip(),
        ]);

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
            'id_rol' => $user->id_rol,
            'id_estatus' => $user->id_estatus,
        ]);
    }
}
