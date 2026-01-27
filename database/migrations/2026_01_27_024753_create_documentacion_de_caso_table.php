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
        Schema::create('documentacion_de_caso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pieza_soporte')->constrained('pieza_soporte')->onDelete('cascade');            
            $table->smallInteger('cantidad');
            $table->text('observacion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentacion_de_caso');
    }
};
