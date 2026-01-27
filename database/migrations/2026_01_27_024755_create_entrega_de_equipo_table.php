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
        Schema::create('entrega_de_equipo', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('id_caso');
            $table->integer('id_equipo'); 
            $table->unsignedBigInteger('id_usuario_entrega');

            $table->foreign('id_caso')->references('id')->on('casos');
            $table->foreign('id_equipo')->references('id')->on('equipos');
            $table->foreign('id_usuario_entrega')->references('id')->on('users');        
            $table->enum('deposito',['tecnico','deposito'])->default('tecnico');    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entrega_de_equipo');
    }
};
