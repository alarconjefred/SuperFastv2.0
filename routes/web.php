<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

// Inicio
Route::get('/', function () {
    return view('inicio');
})->name('inicio');

// Dashboard del cliente (redirige a empresa si tiene ese rol)
Route::get('/dashboard', function(){
    if (auth()->user()->role === 'empresa') {
        return redirect()->route('empresa.index');
    }
    return view('cliente');
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

// Registro y login empresas
Route::get('/register-empresa', [RegisterController::class,'createEmpresa'])->name('register.empresa');
Route::post('/register-empresa', [EmpresaController::class, 'store'])->name('register.empresa.store');

Route::get('/login-empresa', [LoginController::class,'createEmpresa'])->name('login.empresa');
Route::post('/login-empresa', [LoginController::class, 'loginEmpresa'])->name('login.empresa.store');