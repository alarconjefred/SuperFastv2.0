<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsEmpresa
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'empresa') {
            return $next($request);
        }

        abort(403, 'Acceso no autorizado'); // o redirige a login
    }
}