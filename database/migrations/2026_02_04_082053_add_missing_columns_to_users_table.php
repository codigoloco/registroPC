<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('lastname')->after('name')->nullable();
            $table->string('role')->after('email')->nullable();
            $table->unsignedBigInteger('id_estatus')->after('role')->default(1);

            $table->foreign('id_estatus')->references('id')->on('estatus_usuario');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_estatus']);
            $table->dropColumn(['lastname', 'role', 'id_estatus']);
        });
    }
};
