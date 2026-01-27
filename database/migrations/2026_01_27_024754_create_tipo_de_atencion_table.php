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
        Schema::create('tipo_de_atencion', function (Blueprint $table) {
            $table->integer('id_tipo_atencion')->autoIncrement();
            // Or $table->id('id_tipo_atencion'); which creates BIGINT. User requirement is INT. 
            // integer() + autoIncrement() creates INT.
            $table->string('nombre_tipo_atencion', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_de_atencion');
    }
};
