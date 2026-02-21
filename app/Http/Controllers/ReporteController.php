<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Auth;

class ReporteController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if ($user && $user->rol && strtolower($user->rol->nombre) === 'soporte') {
                abort(403);
            }
            return $next($request);
        });
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

        /**
         * Genera un reporte imprimible (PDF mediante impresión del navegador)
         * con la misma lógica que getData pero sin paginar. Los filtros se reciben
         * por query string como en el dashboard.
         */
        public function pdf(Request $request)
        {
            $tipoReporte = $request->input('tipoReporte', 'recibidos_atencion');
            $fechaInicio = $request->input('fechaInicio');
            $fechaFin = $request->input('fechaFin');

            $data = $this->buildReportData($tipoReporte, $fechaInicio, $fechaFin);

            return view('estadisticas-pdf', compact('data', 'tipoReporte', 'fechaInicio', 'fechaFin'));
        }

        /**
         * Método auxiliar que encapsula la construcción de las series para
         * un determinado tipo de reporte y rango de fechas. Devuelve un arreglo
         * con "labels" y "data" tal como lo hace el endpoint JSON.
         */
        private function buildReportData($tipoReporte, $fechaInicio = null, $fechaFin = null)
        {
            $data = [];
            switch ($tipoReporte) {
                case 'recibidos_atencion':
                    $query = DB::table('recepcion_de_equipo')
                        ->select('tipo_atencion as label', DB::raw('count(*) as total'))
                        ->groupBy('tipo_atencion');
                    break;
                case 'recibidos_tipo_equipo':
                    $query = DB::table('recepcion_de_equipo as re')
                        ->join('equipos as e', 're.id_equipo', '=', 'e.id')
                        ->join('tipo_de_equipo as te', 'e.id_tipo', '=', 'te.id')
                        ->select('te.nombre as label', DB::raw('count(*) as total'))
                        ->groupBy('te.nombre');
                    break;
                case 'entregados_atencion':
                    $query = DB::table('entrega_de_equipo as ent')
                        ->join('recepcion_de_equipo as re', 'ent.id_caso', '=', 're.id_caso')
                        ->select('re.tipo_atencion as label', DB::raw('count(*) as total'))
                        ->groupBy('re.tipo_atencion');
                    break;
                case 'entregados_tipo_equipo':
                    $query = DB::table('entrega_de_equipo as ent')
                        ->join('equipos as e', 'ent.id_equipo', '=', 'e.id')
                        ->join('tipo_de_equipo as te', 'e.id_tipo', '=', 'te.id')
                        ->select('te.nombre as label', DB::raw('count(*) as total'))
                        ->groupBy('te.nombre');
                    break;
                case 'piezas_soporte':
                    $query = DB::table('documentacion_de_caso as doc')
                        ->join('pieza_soporte as pz', 'doc.id_pieza_soporte', '=', 'pz.id')
                        ->select('pz.nombre as label', DB::raw('SUM(doc.cantidad) as total'))
                        ->groupBy('pz.nombre');
                    break;
                default:
                    $query = collect();
            }

            if (isset($query) && ! $query instanceof \Illuminate\Support\Collection) {
                if ($fechaInicio) {
                    $query->whereDate('created_at', '>=', $fechaInicio);
                }
                if ($fechaFin) {
                    $query->whereDate('created_at', '<=', $fechaFin);
                }
                $results = $query->get();
                $data['labels'] = $results->pluck('label');
                $data['data'] = $results->pluck('total');
            } else {
                $data['labels'] = collect();
                $data['data'] = collect();
            }

            return $data;
        }
}
