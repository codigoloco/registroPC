<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recepcion_de_equipo', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();            
            $table->integer('id_caso');
            $table->integer('id_equipo'); // equipos uses integer id
            $table->unsignedBigInteger('id_usuario_recepcion');
            $table->unsignedBigInteger('id_usuario_tecnico_asignado');

            $table->foreign('id_caso')->references('id')->on('casos');
            $table->foreign('id_equipo')->references('id')->on('equipos');
            $table->foreign('id_usuario_recepcion')->references('id')->on('users');
            $table->foreign('id_usuario_tecnico_asignado')->references('id')->on('users');
            $table->enum('tipo_atencion', ['garantia', 'presupuesto'])->default('soporte');
            $table->string('falla_tecnica');
            $table->enum('pago', ['si', 'no'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recepcion_de_equipo');
    }
};
