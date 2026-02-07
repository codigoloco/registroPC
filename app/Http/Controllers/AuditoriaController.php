<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use Illuminate\Http\Request;

class AuditoriaController extends Controller
{
    /**
     * Muestra la vista de gestión de auditoria.
     */
    public function index()
    {
        return view('gestion-auditoria');
    }

    /**
     * Obtiene los registros de auditoria con filtros y paginación.
     */
    public function getData(Request $request)
    {
        $query = Auditoria::with(['usuario', 'caso'])->orderBy('created_at', 'desc');

        // Filtro por usuario
        if ($request->filled('usuario')) {
            $usuario = $request->usuario;
            $query->whereHas('usuario', function($q) use ($usuario) {
                $q->where('name', 'like', "%{$usuario}%")
                  ->orWhere('id', 'like', "%{$usuario}%");
            });
        }

        // Filtro por caso
        if ($request->filled('id_caso')) {
            $query->where('id_caso', $request->id_caso);
        }

        // Filtro por fecha inicio
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('created_at', '>=', $request->fecha_inicio);
        }

        // Filtro por fecha fin
        if ($request->filled('fecha_fin')) {
            $query->whereDate('created_at', '<=', $request->fecha_fin);
        }

        return response()->json($query->paginate(10));
    }
}
