<?php

namespace App\Http\Controllers;
use App\Models\Caso;
use Illuminate\Support\Facades\Auth;

use App\Models\RecepcionDeEquipo;
use App\Models\EntregaDeEquipo;
use App\Models\Equipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecepcionController extends Controller
{
    /**
     * Obtiene todas las recepciones de equipo de forma paginada con sus relaciones.
     */
    public function getAllPaged()
    {
        $recepciones = RecepcionDeEquipo::with([
            'caso.cliente',
            'equipo.modelo',
            'equipo.tipo',
            'usuarioRecepcion'
        ])->orderBy('created_at', 'desc')->paginate(10);

        return response()->json($recepciones);
    }

    /**
     * Obtiene todas las salidas de equipo de forma paginada con sus relaciones.
     */
    public function getSalidasPaged()
    {
        $salidas = EntregaDeEquipo::with([
            'caso.cliente',
            'equipo.modelo',
            'equipo.tipo',
            'usuarioEntrega',
            'caso.documentacion.piezaSoporte'
        ])->orderBy('created_at', 'desc')->paginate(10);

        return response()->json($salidas);
    }

    /**
     * Guarda la recepción de un equipo.
     */
    public function saveRecepcion(Request $request)
    {
        $request->validate([
            'id_caso' => 'required|integer|exists:casos,id',
            'id_equipo' => 'required|integer|exists:equipos,id',
            'tipo_atencion' => 'required|in:presupuesto,garantia',
            'falla_tecnica' => 'required|string|max:255',
            'pago' => 'nullable|in:si,no',
        ]);

        $caso = Caso::findOrFail($request->id_caso);

        $data = $request->all();
        $data['id_usuario_recepcion'] = Auth::id();
        $data['id_usuario_tecnico_asignado'] = $caso->id_usuario;

        RecepcionDeEquipo::create($data);

        return redirect()->back()->with('success', 'Recepción de equipo registrada exitosamente.');
    }

    public function registrarSalida(Request $request)
    {
        $request->validate([
            'id_caso' => 'required|integer|exists:recepcion_de_equipo,id_caso',
            'deposito' => 'required|in:Tecnico,Deposito',
        ]);

        $recepcion = RecepcionDeEquipo::where('id_caso', $request->id_caso)->firstOrFail();

        EntregaDeEquipo::create([
            'id_caso' => $recepcion->id_caso,
            'id_equipo' => $recepcion->id_equipo,
            'id_usuario_entrega' => Auth::id(),
            'deposito' => strtolower($request->deposito), // Normalizamos a minúsculas según el enum de la migración
        ]);

        return redirect()->back()->with('success', 'Salida de equipo registrada exitosamente.');
    }

    /**
     * Actualiza un registro de recepción existente.
     */
    public function updateRecepcion(Request $request)
    {
        $request->validate([
            'id_caso' => 'required|integer|exists:recepcion_de_equipo,id_caso',
            'id_equipo' => 'required|integer|exists:equipos,id',
            'tipo_atencion' => 'required|in:presupuesto,garantia',
            'falla_tecnica' => 'required|string|max:255',
            'pago' => 'nullable|in:si,no',
            'deposito' => 'nullable|in:Tecnico,Deposito',
        ]);

        $caso = Caso::findOrFail($request->id_caso);
        $recepcion = RecepcionDeEquipo::where('id_caso', $request->id_caso)->firstOrFail();

        $data = $request->all();
        // Mantenemos o actualizamos el usuario de recepción si es necesario, 
        // pero por integridad lo ideal es que quien edita quede registrado si es lo buscado.
        // En este caso, seguiremos la lógica de automatización.
        $data['id_usuario_tecnico_asignado'] = $caso->id_usuario;

        $recepcion->update($data);

        return redirect()->back()->with('success', 'Registro de recepción actualizado exitosamente.');
    }

    public function findByCaso($id_caso)
    {
        $recepcion = RecepcionDeEquipo::where('id_caso', $id_caso)->first();

        if (!$recepcion) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        // Obtener datos de entrega si existen
        $entrega = EntregaDeEquipo::where('id_caso', $id_caso)->first();

        $data = $recepcion->toArray();
        $data['fecha_recepcion'] = $recepcion->created_at->format('d/m/Y H:i');
        $data['fecha_salida'] = $entrega ? $entrega->created_at->format('d/m/Y H:i') : 'Pendiente';

        // Incluir datos de entrega para el frontend si es necesario
        if ($entrega) {
            $data['id_usuario_entrega'] = $entrega->id_usuario_entrega;
            $data['deposito'] = $entrega->deposito;
        }

        return response()->json($data);
    }
}
