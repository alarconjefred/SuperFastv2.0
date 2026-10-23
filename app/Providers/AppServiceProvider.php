<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Forzar HTTPS en entorno de producción
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Limitador de solicitudes específico para el chatbot de IA:
        // 10 consultas por minuto por ID de usuario autenticado o por direccin IP si es invitado
        RateLimiter::for('chatbot', function (Request $request) {
            $identifier = $request->user()?->id ?: $request->ip();
            return Limit::perMinute(10)->by($identifier)->response(function () {
                return response()->json([
                    'error' => 'Has alcanzado el lmite de 10 mensajes por minuto. Por favor espera un momento antes de continuar.'
                ], 429);
            });
        });
    }
}
