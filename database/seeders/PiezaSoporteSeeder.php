<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PiezaSoporteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $piezas = [
            'En Diagnóstico',
            'No presentó falla / Equipo operativo',
            'Teclado',
            'Cargador',
            'Adaptador de corriente',
            'Memoria RAM',
            'Tarjeta madre',
            'Sistema operativo',
            'Controladores',
            'Carcasa / Case',
            'Monitor / Pantalla',
            'Batería / Pila',
            'Pin de carga',
            'Mantenimiento',
            'Repotenciación',
            'Mouse USB',
            'Almacenamiento',
            'Unidad óptica (CD/DVD)',
            'Tarjeta inversora',
            'Tarjeta de red',
            'Tarjeta RAID',
            'Touchpad',
            'Suite Ofimatica',
            'Ajuste de pantalla',
            'Bisagras',
            'Fuente de poder',
            'Módulo de encendido',
            'Pila de BIOS',
            'Disipador',
            'Ajuste de componentes',
            'Sin reparar / Fuera de garantía',
        ];

        foreach ($piezas as $pieza) {
            DB::table('pieza_soporte')->insertOrIgnore(['nombre' => $pieza]);
        }
    }
}
