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
        // 1. Limpiar datos inconsistentes de forma radical para permitir la conversión
        // Dado que estamos en fase de desarrollo, truncaremos las tablas para asegurar limpieza
        DB::statement("TRUNCATE TABLE equipos CASCADE");
        DB::statement("TRUNCATE TABLE tipo_de_equipo CASCADE");
        DB::statement("TRUNCATE TABLE modelo CASCADE");

        // 2. Desvincular claves foráneas actuales
        Schema::table('equipos', function (Blueprint $table) {
            $table->dropForeign(['id_tipo']);
            $table->dropForeign(['id_modelo']);
        });

        // 3. Cambiar tabla 'tipo_de_equipo'
        DB::statement('ALTER TABLE tipo_de_equipo DROP CONSTRAINT tipo_de_equipo_pkey CASCADE');
        DB::statement('ALTER TABLE tipo_de_equipo ALTER COLUMN id TYPE BIGINT USING id::bigint');
        DB::statement('CREATE SEQUENCE tipo_de_equipo_id_seq');
        DB::statement("ALTER TABLE tipo_de_equipo ALTER COLUMN id SET DEFAULT nextval('tipo_de_equipo_id_seq')");
        DB::statement('ALTER TABLE tipo_de_equipo ADD PRIMARY KEY (id)');

        // 4. Cambiar tabla 'modelo'
        DB::statement('ALTER TABLE modelo DROP CONSTRAINT modelo_pkey CASCADE');
        DB::statement('ALTER TABLE modelo ALTER COLUMN id TYPE BIGINT USING id::bigint');
        DB::statement('CREATE SEQUENCE modelo_id_seq');
        DB::statement("ALTER TABLE modelo ALTER COLUMN id SET DEFAULT nextval('modelo_id_seq')");
        DB::statement('ALTER TABLE modelo ADD PRIMARY KEY (id)');

        // 4. Cambiar columnas en 'equipos' a unsigned big integer y reconstruir FK
        DB::statement('ALTER TABLE equipos ALTER COLUMN id_tipo TYPE BIGINT USING id_tipo::bigint');
        DB::statement('ALTER TABLE equipos ALTER COLUMN id_modelo TYPE BIGINT USING id_modelo::bigint');

        Schema::table('equipos', function (Blueprint $table) {
            $table->foreign('id_tipo')->references('id')->on('tipo_de_equipo');
            $table->foreign('id_modelo')->references('id')->on('modelo');
        });
    }

    public function down(): void
    {
        // Revertir sería complejo debido a los tipos de datos
    }
};
