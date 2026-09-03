<?php

namespace Tests\Feature;

use App\Models\Lote;
use App\Models\Productor;
use App\Models\TipoMaiz;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoteIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_access_lotes_index(): void
    {
        $user = User::factory()->create(['rol' => 'operador']);

        $productor = Productor::create([
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'cedula' => '12345678',
            'telefono' => '0414-1234567',
            'municipio' => 'Ucureña',
        ]);

        $tipo = TipoMaiz::create([
            'nombre' => 'Maíz blanco',
            'descripcion' => 'Tipo local',
            'categoria' => 'blanco',
        ]);

        Lote::create([
            'productor_id' => $productor->id,
            'tipo_maiz_id' => $tipo->id,
            'sesion_id' => 'SES-001',
            'fecha_recepcion' => now()->toDateString(),
            'cantidad_kg' => 500,
            'estado' => 'pendiente',
        ]);

        $this->actingAs($user)
            ->get('/lotes')
            ->assertOk();
    }
}
