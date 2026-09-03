<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RolAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_reportes_and_users_sections(): void
    {
        $admin = User::factory()->create(['rol' => 'administrador']);

        $this->actingAs($admin)->get('/dashboard')->assertOk();
        $this->actingAs($admin)->get('/reportes')->assertOk();
        $this->actingAs($admin)->get('/usuarios')->assertOk();
    }

    public function test_supervisor_can_access_reportes_but_not_users_sections(): void
    {
        $supervisor = User::factory()->create(['rol' => 'supervisor']);

        $this->actingAs($supervisor)->get('/reportes')->assertOk();
        $this->actingAs($supervisor)->get('/usuarios')->assertStatus(403);
    }

    public function test_operator_cannot_access_reportes_or_users_sections(): void
    {
        $operador = User::factory()->create(['rol' => 'operador']);

        $this->actingAs($operador)->get('/reportes')->assertStatus(403);
        $this->actingAs($operador)->get('/usuarios')->assertStatus(403);
    }

    public function test_guest_is_redirected_to_login_for_protected_routes(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
        $this->get('/reportes')->assertRedirect('/login');
    }
}
