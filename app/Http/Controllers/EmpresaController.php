<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EmpresaController extends Controller
{
    //  metodo registrar empresa
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed|min:6',
    ]);

    // Crear usuario
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'empresa',
    ]);

    
    Empresa::create([
        'nombre' => $request->name,
        'user_id' => $user->id,
    ]);

        return redirect()->route('login')
            ->with('success', '¡Empresa registrada correctamente! Ya puedes iniciar sesión.');
    }

    public function index()
    {
        $empresa = Empresa::where('user_id', auth()->id())->first();

        if(!$empresa){
            $empresa = Empresa::create([
                'nombre' => auth()->user()->name ?? 'Mi Empresa',
                'user_id' => auth()->id(),
            ]);
        }

        $productos = $empresa->productos;

        return view('empresa', compact('empresa','productos'));
    }
}