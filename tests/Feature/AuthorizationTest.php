<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use App\Models\Caso;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // migrations already insert roles via migration, so nothing special needed
        // seed minimal users
        $this->seed();
    }

    private function createRoleUser(string $roleName): User
    {
        $role = Role::firstOrCreate(['nombre' => $roleName]);
        return User::factory()->create(['id_rol' => $role->id]);
    }

    public function test_recepcionista_can_create_client_and_equipo_and_case_and_recepcion()
    {
        $user = $this->createRoleUser('recepcionista');

        // client creation
        $response = $this->actingAs($user)->post(route('clientes.save'), [
            'cedula' => 123456,
            'nombre' => 'Foo',
            'apellido' => 'Bar',
            'direccion' => 'Test',
            'tipo_cliente' => 'natural',
            'telefonos' => ['555-1111'],
            'emails' => ['foo@bar.com'],
        ]);
        $response->assertSessionHas('success');

        // equipo creation
        $response = $this->actingAs($user)->post(route('equipos.save'), [
            'nombre_tipo' => 'Laptop',
            'nombre_modelo' => 'X1',
            'serial_equipo' => 'S123',
        ]);
        $response->assertSessionHas('success');

        // create case
        $response = $this->actingAs($user)->post(route('casos.save'), [
            'id_cliente' => 123456,
            'descripcion_falla' => 'No enciende',
            'pieza_sugerida' => null,
            'forma_de_atencion' => 'presencial',
            'estatus' => 'asignado',
        ]);
        $response->assertSessionHas('success');
        $caseId = Caso::first()->id;

        // try to register reception (should succeed)
        $response = $this->actingAs($user)->post(route('recepcion.save'), [
            'id_caso' => $caseId,
            'id_equipo' => 1,
            'tipo_atencion' => 'presupuesto',
            'falla_tecnica' => '...',
        ]);
        // Even though there is automatic assignment of técnico, we just check for redirect
        $response->assertStatus(302);

        // recept/service: documentar case should be allowed for recepcionista
        $response = $this->actingAs($user)->post(route('casos.documentar'), [
            'id_caso' => $caseId,
            'id_pieza_soporte' => [1],
            'cantidad' => [1],
            'observacion' => 'testing',
        ]);
        $response->assertSessionHas('success');
    }

    public function test_soporte_cannot_create_case_but_can_update_own_and_not_others()
    {
        $soporte = $this->createRoleUser('soporte');
        $recep = $this->createRoleUser('recepcionista');

        // ensure there's a client to reference
        \App\Models\Cliente::create([
            'id' => 1,
            'nombre' => 'Cliente',
            'apellido' => 'Uno',
            'direccion' => 'aqui',
            'tipo_cliente' => 'natural',
        ]);

        // recepcionista creates a case assigned to soporte
        $this->actingAs($recep)->post(route('casos.save'), [
            'id_cliente' => 1,
            'descripcion_falla' => 'X',
            'pieza_sugerida' => null,
            'forma_de_atencion' => 'presencial',
            'estatus' => 'asignado',
        ]);
        $caso = Caso::first();
        // manually assign to soporte for test simplicity
        $caso->update(['id_usuario' => $soporte->id]);

        // soporte tries to create new case -> forbidden
        $resp = $this->actingAs($soporte)->post(route('casos.save'), [
            'id_cliente' => 1,
            'descripcion_falla' => 'should fail',
            'pieza_sugerida' => null,
            'forma_de_atencion' => 'presencial',
            'estatus' => 'asignado',
        ]);
        $resp->assertStatus(403);

        // support updates their own case -> ok
        $resp = $this->actingAs($soporte)->post(route('casos.update'), [
            'id' => $caso->id,
            'descripcion_falla' => 'nuevo',
            'pieza_sugerida' => '',
            'forma_de_atencion' => 'presencial',
            'estatus' => 'reparado',
        ]);
        $resp->assertSessionHas('success');

        // soporte can also document their own case
        $resp = $this->actingAs($soporte)->post(route('casos.documentar'), [
            'id_caso' => $caso->id,
            'id_pieza_soporte' => [1],
            'cantidad' => [1],
            'observacion' => 'soporte docs',
        ]);
        $resp->assertSessionHas('success');

        // support cannot update someone else's
        $other = $this->createRoleUser('soporte');
        $resp = $this->actingAs($other)->post(route('casos.update'), [
            'id' => $caso->id,
            'descripcion_falla' => 'bad',
            'pieza_sugerida' => '',
            'forma_de_atencion' => 'presencial',
            'estatus' => 'reparado',
        ]);
        $resp->assertStatus(403);
    }

    public function test_soporte_cannot_access_client_management()
    {
        $soporte = $this->createRoleUser('soporte');

        // link shouldn't be visible on home
        $resp = $this->actingAs($soporte)->get(route('home'));
        $resp->assertDontSee('Clientes');

        // visiting the management route should be forbidden
        $resp = $this->actingAs($soporte)->get(route('gestion-clientes'));
        $resp->assertStatus(403);

        // attempting to create a client is already covered but double-check
        $resp = $this->actingAs($soporte)->post(route('clientes.save'), [
            'cedula' => 42,
            'nombre' => 'X',
            'apellido' => 'Y',
            'direccion' => 'Z',
            'tipo_cliente' => 'natural',
            'telefonos' => ['1'],
            'emails' => ['a@b.com'],
        ]);
        $resp->assertStatus(403);
    }

    public function test_admin_cannot_modify_domain_data_but_can_manage_users_and_view_audit()
    {
        $admin = $this->createRoleUser('administrador');
        // try to create client -> forbidden
        $resp = $this->actingAs($admin)->post(route('clientes.save'), [
            'cedula' => 999,
            'nombre' => 'Foo',
            'apellido' => 'Bar',
            'direccion' => 'Test',
            'tipo_cliente' => 'natural',
            'telefonos' => ['1'],
            'emails' => ['a@b.com'],
        ]);
        $resp->assertStatus(403);

        // admin should be able to access user management page
        $resp = $this->actingAs($admin)->get(route('gestion-usuarios'));
        $resp->assertStatus(200);

        // admin should be able to open the stats page (link is shown in nav)
        $resp = $this->actingAs($admin)->get(route('estadisticas'));
        $resp->assertStatus(200);

        // but admin cannot fetch the report data
        $resp = $this->actingAs($admin)->get(route('reportes.data'), ['tipoReporte' => 'recibidos_atencion']);
        $resp->assertStatus(403);

        // audit page
        $resp = $this->actingAs($admin)->get(route('gestion-auditoria'));
        $resp->assertStatus(200);

        // admin should be forbidden to document any case
        $resp = $this->actingAs($admin)->post(route('casos.documentar'), [
            'id_caso' => 1,
            'id_pieza_soporte' => [1],
            'cantidad' => [1],
            'observacion' => 'admin trying to doc',
        ]);
        $resp->assertStatus(403);
    }

    public function test_supervisor_has_admin_rights_plus_stats()
    {
        $sup = $this->createRoleUser('supervisor');
        $resp = $this->actingAs($sup)->get(route('gestion-usuarios'));
        $resp->assertStatus(200);
        $resp = $this->actingAs($sup)->get(route('estadisticas'));
        $resp->assertStatus(200);

        // supervisor may retrieve data
        $resp = $this->actingAs($sup)->get(route('reportes.data'), ['tipoReporte' => 'recibidos_atencion']);
        $resp->assertStatus(200);
        $json = $resp->json();
        $this->assertArrayHasKey('labels', $json);
        $this->assertArrayHasKey('data', $json);

        // supervisor should not be able to document (only soporte/recepcionista)
        $resp = $this->actingAs($sup)->post(route('casos.documentar'), [
            'id_caso' => 1,
            'id_pieza_soporte' => [1],
            'cantidad' => [1],
            'observacion' => 'sup fail',
        ]);
        $resp->assertStatus(403);
    }
}
