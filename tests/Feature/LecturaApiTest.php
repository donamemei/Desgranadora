<?php

namespace Tests\Feature;

use App\Models\Lectura;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LecturaApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_arduino_can_create_a_lectura(): void
    {
        $payload = [
            'rpm' => 450.5,
            'kg_procesados' => 3.72,
            'kg_hora' => 22.3,
            'temperatura' => 38.1,
            'estado_motor' => 'ON',
            'sesion_id' => 'SES-20260814-001',
        ];

        $response = $this->postJson('/api/lectura', $payload);

        $response->assertStatus(201)
            ->assertJsonPath('ok', true)
            ->assertJsonStructure([
                'ok',
                'id',
                'guardado_a',
            ]);

        $this->assertDatabaseHas('lecturas', [
            'sesion_id' => 'SES-20260814-001',
            'rpm' => 450.5,
            'estado_motor' => 'ON',
        ]);
    }

    public function test_it_returns_the_latest_lectura(): void
    {
        DB::table('lecturas')->insert([
            [
                'rpm' => 401.2,
                'kg_procesados' => 10.0,
                'kg_hora' => 20.5,
                'temperatura' => 36.5,
                'estado_motor' => 'OFF',
                'sesion_id' => 'SES-20260814-001',
                'created_at' => now()->subMinutes(5),
                'updated_at' => now()->subMinutes(5),
            ],
            [
                'rpm' => 512.8,
                'kg_procesados' => 15.5,
                'kg_hora' => 25.9,
                'temperatura' => 40.2,
                'estado_motor' => 'ON',
                'sesion_id' => 'SES-20260814-002',
                'created_at' => now()->subMinutes(1),
                'updated_at' => now()->subMinutes(1),
            ],
        ]);

        $response = $this->getJson('/api/lectura/ultimo');

        $response->assertOk()
            ->assertJsonPath('ok', true)
            ->assertJsonPath('rpm', 512.8)
            ->assertJsonPath('estado_motor', 'ON')
            ->assertJsonPath('sesion_id', 'SES-20260814-002');
    }

    public function test_it_returns_lecturas_for_a_specific_session(): void
    {
        Lectura::create([
            'rpm' => 100,
            'kg_procesados' => 5,
            'kg_hora' => 20,
            'temperatura' => 35,
            'estado_motor' => 'ON',
            'sesion_id' => 'SES-20260814-001',
        ]);

        Lectura::create([
            'rpm' => 150,
            'kg_procesados' => 7,
            'kg_hora' => 22,
            'temperatura' => 39,
            'estado_motor' => 'ON',
            'sesion_id' => 'SES-20260814-001',
        ]);

        Lectura::create([
            'rpm' => 80,
            'kg_procesados' => 2,
            'kg_hora' => 18,
            'temperatura' => 33,
            'estado_motor' => 'OFF',
            'sesion_id' => 'SES-20260814-002',
        ]);

        $response = $this->getJson('/api/lectura/sesion/SES-20260814-001');

        $response->assertOk()
            ->assertJsonPath('sesion', 'SES-20260814-001')
            ->assertJsonPath('total', 2)
            ->assertJsonPath('resumen.total_lecturas', 2)
            ->assertJsonCount(2, 'lecturas');
    }

    public function test_it_returns_the_session_list_and_machine_status(): void
    {
        DB::table('lecturas')->insert([
            [
                'rpm' => 100,
                'kg_procesados' => 10,
                'kg_hora' => 12,
                'temperatura' => 30,
                'estado_motor' => 'ON',
                'sesion_id' => 'SES-20260814-001',
                'created_at' => now()->subSeconds(5),
                'updated_at' => now()->subSeconds(5),
            ],
        ]);

        $responseSesiones = $this->getJson('/api/sesiones');

        $responseSesiones->assertOk()
            ->assertJsonPath('total', 1)
            ->assertJsonPath('sesiones.0.sesion_id', 'SES-20260814-001');

        $responseEstado = $this->getJson('/api/estado');

        $responseEstado->assertOk()
            ->assertJsonPath('estado', 'online')
            ->assertJsonPath('etiqueta', 'En línea')
            ->assertJsonPath('color', 'success');
    }
}
