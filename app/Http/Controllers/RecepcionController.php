<?php

namespace App\Http\Controllers;
use App\Models\Auditoria;
use App\Models\Caso;
use Illuminate\Support\Facades\Auth;

use App\Models\RecepcionDeEquipo;
use App\Models\EntregaDeEquipo;
use App\Models\Equipo;
use App\Models\User;
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
     * Página imprimible que muestra el listado completo de recepciones.
     *
     * No aplica paginación porque el objetivo es generar un documento único
     * que el usuario pueda exportar a PDF desde el navegador (Ctrl+P).
     */
    public function pdf()
    {
        $recepciones = RecepcionDeEquipo::with([
            'caso.cliente',
            'equipo.modelo',
            'equipo.tipo',
            'usuarioRecepcion'
        ])->orderBy('created_at', 'desc')->get();

        return view('recepcion-pdf', compact('recepciones'));
    }

    /**
     * Página imprimible que muestra el listado completo de salidas de equipo.
     * Similar a `pdf()` pero para el modelo `EntregaDeEquipo`.
     */
    public function pdfSalidas()
    {
        $salidas = EntregaDeEquipo::with([
            'caso.cliente',
            'equipo.modelo',
            'equipo.tipo',
            'usuarioEntrega'
        ])->orderBy('created_at', 'desc')->get();

        return view('salidas-pdf', compact('salidas'));
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

        // Buscar técnico de soporte disponible con menos carga (casos no entregados)
        $tecnico = User::whereHas('rol', function($q) {
                $q->where('nombre', 'soporte');
            })
            ->where('id_estatus', 1) // Activo
            ->withCount(['casos' => function($q) {
                $q->where('estatus', '!=', 'entregado');
            }])
            ->orderBy('casos_count', 'asc')
            ->first();

        if (!$tecnico) {
            return redirect()->back()->with('error', 'Recepción fallida: No hay técnicos de soporte disponibles (activos) en el sistema.');
        }

        // Actualizar caso con el técnico asignado y cambiar estatus a 'asignado'
        $estadoInicialCaso = $caso->toArray();
        $caso->update([
            'id_usuario' => $tecnico->id,
            'estatus' => 'asignado'
        ]);

        $data = $request->all();
        $data['id_usuario_recepcion'] = Auth::id();
        $data['id_usuario_tecnico_asignado'] = $tecnico->id;

        RecepcionDeEquipo::create($data);

        // Guardar auditoria de la recepción y la asignación
        Auditoria::create([
            'id_usuario' => Auth::id(),
            'id_caso' => $caso->id,
            'sentencia' => 'INSERT_RECEPCION_AUTO_ASIGNACION',
            'estado_inicial' => json_encode(['caso_anterior' => $estadoInicialCaso]),
            'estado_final' => json_encode([
                'nota' => 'Recepción registrada y técnico asignado automáticamente.',
                'tecnico_id' => $tecnico->id,
                'tecnico_nombre' => $tecnico->name . ' ' . $tecnico->lastname,
                'datos_recepcion' => $data
            ]),
            'ip' => $request->ip(),
        ]);

        return redirect()->back()->with('success', "Recepción registrada. Equipo asignado automáticamente al técnico: {$tecnico->name} {$tecnico->lastname}.");
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

        // Guardar auditoria
        Auditoria::create([
            'id_usuario' => Auth::id(),
            'id_caso' => $recepcion->id_caso,
            'sentencia' => 'INSERT_SALIDA',
            'estado_final' => json_encode(['nota' => 'Salida de equipo registrada.', 'deposito' => $request->deposito]),
            'ip' => $request->ip(),
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

        // Guardar auditoria
        Auditoria::create([
            'id_usuario' => Auth::id(),
            'id_caso' => $caso->id,
            'sentencia' => 'UPDATE_RECEPCION',
            'estado_final' => json_encode(['nota' => 'Recepción de equipo actualizada.', 'datos' => $data]),
            'ip' => $request->ip(),
        ]);

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
