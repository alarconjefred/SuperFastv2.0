<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Empresa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Laravel\Socialite\Facades\Socialite;
use Mockery;
use Tests\TestCase;

class GoogleAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Config::set('services.google.client_id', 'test-google-client-id');
        Config::set('services.google.client_secret', 'test-google-client-secret');
        Config::set('services.google.redirect', 'http://127.0.0.1:8000/auth/google/callback');
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    protected function mockGoogleUser(string $id, string $name, string $email): void
    {
        $abstractUser = Mockery::mock('Laravel\Socialite\Two\User');
        $abstractUser->shouldReceive('getId')->andReturn($id);
        $abstractUser->shouldReceive('getName')->andReturn($name);
        $abstractUser->shouldReceive('getEmail')->andReturn($email);

        $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $provider->shouldReceive('user')->andReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);
    }

    /**
     * Prueba 1: El registro tradicional de cliente y empresa sigue funcionando intacto.
     */
    public function test_traditional_registration_works_for_client_and_empresa(): void
    {
        // Registro tradicional cliente
        $clientResponse = $this->post('/register', [
            'name' => 'Cliente Tradicional',
            'email' => 'tradicional_cliente@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $clientResponse->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('users', [
            'email' => 'tradicional_cliente@test.com',
            'role' => 'cliente',
        ]);

        $this->post('/logout');

        // Registro tradicional empresa
        $empresaResponse = $this->post('/register-empresa', [
            'name' => 'Restaurante El Tradicional',
            'email' => 'tradicional_empresa@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $empresaResponse->assertRedirect(route('login'));
        $this->assertDatabaseHas('users', [
            'email' => 'tradicional_empresa@test.com',
            'role' => 'empresa',
        ]);
        $this->assertDatabaseHas('empresas', [
            'nombre' => 'Restaurante El Tradicional',
        ]);
    }

    /**
     * Prueba 2: El inicio de sesión tradicional con correo y contraseña sigue funcionando.
     */
    public function test_traditional_login_works_properly(): void
    {
        $user = User::factory()->create([
            'email' => 'login_tradicional@test.com',
            'password' => bcrypt('secret1234'),
            'role' => 'cliente',
        ]);

        $response = $this->post('/login', [
            'email' => 'login_tradicional@test.com',
            'password' => 'secret1234',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('dashboard'));
    }

    /**
     * Prueba 3a: Nuevo usuario mediante Google OAuth (rol por defecto 'cliente').
     */
    public function test_new_user_with_google_creates_cliente_and_redirects_to_dashboard(): void
    {
        $this->mockGoogleUser('google-uid-1001', 'Laura Morales', 'laura@morales.com');

        $response = $this->withSession(['google_auth_role' => 'cliente'])
            ->get('/auth/google/callback');

        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('users', [
            'email' => 'laura@morales.com',
            'google_id' => 'google-uid-1001',
            'name' => 'Laura Morales',
            'role' => 'cliente',
        ]);

        $user = User::where('email', 'laura@morales.com')->first();
        $this->assertNotNull($user->email_verified_at);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Prueba 3b: Nuevo usuario mediante Google OAuth con solicitud de rol 'empresa'.
     * Debe crear User con rol 'empresa', registro en 'empresas', y redirigir a empresa.index.
     */
    public function test_new_user_with_google_as_empresa_creates_user_and_empresa_record(): void
    {
        $this->mockGoogleUser('google-uid-2002', 'Pizzería Napolitana', 'contacto@napolitana.com');

        $response = $this->withSession(['google_auth_role' => 'empresa'])
            ->get('/auth/google/callback');

        $response->assertRedirect(route('empresa.index'));

        $this->assertDatabaseHas('users', [
            'email' => 'contacto@napolitana.com',
            'google_id' => 'google-uid-2002',
            'name' => 'Pizzería Napolitana',
            'role' => 'empresa',
        ]);

        $user = User::where('email', 'contacto@napolitana.com')->first();
        $this->assertDatabaseHas('empresas', [
            'user_id' => $user->id,
            'nombre' => 'Pizzería Napolitana',
        ]);

        $this->assertAuthenticatedAs($user);
    }

    /**
     * Prueba 4: Usuario existente por correo tradicional inicia sesión con Google sin duplicar cuenta.
     */
    public function test_existing_user_by_email_logs_in_and_links_google_id_without_duplication(): void
    {
        $existingUser = User::factory()->create([
            'name' => 'Juan Perez',
            'email' => 'juanperez@example.com',
            'password' => bcrypt('original_password_123'),
            'role' => 'cliente',
            'google_id' => null,
        ]);

        $this->mockGoogleUser('google-uid-3003', 'Juan P.', 'juanperez@example.com');

        $response = $this->get('/auth/google/callback');

        $response->assertRedirect(route('dashboard'));

        // No se deben crear usuarios adicionales
        $this->assertEquals(1, User::where('email', 'juanperez@example.com')->count());

        $existingUser->refresh();
        // google_id vinculado
        $this->assertEquals('google-uid-3003', $existingUser->google_id);
        // Rol mantenido
        $this->assertEquals('cliente', $existingUser->role);
        // Nombre original preservado
        $this->assertEquals('Juan Perez', $existingUser->name);

        $this->assertAuthenticatedAs($existingUser);
    }

    /**
     * Prueba 5: Usuario existente con rol 'empresa' no pierde su rol ni su relación con Empresa.
     */
    public function test_existing_empresa_user_preserves_role_and_empresa_relationship(): void
    {
        $userEmpresa = User::factory()->create([
            'name' => 'Donas Gourmet',
            'email' => 'pedidos@donasgourmet.com',
            'password' => bcrypt('passwordEmpresa123'),
            'role' => 'empresa',
            'google_id' => null,
        ]);

        $empresa = Empresa::create([
            'nombre' => 'Donas Gourmet Local 5',
            'direccion' => 'Calle 100 # 15-20',
            'user_id' => $userEmpresa->id,
        ]);

        $this->mockGoogleUser('google-uid-4004', 'Donas Google Name', 'pedidos@donasgourmet.com');

        // Aunque se pase 'cliente' en sesión accidentalmente, prevalece el rol existente
        $response = $this->withSession(['google_auth_role' => 'cliente'])
            ->get('/auth/google/callback');

        $response->assertRedirect(route('empresa.index'));

        $userEmpresa->refresh();
        $this->assertEquals('empresa', $userEmpresa->role);
        $this->assertEquals('google-uid-4004', $userEmpresa->google_id);

        $this->assertDatabaseHas('empresas', [
            'id' => $empresa->id,
            'nombre' => 'Donas Gourmet Local 5',
            'user_id' => $userEmpresa->id,
        ]);

        $this->assertAuthenticatedAs($userEmpresa);
    }

    /**
     * Prueba 6: Usuario cancela la autorización de Google OAuth (error=access_denied).
     */
    public function test_user_cancelling_google_oauth_redirects_to_login_gracefully(): void
    {
        $response = $this->get('/auth/google/callback?error=access_denied');

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('info', 'Has cancelado el inicio de sesión con Google.');
        $this->assertGuest();
    }

    /**
     * Prueba 7: Error cuando las credenciales de Google OAuth no están configuradas en .env.
     */
    public function test_unconfigured_google_credentials_redirects_with_safe_message(): void
    {
        Config::set('services.google.client_id', null);
        Config::set('services.google.client_secret', null);

        // Intento de redirect
        $response = $this->get('/auth/google');
        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error');
        $this->assertGuest();

        // Intento directo de callback
        $callbackResponse = $this->get('/auth/google/callback');
        $callbackResponse->assertRedirect(route('login'));
        $callbackResponse->assertSessionHas('error');
    }

    /**
     * Prueba 8: Cierre de sesión (logout) sigue funcionando correctamente.
     */
    public function test_logout_continues_working_after_oauth_implementation(): void
    {
        $user = User::factory()->create(['role' => 'cliente']);
        $this->actingAs($user);

        $response = $this->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
