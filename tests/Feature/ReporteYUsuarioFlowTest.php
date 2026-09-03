<?php

namespace Tests\Feature;

use App\Models\Lectura;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ReporteYUsuarioFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_reportes_and_session_detail(): void
    {
        $admin = User::factory()->create(['rol' => 'administrador']);

        DB::table('lecturas')->insert([
            [
                'rpm' => 120,
                'kg_procesados' => 10,
                'kg_hora' => 15,
                'temperatura' => 34,
                'estado_motor' => 'ON',
                'sesion_id' => 'SES-20260814-001',
                'created_at' => now()->subMinutes(2),
                'updated_at' => now()->subMinutes(2),
            ],
            [
                'rpm' => 140,
                'kg_procesados' => 18,
                'kg_hora' => 20,
                'temperatura' => 38,
                'estado_motor' => 'ON',
                'sesion_id' => 'SES-20260814-001',
                'created_at' => now()->subMinute(),
                'updated_at' => now()->subMinute(),
            ],
        ]);

        $this->actingAs($admin)
            ->get('/reportes')
            ->assertOk()
            ->assertSee('SES-20260814-001');

        $this->actingAs($admin)
            ->get('/reportes/sesion/SES-20260814-001')
            ->assertOk()
            ->assertSee('SES-20260814-001');
    }

    public function test_reportes_return_404_for_unknown_session(): void
    {
        $admin = User::factory()->create(['rol' => 'administrador']);

        $this->actingAs($admin)->get('/reportes/sesion/SES-INVALID-001')->assertStatus(404);
        $this->actingAs($admin)->get('/reportes/pdf/SES-INVALID-001')->assertStatus(404);
        $this->actingAs($admin)->get('/reportes/excel/SES-INVALID-001')->assertStatus(404);
    }

    public function test_admin_can_download_pdf_and_excel_for_a_session(): void
    {
        $admin = User::factory()->create(['rol' => 'administrador']);

        DB::table('lecturas')->insert([
            [
                'rpm' => 110,
                'kg_procesados' => 7,
                'kg_hora' => 14,
                'temperatura' => 31,
                'estado_motor' => 'ON',
                'sesion_id' => 'SES-20260814-003',
                'created_at' => now()->subMinutes(2),
                'updated_at' => now()->subMinutes(2),
            ],
        ]);

        $this->actingAs($admin)
            ->get('/reportes/pdf/SES-20260814-003')
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'application/pdf');

        $this->actingAs($admin)
            ->get('/reportes/excel/SES-20260814-003')
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    public function test_admin_can_manage_users_from_the_users_section(): void
    {
        $admin = User::factory()->create(['rol' => 'administrador']);

        $this->actingAs($admin)->get('/usuarios')->assertOk();

        $response = $this->actingAs($admin)->post('/usuarios', [
            'name' => 'Nuevo Usuario',
            'email' => 'nuevo@desgranadora.test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'rol' => 'operador',
        ]);

        $response->assertRedirect(route('usuarios.index', absolute: false));
        $this->assertDatabaseHas('users', ['email' => 'nuevo@desgranadora.test', 'rol' => 'operador']);

        $usuario = User::where('email', 'nuevo@desgranadora.test')->firstOrFail();

        $this->actingAs($admin)
            ->get('/usuarios/' . $usuario->id . '/editar')
            ->assertOk();

        $this->actingAs($admin)
            ->put('/usuarios/' . $usuario->id, [
                'name' => 'Usuario Actualizado',
                'email' => 'actualizado@desgranadora.test',
                'password' => 'password456',
                'password_confirmation' => 'password456',
                'rol' => 'supervisor',
            ])
            ->assertRedirect(route('usuarios.index', absolute: false));

        $this->assertDatabaseHas('users', ['email' => 'actualizado@desgranadora.test', 'rol' => 'supervisor']);
    }
}
