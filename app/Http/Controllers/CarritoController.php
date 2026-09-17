<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    /**
     * Muestra la vista del carrito sincronizada con el stock de la base de datos
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $warnings = [];
        $cartUpdated = false;

        foreach ($cart as $id => $item) {
            $producto = Producto::with('empresa')->find($id);

            // 1. Si el producto ya no existe en la base de datos
            if (!$producto) {
                unset($cart[$id]);
                $warnings[] = "El producto '{$item['nombre']}' ya no existe y fue retirado de tu carrito.";
                $cartUpdated = true;
                continue;
            }

            // 2. Si el producto fue marcado como no disponible por la empresa
            if (!$producto->disponible) {
                unset($cart[$id]);
                $warnings[] = "El producto '{$producto->nombre}' fue desactivado por el comercio y se retiró del carrito.";
                $cartUpdated = true;
                continue;
            }

            // 3. Si el stock llegó a 0
            if ($producto->stock <= 0) {
                unset($cart[$id]);
                $warnings[] = "El producto '{$producto->nombre}' se ha agotado y se retiró de tu carrito.";
                $cartUpdated = true;
                continue;
            }

            // 4. Si la cantidad solicitada supera el stock disponible actualizado
            if ($item['cantidad'] > $producto->stock) {
                $cart[$id]['cantidad'] = $producto->stock;
                $warnings[] = "La cantidad de '{$producto->nombre}' se ajustó a {$producto->stock} unid. por disponibilidad de stock.";
                $cartUpdated = true;
            }

            // Sincronizar datos frescos (precio, foto, nombre de empresa)
            $cart[$id]['nombre'] = $producto->nombre;
            $cart[$id]['precio'] = (float) $producto->precio;
            $cart[$id]['stock'] = $producto->stock;
            $cart[$id]['imagen_url'] = $producto->imagen_url;
            $cart[$id]['empresa_nombre'] = $producto->empresa ? $producto->empresa->nombre : 'Comercio Local';
        }

        if ($cartUpdated) {
            session()->put('cart', $cart);
        }

        // Calcular totales
        $total = 0;
        $totalArticulos = 0;
        foreach ($cart as $item) {
            $total += $item['precio'] * $item['cantidad'];
            $totalArticulos += $item['cantidad'];
        }

        return view('carrito', compact('cart', 'total', 'totalArticulos', 'warnings'));
    }

    /**
     * Agrega un producto al carrito verificando stock y disponibilidad
     */
    public function agregar(Request $request, Producto $producto)
    {
        if (!$producto->disponible || $producto->stock <= 0) {
            return redirect()->back()->with('error', 'Este producto no está disponible para su compra.');
        }

        $cantidadSolicitada = max(1, (int) $request->input('cantidad', 1));
        $cart = session()->get('cart', []);

        $cantidadActual = isset($cart[$producto->id]) ? $cart[$producto->id]['cantidad'] : 0;
        $nuevaCantidad = $cantidadActual + $cantidadSolicitada;

        if ($nuevaCantidad > $producto->stock) {
            return redirect()->back()->with('error', "No puedes agregar más unidades. El stock máximo disponible es de {$producto->stock} unidades.");
        }

        $cart[$producto->id] = [
            'id' => $producto->id,
            'nombre' => $producto->nombre,
            'precio' => (float) $producto->precio,
            'cantidad' => $nuevaCantidad,
            'stock' => $producto->stock,
            'imagen_url' => $producto->imagen_url,
            'empresa_nombre' => $producto->empresa ? $producto->empresa->nombre : 'Comercio Local',
        ];

        session()->put('cart', $cart);

        return redirect()->back()->with('success', "¡'{$producto->nombre}' fue agregado a tu carrito!");
    }

    /**
     * Incrementa la cantidad de un producto en el carrito respetando el stock
     */
    public function incrementar(Producto $producto)
    {
        $cart = session()->get('cart', []);

        if (!isset($cart[$producto->id])) {
            return redirect()->route('carrito.index')->with('error', 'El producto no se encuentra en el carrito.');
        }

        // Validar contra el stock actual en base de datos
        if ($cart[$producto->id]['cantidad'] + 1 > $producto->stock) {
            return redirect()->route('carrito.index')->with('error', "Stock máximo alcanzado ({$producto->stock} disponibles).");
        }

        $cart[$producto->id]['cantidad']++;
        session()->put('cart', $cart);

        return redirect()->route('carrito.index');
    }

    /**
     * Decrementa la cantidad de un producto o lo elimina si llega a cero
     */
    public function decrementar(Producto $producto)
    {
        $cart = session()->get('cart', []);

        if (!isset($cart[$producto->id])) {
            return redirect()->route('carrito.index')->with('error', 'El producto no se encuentra en el carrito.');
        }

        if ($cart[$producto->id]['cantidad'] > 1) {
            $cart[$producto->id]['cantidad']--;
        } else {
            unset($cart[$producto->id]);
        }

        session()->put('cart', $cart);

        return redirect()->route('carrito.index');
    }

    /**
     * Elimina un producto específico del carrito
     */
    public function eliminar(Producto $producto)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$producto->id])) {
            $nombre = $cart[$producto->id]['nombre'];
            unset($cart[$producto->id]);
            session()->put('cart', $cart);
            return redirect()->route('carrito.index')->with('success', "Se eliminó '{$nombre}' del carrito.");
        }

        return redirect()->route('carrito.index');
    }

    /**
     * Vacía todos los productos del carrito
     */
    public function vaciar()
    {
        session()->forget('cart');
        return redirect()->route('carrito.index')->with('success', 'El carrito ha sido vaciado.');
    }
}
