<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'lastname' => 'System',
            'email' => 'admin@test.com',
            'password' => '12341234',
            'id_rol' => 1, // Administrador
        ]);

        User::factory()->create([
            'name' => 'SoporteTecnico',
            'lastname' => 'TEST',
            'email' => 'soporte@test.com',
            'password' => '12341234',
            'id_rol' => 2, // Soporte
        ]);

        User::factory()->create([
            'name' => 'Recepcionista',
            'lastname' => 'TEST',
            'email' => 'recep@test.com',
            'password' => '12341234',
            'id_rol' => 3, // Recepcionista
        ]);

        User::factory()->create([
            'name' => 'Supervisor',
            'lastname' => 'TEST',
            'email' => 'supervisor@test.com',
            'password' => '12341234',
            'id_rol' => 4, // Supervisor
        ]);

        // Llamar al seeder de piezas de soporte
        $this->call([
            PiezaSoporteSeeder::class ,
        ]);
    }
}
