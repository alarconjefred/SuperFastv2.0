<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Models\Producto;

// Inicio
Route::get('/', function () {
    return view('inicio');
})->name('inicio');

// Dashboard del cliente (redirige a empresa si tiene ese rol)
Route::get('/dashboard', function(Request $request){
    if (auth()->user()->role === 'empresa') {
        return redirect()->route('empresa.index');
    }
    
    $query = Producto::with('empresa');

    if ($request->filled('q')) {
        $search = $request->input('q');
        $query->where(function($q) use ($search) {
            $q->where('nombre', 'like', "%{$search}%")
              ->orWhere('descripcion', 'like', "%{$search}%")
              ->orWhereHas('empresa', function($sq) use ($search) {
                  $sq->where('nombre', 'like', "%{$search}%");
              });
        });
    }

    $productos = $query->latest()->get();
    return view('cliente', compact('productos'));
})->middleware('auth')->name('dashboard');

// Registro y login clientes
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:5,1')->name('login.store');
Route::post('logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

// Panel empresa
Route::get('/empresa', [EmpresaController::class, 'index'])
    ->middleware(['auth', 'isEmpresa'])
    ->name('empresa.index');

// Productos (CRUD) – rutas anidadas para una empresa
Route::prefix('empresa/{empresa}')->group(function() {
    Route::resource('productos', ProductoController::class);
});

// Carrito de compras (Clientes autenticados)
Route::middleware('auth')->group(function () {
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
    Route::post('/carrito/agregar/{producto}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::post('/carrito/incrementar/{producto}', [CarritoController::class, 'incrementar'])->name('carrito.incrementar');
    Route::post('/carrito/decrementar/{producto}', [CarritoController::class, 'decrementar'])->name('carrito.decrementar');
    Route::delete('/carrito/eliminar/{producto}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
    Route::post('/carrito/vaciar', [CarritoController::class, 'vaciar'])->name('carrito.vaciar');
});

// Registro y login empresas
Route::get('/register-empresa', [RegisterController::class,'createEmpresa'])->name('register.empresa');
Route::post('/register-empresa', [EmpresaController::class, 'store'])->name('register.empresa.store');

Route::get('/login-empresa', [LoginController::class,'createEmpresa'])->name('login.empresa');
Route::post('/login-empresa', [LoginController::class, 'loginEmpresa'])->name('login.empresa.store');