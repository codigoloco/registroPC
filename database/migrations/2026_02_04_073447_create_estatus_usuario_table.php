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
        Schema::create('estatus_usuario', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 20);
            $table->timestamps();
        });

        // Insertar estatus iniciales
        DB::table('estatus_usuario')->insert([
            ['id' => 1, 'nombre' => 'Activo'],
            ['id' => 2, 'nombre' => 'Inactivo'],
            ['id' => 3, 'nombre' => 'Vacaciones'],
            ['id' => 4, 'nombre' => 'Jubilado'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estatus_usuario');
    }
};
