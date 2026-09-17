<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Empresa;
use App\Models\Producto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductoYCarritoTest extends TestCase
{
    use RefreshDatabase;

    private function createEmpresaUser($name = 'Chef John', $empresaName = 'Burger SF'): array
    {
        $user = User::factory()->create([
            'name' => $name,
            'role' => 'empresa',
        ]);

        $empresa = Empresa::create([
            'nombre' => $empresaName,
            'user_id' => $user->id,
        ]);

        return [$user, $empresa];
    }

    private function createClienteUser($name = 'Cliente Feliz'): User
    {
        return User::factory()->create([
            'name' => $name,
            'role' => 'cliente',
        ]);
    }

    private function fakePngFile(string $name = 'test.png'): UploadedFile
    {
        // 1x1 pixel valid PNG
        $content = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');
        return UploadedFile::fake()->createWithContent($name, $content);
    }

    public function test_empresa_can_create_product_with_image_and_stock(): void
    {
        Storage::fake('public');

        [$user, $empresa] = $this->createEmpresaUser();
        $file = $this->fakePngFile('hamburguesa.png');

        $response = $this->actingAs($user)->post(route('productos.store', $empresa), [
            'nombre' => 'Super Doble Queso',
            'descripcion' => 'Carne Angus premium y queso cheddar',
            'precio' => 12.50,
            'stock' => 15,
            'disponible' => 1,
            'imagen' => $file,
        ]);

        $response->assertRedirect(route('empresa.index'));
        $this->assertDatabaseHas('productos', [
            'nombre' => 'Super Doble Queso',
            'precio' => 12.50,
            'stock' => 15,
            'disponible' => true,
            'empresa_id' => $empresa->id,
        ]);

        $producto = Producto::where('nombre', 'Super Doble Queso')->first();
        $this->assertNotNull($producto->imagen);
        Storage::disk('public')->assertExists($producto->imagen);
    }

    public function test_empresa_cannot_modify_another_empresa_product(): void
    {
        [$userA, $empresaA] = $this->createEmpresaUser('Empresa A', 'Restaurante A');
        [$userB, $empresaB] = $this->createEmpresaUser('Empresa B', 'Restaurante B');

        $productoB = Producto::create([
            'empresa_id' => $empresaB->id,
            'nombre' => 'Pizza Familiar',
            'precio' => 18.00,
            'stock' => 5,
            'disponible' => true,
        ]);

        // User A intenta editar producto de User B
        $response = $this->actingAs($userA)->put(route('productos.update', [$empresaA, $productoB]), [
            'nombre' => 'Hackeado',
            'precio' => 1.00,
            'stock' => 99,
        ]);

        $response->assertStatus(403);
    }

    public function test_empresa_can_update_product_and_replace_or_delete_image(): void
    {
        Storage::fake('public');

        [$user, $empresa] = $this->createEmpresaUser();
        $originalFile = $this->fakePngFile('foto1.png');

        $this->actingAs($user)->post(route('productos.store', $empresa), [
            'nombre' => 'Papas Fritas SF',
            'precio' => 4.50,
            'stock' => 20,
            'disponible' => 1,
            'imagen' => $originalFile,
        ]);

        $producto = Producto::where('nombre', 'Papas Fritas SF')->first();
        $originalPath = $producto->imagen;

        // Reemplazar imagen
        $newFile = $this->fakePngFile('foto2.png');
        $this->actingAs($user)->put(route('productos.update', [$empresa, $producto]), [
            'nombre' => 'Papas Fritas SF Crispy',
            'precio' => 5.00,
            'stock' => 25,
            'disponible' => 1,
            'imagen' => $newFile,
        ]);

        $producto->refresh();
        $this->assertEquals('Papas Fritas SF Crispy', $producto->nombre);
        $this->assertNotEquals($originalPath, $producto->imagen);
        Storage::disk('public')->assertMissing($originalPath);
        Storage::disk('public')->assertExists($producto->imagen);

        // Eliminar imagen explícitamente
        $this->actingAs($user)->put(route('productos.update', [$empresa, $producto]), [
            'nombre' => 'Papas Fritas SF Crispy',
            'precio' => 5.00,
            'stock' => 25,
            'disponible' => 1,
            'eliminar_imagen' => 1,
        ]);

        $producto->refresh();
        $this->assertNull($producto->imagen);
    }

    public function test_client_dashboard_displays_real_products(): void
    {
        [$empresaUser, $empresa] = $this->createEmpresaUser();

        $producto = Producto::create([
            'empresa_id' => $empresa->id,
            'nombre' => 'Empanada SuperFast',
            'descripcion' => 'Rellena de queso fresco fundido',
            'precio' => 2.75,
            'stock' => 12,
            'disponible' => true,
        ]);

        $cliente = $this->createClienteUser();

        $response = $this->actingAs($cliente)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Empanada SuperFast');
        $response->assertSee('$2.75');
        $response->assertSee('12 disp.');
        $response->assertSee($empresa->nombre);
        $response->assertSee('Agregar al carrito');
    }

    public function test_client_can_add_product_to_cart(): void
    {
        [$empresaUser, $empresa] = $this->createEmpresaUser();

        $producto = Producto::create([
            'empresa_id' => $empresa->id,
            'nombre' => 'Limonada Natural',
            'precio' => 3.00,
            'stock' => 10,
            'disponible' => true,
        ]);

        $cliente = $this->createClienteUser();

        $response = $this->actingAs($cliente)->post(route('carrito.agregar', $producto), [
            'cantidad' => 2,
        ]);

        $response->assertSessionHas('success');
        $this->assertEquals(2, session('cart')[$producto->id]['cantidad']);
    }

    public function test_client_cannot_add_more_units_than_available_stock(): void
    {
        [$empresaUser, $empresa] = $this->createEmpresaUser();

        $producto = Producto::create([
            'empresa_id' => $empresa->id,
            'nombre' => 'Postre Especial Limitado',
            'precio' => 6.00,
            'stock' => 3,
            'disponible' => true,
        ]);

        $cliente = $this->createClienteUser();

        $response = $this->actingAs($cliente)->post(route('carrito.agregar', $producto), [
            'cantidad' => 5,
        ]);

        $response->assertSessionHas('error');
        $this->assertNull(session('cart'));
    }

    public function test_cart_increment_decrement_and_removal(): void
    {
        [$empresaUser, $empresa] = $this->createEmpresaUser();

        $producto = Producto::create([
            'empresa_id' => $empresa->id,
            'nombre' => 'Tacos al Pastor',
            'precio' => 8.00,
            'stock' => 5,
            'disponible' => true,
        ]);

        $cliente = $this->createClienteUser();

        // 1. Agregar 1
        $this->actingAs($cliente)->post(route('carrito.agregar', $producto));
        $this->assertEquals(1, session('cart')[$producto->id]['cantidad']);

        // 2. Incrementar a 2
        $this->actingAs($cliente)->post(route('carrito.incrementar', $producto));
        $this->assertEquals(2, session('cart')[$producto->id]['cantidad']);

        // 3. Decrementar a 1
        $this->actingAs($cliente)->post(route('carrito.decrementar', $producto));
        $this->assertEquals(1, session('cart')[$producto->id]['cantidad']);

        // 4. Eliminar
        $this->actingAs($cliente)->delete(route('carrito.eliminar', $producto));
        $this->assertArrayNotHasKey($producto->id, session('cart', []));
    }

    public function test_cart_synchronizes_automatically_when_stock_drops_or_is_deactivated(): void
    {
        [$empresaUser, $empresa] = $this->createEmpresaUser();

        $producto = Producto::create([
            'empresa_id' => $empresa->id,
            'nombre' => 'Pizza Fugazzeta',
            'precio' => 14.00,
            'stock' => 10,
            'disponible' => true,
        ]);

        $cliente = $this->createClienteUser();

        // Cliente agrega 4 pizzas al carrito
        $this->actingAs($cliente)->post(route('carrito.agregar', $producto), ['cantidad' => 4]);
        $this->assertEquals(4, session('cart')[$producto->id]['cantidad']);

        // Empresa reduce el stock a 2
        $producto->update(['stock' => 2]);

        // Cliente visita el carrito: debe sincronizar la cantidad a 2 y mostrar advertencia
        $response = $this->actingAs($cliente)->get(route('carrito.index'));
        $response->assertStatus(200);
        $this->assertEquals(2, session('cart')[$producto->id]['cantidad']);
        $response->assertSee('se ajustó a 2 unid.');

        // Ahora la empresa desactiva el producto por completo
        $producto->update(['disponible' => false]);

        // Cliente visita el carrito: el producto se remueve automáticamente
        $response = $this->actingAs($cliente)->get(route('carrito.index'));
        $response->assertStatus(200);
        $this->assertArrayNotHasKey($producto->id, session('cart', []));
        $response->assertSee('Tu carrito está vacío');
    }
}
