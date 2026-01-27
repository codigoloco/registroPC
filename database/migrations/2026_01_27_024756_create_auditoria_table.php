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
        Schema::create('auditoria', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();           
            $table->unsignedBigInteger('id_usuario');
            $table->integer('id_caso');            
            $table->text('estado_inicial')->nullable();
            $table->text('estado_final');            
            $table->foreign('id_usuario')->references('id')->on('users');
            $table->foreign('id_caso')->references('id')->on('casos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditoria');
    }
};

