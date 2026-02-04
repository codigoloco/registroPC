<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
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
            DB::table('pieza_soporte')->insert(['nombre' => $pieza]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('pieza_soporte')->truncate();
    }
};
