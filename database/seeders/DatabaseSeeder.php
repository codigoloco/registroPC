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
            'email' => 'test@test.com',
            'password' => '123456789',            
            'id_rol' => 1, // Administrador
        ]);

        User::factory()->create([
            'name' => 'Tecnico',
            'lastname' => 'De Soporte',
            'email' => 'tecnico@test.com',
            'password' => '123456789',            
            'id_rol' => 2, // Soporte
        ]);

        // Llamar al seeder de piezas de soporte
        $this->call([
            PiezaSoporteSeeder::class,
        ]);
    }
}
