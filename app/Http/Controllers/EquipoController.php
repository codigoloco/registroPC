<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Modelo;
use App\Models\TipoDeEquipo;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    /**
     * Muestra la lista de equipos paginada.
     */
    public function index()
    {
        $equipos = Equipo::with(['tipo', 'modelo'])->orderBy('id', 'desc')->paginate(10);
        return view('gestion-equipos', compact('equipos'));
    }

    /**
     * Guarda un nuevo equipo en la base de datos.
     */
    public function saveEquipo(Request $request)
    {
        $request->validate([
            'nombre_tipo' => 'required|string|max:30',
            'nombre_modelo' => 'required|string|max:30',
            'serial_equipo' => 'required|string|max:30|unique:equipos,serial_equipo',
        ]);

        // Buscar o crear el tipo de equipo
        $tipo = TipoDeEquipo::firstOrCreate(['nombre' => $request->nombre_tipo]);

        // Buscar o crear el modelo
        $modelo = Modelo::firstOrCreate(['nombre' => $request->nombre_modelo]);

        // Crear el equipo con los IDs obtenidos
        Equipo::create([
            'id_tipo' => $tipo->id,
            'id_modelo' => $modelo->id,
            'serial_equipo' => $request->serial_equipo,
        ]);

        return redirect()->back()->with('success', 'Equipo registrado exitosamente.');
    }

    /**
     * Actualiza un equipo existente.
     */
    public function updateEquipo(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:equipos,id',
            'nombre_tipo' => 'required|string|max:30',
            'nombre_modelo' => 'required|string|max:30',
            'serial_equipo' => 'required|string|max:30|unique:equipos,serial_equipo,' . $request->id,
        ]);

        $tipo = TipoDeEquipo::firstOrCreate(['nombre' => $request->nombre_tipo]);
        $modelo = Modelo::firstOrCreate(['nombre' => $request->nombre_modelo]);

        $equipo = Equipo::findOrFail($request->id);
        $equipo->update([
            'id_tipo' => $tipo->id,
            'id_modelo' => $modelo->id,
            'serial_equipo' => $request->serial_equipo,
        ]);

        return redirect()->back()->with('success', 'Equipo actualizado exitosamente.');
    }

    /**
     * Busca un equipo por su serial y retorna sus datos.
     */
    public function findBySerial($serial)
    {
        $equipo = Equipo::with(['tipo', 'modelo'])
            ->where('serial_equipo', $serial)
            ->first();

        if (!$equipo) {
            return response()->json(['error' => 'Equipo no encontrado'], 404);
        }

        return response()->json([
            'id' => $equipo->id,
            'serial_equipo' => $equipo->serial_equipo,
            'nombre_tipo' => $equipo->tipo->nombre ?? '',
            'nombre_modelo' => $equipo->modelo->nombre ?? '',
        ]);
    }
}
