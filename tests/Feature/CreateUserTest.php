<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Ensure a user with a non-soporte role can create another user,
     * and that password/confirmation mismatch triggers validation error.
     */
    public function test_password_confirmation_must_match_when_creating_user()
    {
        // make sure roles exist as they would after migrations
        $role = Role::firstOrCreate(['nombre' => 'administrador'], ['descripcion' => 'Acceso total al sistema']);

        // create an acting user with a role other than 'soporte'
        $actor = User::factory()->create([
            'id_rol' => $role->id,
        ]);

        $response = $this->actingAs($actor)->post(route('users.save'), [
            'name' => 'Nuevo',
            'lastname' => 'Usuario',
            'email' => 'nuevo@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'different',
            'id_rol' => $role->id,
            'id_estatus' => 1,
        ]);

        $response->assertSessionHasErrors('password');
    }
}
