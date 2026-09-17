<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Empresa;
use App\Models\Producto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InicioEmpresasTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Caso 1: Cuando NO hay empresas registradas en la base de datos,
     * se muestra el empty state amigable con invitación y CTA sin errores PHP.
     */
    public function test_case_1_empty_state_rendered_when_no_empresas_exist(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Próximamente comercios en tu zona');
        $response->assertSee('Registrar mi Empresa');
        $response->assertSee('Crear cuenta de cliente');
        $response->assertDontSee('Menú en preparación');
    }

    /**
     * Caso 2: Empresa registrada que AÚN NO tiene productos publicados.
     * Muestra la tarjeta con su nombre e iniciales y el bloque "Menú en preparación".
     */
    public function test_case_2_empresa_without_products_renders_gracefully(): void
    {
        $user = User::factory()->create(['role' => 'empresa']);
        $empresa = Empresa::create([
            'nombre' => 'Cafetería del Parque',
            'direccion' => 'Calle 10 # 4-20',
            'user_id' => $user->id,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Cafetería del Parque');
        $response->assertSee('Calle 10 # 4-20');
        $response->assertSee('Menú en preparación');
        $response->assertSee('Disponible próximamente');
        $response->assertDontSee('Próximamente comercios en tu zona');
    }

    /**
     * Caso 3: Empresa con producto publicado muestra datos reales, precio formateado y stock.
     */
    public function test_case_3_empresa_with_products_displays_product_info_and_formatted_price(): void
    {
        $user = User::factory()->create(['role' => 'empresa']);
        $empresa = Empresa::create([
            'nombre' => 'Burger Masters',
            'direccion' => 'Av. Central # 15-30',
            'user_id' => $user->id,
        ]);

        Producto::create([
            'empresa_id' => $empresa->id,
            'nombre' => 'Hamburguesa Doble Queso',
            'descripcion' => 'Carne 100% de res con queso cheddar derretido',
            'precio' => 28500,
            'stock' => 12,
            'disponible' => true,
            'imagen' => null,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Burger Masters');
        $response->assertSee('Hamburguesa Doble Queso');
        $response->assertSee('$ 28.500');
        $response->assertSee('En Stock (12)');
    }

    /**
     * Caso 4: Producto sin imagen propia utiliza el fallback de imagen_url.
     */
    public function test_case_4_product_without_image_uses_default_fallback(): void
    {
        $user = User::factory()->create(['role' => 'empresa']);
        $empresa = Empresa::create([
            'nombre' => 'Heladería Polar',
            'user_id' => $user->id,
        ]);

        $producto = Producto::create([
            'empresa_id' => $empresa->id,
            'nombre' => 'Helado Artesanal',
            'precio' => 7000,
            'stock' => 5,
            'disponible' => true,
            'imagen' => null,
        ]);

        $this->assertStringContainsString('Version compacta.jpg', $producto->imagen_url);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Helado Artesanal');
        $response->assertSee($producto->imagen_url);
    }

    /**
     * Caso 5: Empresa sin logo muestra sus iniciales estilizadas calculadas dinámicamente.
     */
    public function test_case_5_empresa_without_logo_displays_stylized_initials(): void
    {
        $user = User::factory()->create(['role' => 'empresa']);
        $empresa = Empresa::create([
            'nombre' => 'Pizzería Bella',
            'user_id' => $user->id,
        ]);

        $this->assertEquals('PB', $empresa->iniciales);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('PB');
    }

    /**
     * Caso 6: Empresa con dirección nula muestra el badge de "Comercio Aliado Verificado".
     */
    public function test_case_6_empresa_without_address_displays_verified_fallback_badge(): void
    {
        $user = User::factory()->create(['role' => 'empresa']);
        $empresaSinDir = Empresa::create([
            'nombre' => 'Pastelería Dulce',
            'direccion' => null,
            'user_id' => $user->id,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Pastelería Dulce');
        $response->assertSee('Comercio Aliado Verificado');
    }

    /**
     * Caso 7: Cuando existen muchas empresas registradas, se limita a 6 en la página de inicio.
     */
    public function test_case_7_multiple_empresas_are_capped_at_six_on_homepage(): void
    {
        for ($i = 1; $i <= 8; $i++) {
            $user = User::factory()->create(['email' => "empresa{$i}@test.com", 'role' => 'empresa']);
            $empresa = Empresa::create([
                'nombre' => "Negocio Numero {$i}",
                'user_id' => $user->id,
            ]);

            Producto::create([
                'empresa_id' => $empresa->id,
                'nombre' => "Producto {$i}",
                'precio' => 1000 * $i,
                'stock' => 10,
                'disponible' => true,
            ]);
        }

        $response = $this->get('/');
        $response->assertStatus(200);

        // Debe contener la colección de empresas limitada a 6
        $empresasEnVista = $response->viewData('empresas');
        $this->assertCount(6, $empresasEnVista);
    }
}
