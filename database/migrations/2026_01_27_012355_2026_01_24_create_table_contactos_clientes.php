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
        Schema::create('contactos_clientes', function (Blueprint $table) {            
            $table->foreign('id_cliente')->references('id')->on('clientes')->onDelete('cascade');
            $table->string('telefono_cliente', 50);
            $table->string('correo_cliente', 150);            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contactos_clientes');
    }
};
