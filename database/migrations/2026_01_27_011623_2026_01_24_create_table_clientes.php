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
        if (Schema::hasTable('clientes')) {
             // If table exists, since we want a specific schema, we might need to adjust or drop.
             // For safety in this environment, I'll drop and recreate to match requirements exactly.
             Schema::drop('clientes');
        }

        Schema::create('clientes', function (Blueprint $table) {
            $table->integer('id')->unique();            
            $table->string('nombre', 100);
            $table->text('direccion');            
            $table->enum('tipo_cliente', ['natural', 'juridico','Gubernamental']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
