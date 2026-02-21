<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use App\Models\Caso;
use App\Models\DocumentacionCaso;
use App\Models\PiezaSoporte;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CasoController extends Controller
{
    /**
     * Muestra la lista de casos paginada.
     */
    public function index()
    {
        $casos = Caso::with(['cliente', 'tecnico'])->orderBy('id', 'desc')->paginate(10);
        return view('gestion-casos', compact('casos'));
    }

    /**
     * Guarda un nuevo caso.
     */
    public function saveCaso(Request $request)
    {
        $request->validate([
            'id_cliente' => 'required|exists:clientes,id',
            'descripcion_falla' => 'required|string|max:100',
            'pieza_sugerida' => 'nullable|string|max:100',
            'forma_de_atencion' => 'required|in:encomienda,presencial',
            'estatus' => 'required|in:asignado,espera,reparado,entregado',
        ]);

        try {
            $caso = Caso::create([
                'id_cliente' => $request->id_cliente,
                'id_usuario' => Auth::id(), // Técnico autenticado
                'descripcion_falla' => $request->descripcion_falla,
                'pieza_sugerida' => $request->pieza_sugerida,
                'forma_de_atencion' => $request->forma_de_atencion,
                'estatus' => $request->estatus,
            ]);
            // Guardar auditoria
            Auditoria::create([
                'id_usuario' => Auth::id(),
                'id_caso' => $caso->id,
                'sentencia' => 'INSERT',
                'estado_final' => json_encode(['nota' => 'Caso creado exitosamente.', 'datos' => $caso->toArray()]),
                'ip' => $request->ip(),
            ]);

            return redirect()->back()->with('success', "Caso #{$caso->id} creado exitosamente.");
        }
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear caso: ' . $e->getMessage());
        }
    }

    /**
     * Documenta el uso de piezas y servicios en un caso.
     */
    public function documentarCaso(Request $request)
    {
        $request->validate([
            'id_caso' => 'required|exists:casos,id',
            'id_pieza_soporte' => 'required|array',
            'id_pieza_soporte.*' => 'required|integer|exists:pieza_soporte,id',
            'cantidad' => 'required|array',
            'cantidad.*' => 'required|integer|min:1',
            'observacion' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->id_pieza_soporte as $index => $piezaId) {
                DocumentacionCaso::create([
                    'id_caso' => $request->id_caso,
                    'id_pieza_soporte' => $piezaId,
                    'cantidad' => $request->cantidad[$index],
                    'observacion' => $request->observacion,
                ]);
            }
            // Guardar auditoria
            Auditoria::create([
                'id_usuario' => Auth::id(),
                'id_caso' => $request->id_caso,
                'sentencia' => 'DOCUMENTAR',
                'estado_final' => json_encode(['nota' => 'Caso documentado exitosamente.']),
                'ip' => $request->ip(),
            ]);
            DB::commit();

            return redirect()->back()->with('success', 'Caso documentado exitosamente.');
        }
        catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al documentar caso: ' . $e->getMessage());
        }
    }

    /**
     * Actualiza un caso existente.
     */
    public function updateCaso(Request $request)
    {
        // impedir que el personal de soporte (técnicos) modifique casos
        $user = Auth::user();
        if ($user && $user->rol && strtolower($user->rol->nombre) === 'soporte') {
            abort(403);
        }
        $request->validate([
            'id' => 'required|exists:casos,id',
            'descripcion_falla' => 'required|string|max:100',
            'pieza_sugerida' => 'nullable|string|max:100',
            'forma_de_atencion' => 'required|in:encomienda,presencial',
            'estatus' => 'required|in:asignado,espera,reparado,entregado',
        ]);

        try {
            $caso = Caso::findOrFail($request->id);
            $estadoInicial = $caso->toArray();

            $caso->update([
                'descripcion_falla' => $request->descripcion_falla,
                'pieza_sugerida' => $request->pieza_sugerida,
                'forma_de_atencion' => $request->forma_de_atencion,
                'estatus' => $request->estatus,
            ]);

            // Guardar auditoria
            Auditoria::create([
                'id_usuario' => Auth::id(),
                'id_caso' => $caso->id,
                'sentencia' => 'UPDATE',
                'estado_inicial' => json_encode($estadoInicial),
                'estado_final' => json_encode($caso->fresh()->toArray()),
                'ip' => $request->ip(),
            ]);

            return redirect()->back()->with('success', "Caso #{$caso->id} actualizado exitosamente.");
        }
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar caso: ' . $e->getMessage());
        }
    }

    /**
     * Busca un caso por ID.
     */
    public function findById($id)
    {
        $caso = Caso::with(['cliente', 'tecnico', 'documentacion.piezaSoporte'])->find($id);

        if (!$caso) {
            return response()->json(['error' => 'Caso no encontrado'], 404);
        }

        return response()->json($caso);
    }

    public function getPiezas()
    {
        return response()->json(PiezaSoporte::all());
    }

    /**
     * Obtiene los casos disponibles (aquellos que no están entregados) 
     * para el select del proceso de recepción.
     */
    public function getCasosDisponibles()
    {
        return response()->json(
            Caso::with('cliente')
                ->where('estatus', '!=', 'entregado')
                ->orderBy('id', 'desc')
                ->get()
        );
    }

    /**
     * Obtiene los usuarios con el rol 'soporte' para la asignación de casos.
     */
    public function getTecnicos()
    {
        return response()->json(
            User::whereHas('rol', function($q) {
                $q->where('nombre', 'soporte');
            })
            ->where('id_estatus', 1) // Asumiendo 1 es activo
            ->get()
        );
    }

    /**
     * Devuelve los casos asignados en formato JSON. Si el usuario autenticado
     * tiene rol de administrador se devuelven todos los casos; de lo contrario
     * sólo los casos donde el campo id_usuario coincide con el usuario logeado.
     *
     * Esta ruta será consumida por el modal "Mis casos asignados" para que el
     * técnico pueda verificar rápidamente sus pendientes.
     */
    public function getCasosAsignados()
    {
        $user = Auth::user();

        $query = Caso::with(['cliente', 'tecnico']);

        // asumimos que el nombre del rol administrador es 'administrador'
        if (! $user->rol || strtolower($user->rol->nombre) !== 'administrador') {
            $query->where('id_usuario', $user->id);
        }

        $casos = $query->orderBy('id', 'desc')->get();

        return response()->json($casos);
    }

    /**
     * Asigna un técnico a un caso específico.
     */
    public function asignarTecnico(Request $request)
    {
        // restricción: sólo administradores pueden reasignar técnicos
        $user = Auth::user();
        if ($user && $user->rol && strtolower($user->rol->nombre) === 'soporte') {
            abort(403);
        }
        $request->validate([
            'id_caso' => 'required|exists:casos,id',
            'id_usuario' => 'required|exists:users,id',
        ]);

        try {
            $caso = Caso::findOrFail($request->id_caso);
            $estadoInicial = $caso->toArray();

            $caso->update([
                'id_usuario' => $request->id_usuario,
                'estatus' => 'asignado'
            ]);

            // Guardar auditoria
            Auditoria::create([
                'id_usuario' => Auth::id(),
                'id_caso' => $caso->id,
                'sentencia' => 'ASIGNAR_TECNICO',
                'estado_inicial' => json_encode($estadoInicial),
                'estado_final' => json_encode($caso->fresh()->toArray()),
                'ip' => $request->ip(),
            ]);

            return redirect()->back()->with('success', "Técnico asignado exitosamente al Caso #{$caso->id}.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al asignar técnico: ' . $e->getMessage());
        }
    }
}
