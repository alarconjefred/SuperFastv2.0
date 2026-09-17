<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    /**
     * Muestra el detalle del producto para la empresa propietaria
     */
    public function show(Empresa $empresa, Producto $producto)
    {
        $this->authorizeOwner($empresa, $producto);

        return view('productos.show', compact('empresa', 'producto'));
    }

    /**
     * Registra un nuevo producto con imagen, descripción y stock
     */
    public function store(Request $request, Empresa $empresa)
    {
        if ($empresa->user_id !== auth()->id()) {
            abort(403, 'No tienes autorización para gestionar esta empresa.');
        }

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'disponible' => 'nullable|boolean',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ], [
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número válido.',
            'stock.required' => 'Debes indicar el stock disponible.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' => 'El stock no puede ser negativo.',
            'imagen.image' => 'El archivo debe ser una imagen válida.',
            'imagen.mimes' => 'Formatos permitidos: JPG, PNG, WEBP.',
            'imagen.max' => 'La imagen no debe superar los 3 MB.',
        ]);

        $imagenPath = null;
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('productos', 'public');
        }

        $empresa->productos()->create([
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'] ?? null,
            'precio' => $validated['precio'],
            'stock' => $validated['stock'],
            'disponible' => $request->boolean('disponible', true),
            'imagen' => $imagenPath,
        ]);

        return redirect()->route('empresa.index')->with('success', '¡Producto agregado exitosamente a tu catálogo!');
    }

    /**
     * Formulario de edición de producto
     */
    public function edit(Empresa $empresa, Producto $producto)
    {
        $this->authorizeOwner($empresa, $producto);

        return view('Productos.edit', compact('empresa', 'producto'));
    }

    /**
     * Actualiza la información del producto, permitiendo reemplazar o eliminar imagen
     */
    public function update(Request $request, Empresa $empresa, Producto $producto)
    {
        $this->authorizeOwner($empresa, $producto);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'disponible' => 'nullable|boolean',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'eliminar_imagen' => 'nullable|boolean',
        ], [
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número válido.',
            'stock.required' => 'Debes indicar el stock disponible.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' => 'El stock no puede ser negativo.',
            'imagen.image' => 'El archivo debe ser una imagen válida.',
            'imagen.mimes' => 'Formatos permitidos: JPG, PNG, WEBP.',
            'imagen.max' => 'La imagen no debe superar los 3 MB.',
        ]);

        $imagenPath = $producto->imagen;

        // Opción 1: Eliminar imagen explícitamente
        if ($request->boolean('eliminar_imagen')) {
            if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $imagenPath = null;
        }

        // Opción 2: Reemplazar imagen por una nueva
        if ($request->hasFile('imagen')) {
            if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $imagenPath = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update([
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'] ?? null,
            'precio' => $validated['precio'],
            'stock' => $validated['stock'],
            'disponible' => $request->boolean('disponible', true),
            'imagen' => $imagenPath,
        ]);

        return redirect()->route('empresa.index')
            ->with('success', '¡Producto actualizado exitosamente!');
    }

    /**
     * Elimina el producto y su archivo de imagen asociado
     */
    public function destroy(Empresa $empresa, Producto $producto)
    {
        $this->authorizeOwner($empresa, $producto);

        if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();

        return redirect()->route('empresa.index')
            ->with('success', '¡Producto eliminado del catálogo!');
    }

    /**
     * Valida de manera estricta que la empresa y el producto pertenezcan al usuario autenticado
     */
    protected function authorizeOwner(Empresa $empresa, Producto $producto): void
    {
        if ($empresa->user_id !== auth()->id() || $producto->empresa_id !== $empresa->id) {
            abort(403, 'No tienes autorización para gestionar este producto.');
        }
    }
}