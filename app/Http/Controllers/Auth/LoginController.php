<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    // Vista de login unificado
    public function create()
    {
        if (auth()->check()) {
            return $this->redirectBasedOnRole(auth()->user());
        }

        return view('auth.login');
    }

    // Procesar login unificado para clientes y empresas
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingresa un correo electrónico válido.',
            'password.required' => 'La contraseña es requerida.',
        ]);

        $remember = $request->boolean('remember');

        if (!auth()->attempt($credentials, $remember)) {
            throw ValidationException::withMessages([
                'email' => 'Estas credenciales no coinciden con nuestros registros.',
            ]);
        }

        $request->session()->regenerate();

        return $this->redirectBasedOnRole(auth()->user());
    }

    // Redirección inteligente basada en el rol
    protected function redirectBasedOnRole($user)
    {
        if ($user->role === 'empresa') {
            return redirect()->intended(route('empresa.index'));
        }

        // Por defecto rol cliente
        return redirect()->intended(route('dashboard'));
    }

    // Redirección de compatibilidad para enlaces antiguos de login empresa
    public function createEmpresa()
    {
        return redirect()->route('login');
    }

    public function loginEmpresa(Request $request)
    {
        return $this->store($request);
    }

    // Logout
    public function destroy(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}