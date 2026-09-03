<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProtectedPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_users_can_access_main_app_sections(): void
    {
        $user = User::factory()->create(['rol' => 'operador']);

        $routes = [
            '/dashboard',
            '/estadisticas',
            '/historial',
            '/maquina',
            '/manual',
            '/acerca',
            '/contacto',
        ];

        foreach ($routes as $route) {
            $this->actingAs($user)->get($route)->assertOk();
        }
    }

    public function test_guests_are_redirected_from_main_app_sections(): void
    {
        $routes = [
            '/dashboard',
            '/estadisticas',
            '/historial',
            '/maquina',
            '/manual',
            '/acerca',
            '/contacto',
        ];

        foreach ($routes as $route) {
            $this->get($route)->assertRedirect('/login');
        }
    }
}
