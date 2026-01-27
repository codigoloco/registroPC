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
        Schema::create('equipos', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('id_tipo', 30);
            $table->string('id_modelo', 30);
            $table->string('serial_equipo', 30)->unique();
            
            $table->foreign('id_tipo')->references('id')->on('tipo_de_equipo');
            $table->foreign('id_modelo')->references('id')->on('modelo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};