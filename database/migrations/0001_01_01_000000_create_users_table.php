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
        Schema::create('estatus_usuario', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 20);
            $table->timestamps();
        });

        // Insertar estatus iniciales
        DB::table('estatus_usuario')->insert([
            ['id' => 1, 'nombre' => 'Activo'],
            ['id' => 2, 'nombre' => 'Inactivo'],
            ['id' => 3, 'nombre' => 'Vacaciones'],
            ['id' => 4, 'nombre' => 'Jubilado'],
        ]);

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50)->unique();
            $table->string('descripcion', 100)->nullable();
            $table->timestamps();
        });

        // Insertar roles iniciales
        DB::table('roles')->insert([
            ['nombre' => 'administrador', 'descripcion' => 'Acceso total al sistema'],
            ['nombre' => 'soporte', 'descripcion' => 'Técnico encargado de reparación'],
            ['nombre' => 'recepcion', 'descripcion' => 'Encargado de recibir y entregar equipos'],
        ]);
    
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->unsignedBigInteger('id_rol')->after('email')->nullable();
            $table->foreign('id_rol')->references('id')->on('roles');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->unsignedBigInteger('id_estatus')->default(1);
            $table->foreign('id_estatus')->references('id')->on('estatus_usuario');
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('estatus_usuario');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
