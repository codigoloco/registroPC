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
        $results = collect([]);

        // Helper to apply date filters dynamically
        $applyDateFilter = function ($query, $column) use ($fechaInicio, $fechaFin) {
            if ($fechaInicio) {
                $query->whereDate($column, '>=', $fechaInicio);
            }
            if ($fechaFin) {
                $query->whereDate($column, '<=', $fechaFin);
            }
        };

        switch ($tipoReporte) {
            case 'recibidos_atencion':
                // A) Recibidos por tipo de atención
                $query = DB::table('recepcion_de_equipo')
                    ->select('tipo_atencion', DB::raw('count(*) as total'))
                    ->groupBy('tipo_atencion');

                $applyDateFilter($query, 'created_at');
                $results = $query->get();

                $labels = $results->pluck('tipo_atencion');
                $data = $results->pluck('total');
                break;

            case 'recibidos_tipo_equipo':
                // B) Recibidos por Tipo de equipo
                $query = DB::table('recepcion_de_equipo as re')
                    ->join('equipos as e', 're.id_equipo', '=', 'e.id')
                    ->join('tipo_de_equipo as te', 'e.id_tipo', '=', 'te.id')
                    ->select('te.nombre', DB::raw('count(*) as total'))
                    ->groupBy('te.nombre');

                $applyDateFilter($query, 're.created_at');
                $results = $query->get();

                $labels = $results->pluck('nombre');
                $data = $results->pluck('total');
                break;

            case 'entregados_atencion':
                // C) Entregados por tipo de atención
                $query = DB::table('entrega_de_equipo as ent')
                    ->join('casos as c', 'ent.id_caso', '=', 'c.id')
                    ->join('recepcion_de_equipo as re', 're.id_caso', '=', 'c.id')
                    ->select('re.tipo_atencion', DB::raw('count(*) as total'))
                    ->groupBy('re.tipo_atencion');

                $applyDateFilter($query, 'ent.created_at');
                $results = $query->get();

                $labels = $results->pluck('tipo_atencion');
                $data = $results->pluck('total');
                break;

            case 'entregados_tipo_equipo':
                // D) Equipos entregados por Tipo de equipo
                // Note: user spec says join equipos on ent.id_equipo = e.id
                // Need to verify if entrega_de_equipo has id_equipo or if it should go through casing
                $query = DB::table('entrega_de_equipo as ent')
                    ->join('equipos as e', 'ent.id_equipo', '=', 'e.id') // Assuming structure based on user prompt
                    ->join('tipo_de_equipo as te', 'e.id_tipo', '=', 'te.id')
                    ->select('te.nombre', DB::raw('count(*) as total'))
                    ->groupBy('te.nombre');

                $applyDateFilter($query, 'ent.created_at');
                $results = $query->get();

                $labels = $results->pluck('nombre');
                $data = $results->pluck('total');
                break;

            case 'piezas_soporte':
                // E) Piezas/Atención por Soporte
                $query = DB::table('documentacion_de_caso as doc')
                    ->join('pieza_soporte as pz', 'doc.id_pieza_soporte', '=', 'pz.id')
                    ->select('pz.nombre', DB::raw('SUM(doc.cantidad) as total'))
                    ->groupBy('pz.nombre');

                $applyDateFilter($query, 'doc.created_at');
                $results = $query->get();

                $labels = $results->pluck('nombre');
                $data = $results->pluck('total');
                break;
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
            'raw' => $results
        ]);
    }
}
