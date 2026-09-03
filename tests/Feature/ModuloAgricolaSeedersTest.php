<?php

namespace Tests\Feature;

use App\Models\Alerta;
use App\Models\Clasificacion;
use App\Models\Lote;
use App\Models\Productor;
use App\Models\TipoMaiz;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModuloAgricolaSeedersTest extends TestCase
{
    use RefreshDatabase;

    public function test_demo_seeders_create_agricultural_data(): void
    {
        $this->artisan('db:seed')->assertSuccessful();

        $this->assertGreaterThanOrEqual(3, Productor::count());
        $this->assertGreaterThanOrEqual(4, TipoMaiz::count());
        $this->assertGreaterThanOrEqual(2, Lote::count());
        $this->assertGreaterThanOrEqual(2, Clasificacion::count());
        $this->assertGreaterThanOrEqual(2, Alerta::count());
    }
}
