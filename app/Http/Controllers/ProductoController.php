<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Empresa;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function show(Empresa $empresa, Producto $producto)
    {
        if ($empresa->user_id !== auth()->id()) {
            abort(403);
        }

        return view('productos.show', compact('empresa', 'producto'));
    }

    public function store(Request $request, Empresa $empresa)
    {
        if ($empresa->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0'
        ]);

        $empresa->productos()->create([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
        ]);

        return back()->with('success', 'Producto agregado');
    }

    public function edit(Empresa $empresa, Producto $producto)
    {
        if ($empresa->user_id !== auth()->id()) {
            abort(403);
        }

        return view('productos.edit', compact('empresa','producto'));
    }

    public function update(Request $request, Empresa $empresa, Producto $producto)
    {
        if ($empresa->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0'
        ]);

        $producto->update($request->only('nombre','precio'));

        return redirect()->route('empresa.index')
            ->with('success','Producto actualizado');
    }

    public function destroy(Empresa $empresa, Producto $producto)
    {
        if ($empresa->user_id !== auth()->id()) {
            abort(403);
        }

        $producto->delete();

        return redirect()->route('empresa.index')
            ->with('success','Producto eliminado');
    }
}