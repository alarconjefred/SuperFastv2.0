<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Empresa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnifiedLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_renders_properly(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Iniciar Sesión');
        $response->assertSee('Acceso unificado para clientes y empresas');
    }

    public function test_cliente_can_login_via_unified_login_and_redirects_to_dashboard(): void
    {
        $user = User::factory()->create([
            'email' => 'cliente@test.com',
            'password' => bcrypt('password123'),
            'role' => 'cliente',
        ]);

        $response = $this->post('/login', [
            'email' => 'cliente@test.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('dashboard'));
    }

    public function test_empresa_can_login_via_unified_login_and_redirects_to_empresa_index(): void
    {
        $user = User::factory()->create([
            'email' => 'restaurante@test.com',
            'password' => bcrypt('password123'),
            'role' => 'empresa',
        ]);

        Empresa::create([
            'nombre' => 'Pizzeria Bella',
            'user_id' => $user->id,
        ]);

        $response = $this->post('/login', [
            'email' => 'restaurante@test.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('empresa.index'));
    }

    public function test_invalid_credentials_returns_error(): void
    {
        $user = User::factory()->create([
            'email' => 'usuario@test.com',
            'password' => bcrypt('correctpassword'),
            'role' => 'cliente',
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => 'usuario@test.com',
            'password' => 'wrongpassword',
        ]);

        $this->assertGuest();
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
    }

    public function test_empresa_is_redirected_to_empresa_when_accessing_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'empresa',
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertRedirect(route('empresa.index'));
    }

    public function test_cliente_cannot_access_empresa_panel(): void
    {
        $user = User::factory()->create([
            'role' => 'cliente',
        ]);

        $response = $this->actingAs($user)->get('/empresa');

        $response->assertStatus(403);
    }

    public function test_legacy_login_empresa_route_redirects_to_login(): void
    {
        $response = $this->get('/login-empresa');

        $response->assertRedirect(route('login'));
    }
}
