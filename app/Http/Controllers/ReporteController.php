<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function getData(Request $request)
    {
        $tipoReporte = $request->input('tipoReporte');
        $fechaInicio = $request->input('fechaInicio');
        $fechaFin = $request->input('fechaFin');

        $data = [];
        $labels = [];
        $datasets = [];

        // Base query constraints
        $dateFilter = function ($query) use ($fechaInicio, $fechaFin) {
            if ($fechaInicio) {
                $query->whereDate('created_at', '>=', $fechaInicio);
            }
            if ($fechaFin) {
                $query->whereDate('created_at', '<=', $fechaFin);
            }
        };

        switch ($tipoReporte) {
            case 'equipos_tipo':
                $results = DB::table('equipos')
                    ->join('tipo_de_equipo', 'equipos.id_tipo', '=', 'tipo_de_equipo.id')
                    ->select('tipo_de_equipo.nombre', DB::raw('count(*) as total'))
                    ->where(function ($q) use ($fechaInicio, $fechaFin) {
                    if ($fechaInicio)
                        $q->whereDate('equipos.created_at', '>=', $fechaInicio);
                    if ($fechaFin)
                        $q->whereDate('equipos.created_at', '<=', $fechaFin);
                })
                    ->groupBy('tipo_de_equipo.nombre')
                    ->get();

                $labels = $results->pluck('nombre');
                $data = $results->pluck('total');
                break;

            case 'equipos_falla':
                $results = DB::table('recepcion_de_equipo')
                    ->select('falla_tecnica', DB::raw('count(*) as total'))
                    ->where($dateFilter)
                    ->groupBy('falla_tecnica')
                    ->orderByDesc('total')
                    ->limit(10) // Limit to top 10 fallas to avoid clutter
                    ->get();

                $labels = $results->pluck('falla_tecnica');
                $data = $results->pluck('total');
                break;

            case 'rendimiento_tecnico':
                $results = DB::table('recepcion_de_equipo')
                    ->join('users', 'recepcion_de_equipo.id_usuario_tecnico_asignado', '=', 'users.id')
                    ->select('users.name', DB::raw('count(*) as total'))
                    ->where($dateFilter)
                    ->groupBy('users.name')
                    ->get();

                $labels = $results->pluck('name');
                $data = $results->pluck('total');
                break;

            case 'recepcion':
                $results = DB::table('recepcion_de_equipo')
                    ->select(DB::raw('DATE(created_at) as fecha'), DB::raw('count(*) as total'))
                    ->where($dateFilter)
                    ->groupBy('fecha')
                    ->orderBy('fecha')
                    ->get();

                $labels = $results->pluck('fecha');
                $data = $results->pluck('total');
                break;

        /*
         case 'salida':
         // Implement logic for salida/entrega if exists in recepcion_de_equipo or separate table
         // Assuming 'entrega_de_equipo' table exists based on schema list but not detailed inspection
         // defaulting to recepcion logic for now as placeholder or specific status
         break;
         */
        }

        return response()->json([
            'labels' => $labels, // Labels for Chart.js
            'data' => $data, // Data points for Chart.js
            'raw' => $results ?? [] // Full data for Table
        ]);
    }
}
