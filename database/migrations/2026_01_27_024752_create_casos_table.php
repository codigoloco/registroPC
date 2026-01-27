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
        Schema::create('casos', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('id_cliente');            
            $table->unsignedBigInteger('id_usuario');
            $table->string('descripcion_falla', 100);
            $table->string('pieza_sugerida', 100)->nullable();
            $table->enum('forma_de_atencion', ['encomienda','presencial']);
            $table->enum('estatus', ['asignado','espera','reparado','entregado']);            
            $table->foreign('id_cliente')->references('id')->on('clientes');
            $table->foreign('id_usuario')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('casos');
    }
};
