<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirige al proveedor de Google OAuth
     */
    public function redirect(Request $request)
    {
        // Si el usuario ya está autenticado, redirigir a su panel según rol
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        // Verificar si las credenciales de Google OAuth están configuradas
        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');

        if (empty($clientId) || empty($clientSecret)) {
            return redirect()->route('login')->with(
                'error',
                'El inicio de sesión con Google aún no está configurado en el servidor. Por favor, ingresa con tu correo y contraseña.'
            );
        }

        // Guardar en sesión el rol deseado (por defecto cliente, o empresa si se solicitó)
        $role = $request->query('role', 'cliente');
        if (!in_array($role, ['cliente', 'empresa'])) {
            $role = 'cliente';
        }
        session(['google_auth_role' => $role]);

        return Socialite::driver('google')->redirect();
    }

    /**
     * Procesa la respuesta de callback de Google OAuth
     */
    public function callback(Request $request)
    {
        // Si ya está autenticado
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        // 1. Manejar si el usuario canceló la autorización en Google
        if ($request->has('error') || $request->query('error') === 'access_denied') {
            return redirect()->route('login')->with(
                'info',
                'Has cancelado el inicio de sesión con Google.'
            );
        }

        // 2. Verificar configuración
        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');

        if (empty($clientId) || empty($clientSecret)) {
            return redirect()->route('login')->with(
                'error',
                'El servicio de autenticación con Google no está disponible actualmente.'
            );
        }

        // 3. Obtener el usuario de Google de forma segura
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Throwable $e) {
            Log::error('Error en Google OAuth Callback: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('login')->with(
                'error',
                'No se pudo autenticar con Google. Por favor, intenta nuevamente o ingresa con tu contraseña.'
            );
        }

        // Validar información recibida
        $googleEmail = $googleUser->getEmail();
        $googleId = $googleUser->getId();

        if (empty($googleEmail) || empty($googleId)) {
            return redirect()->route('login')->with(
                'error',
                'No se pudo obtener un correo electrónico verificado desde tu cuenta de Google.'
            );
        }

        // 4. Buscar usuario existente por google_id o por correo electrónico
        $user = User::where('google_id', $googleId)->first();

        if (!$user) {
            $user = User::where('email', $googleEmail)->first();

            if ($user) {
                // Usuario existente: asociar google_id sin alterar rol ni contraseña existente
                $user->google_id = $googleId;
                if (!$user->email_verified_at) {
                    $user->email_verified_at = now();
                }
                $user->save();
            }
        }

        // 5. Si es un usuario nuevo, crearlo respetando el flujo y rol solicitado
        if (!$user) {
            $desiredRole = session()->pull('google_auth_role', 'cliente');
            if (!in_array($desiredRole, ['cliente', 'empresa'])) {
                $desiredRole = 'cliente';
            }

            $name = $googleUser->getName() ?: ($desiredRole === 'empresa' ? 'Comercio Aliado' : 'Usuario SuperFast');

            $user = User::create([
                'name' => $name,
                'email' => $googleEmail,
                'email_verified_at' => now(),
                'google_id' => $googleId,
                'password' => Hash::make(Str::random(32)),
                'role' => $desiredRole,
            ]);

            // Si se registró como empresa, crear automáticamente el registro asociado
            if ($desiredRole === 'empresa') {
                Empresa::create([
                    'nombre' => $name,
                    'user_id' => $user->id,
                ]);
            }
        } else {
            session()->forget('google_auth_role');
        }

        // 6. Iniciar sesión y regenerar sesión contra session fixation
        Auth::login($user, remember: true);
        $request->session()->regenerate();

        return $this->redirectBasedOnRole($user);
    }

    /**
     * Redirige al destino apropiado según el rol del usuario
     */
    protected function redirectBasedOnRole(User $user)
    {
        if ($user->role === 'empresa') {
            return redirect()->intended(route('empresa.index'))
                ->with('success', '¡Bienvenido(a) a tu panel de comercio, ' . ($user->name ?? 'Aliado') . '!');
        }

        return redirect()->intended(route('dashboard'))
            ->with('success', '¡Bienvenido(a) a SuperFast, ' . ($user->name ?? '') . '!');
    }
}
