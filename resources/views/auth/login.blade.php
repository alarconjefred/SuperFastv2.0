@extends('layouts.publico')

@section('title', 'Iniciar Sesión - SuperFast')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center min-vh-75 my-4">
        <div class="col-12 col-md-8 col-lg-5">

            <!-- Card Principal de Login -->
            <div class="card border-0 shadow-2xl rounded-4 text-white position-relative overflow-hidden" 
                 style="background: linear-gradient(145deg, #1e293b, #0f172a); border: 1px solid rgba(255, 255, 255, 0.08); box-shadow: 0 20px 45px rgba(0, 0, 0, 0.5);">
                
                <!-- Acento superior decorativo -->
                <div style="height: 5px; background: linear-gradient(90deg, #f59e0b, #ef4444, #f59e0b);"></div>

                <div class="card-body p-4 p-sm-5">

                    <!-- Cabecera con Logo y Título -->
                    <div class="text-center mb-4">
                        <div class="d-inline-block p-2 rounded-circle bg-dark bg-opacity-50 border border-secondary border-opacity-25 shadow-sm mb-3">
                            <img src="{{ asset('img/LogoSF2.png') }}" alt="SuperFast" style="height: 55px; width: 55px; object-fit: contain;">
                        </div>
                        <h2 class="fw-bold mb-1 tracking-wide">Iniciar Sesión</h2>
                        <p class="text-secondary small mb-0">Acceso unificado para clientes y empresas</p>
                    </div>

                    <!-- Mensaje informativo de rol unificado -->
                    <div class="alert border-0 rounded-3 d-flex align-items-center gap-2 mb-4 py-2 px-3" 
                         style="background-color: rgba(245, 158, 11, 0.12); border-left: 3px solid #f59e0b !important; color: #fbbf24;">
                        <i class="bi bi-shield-check fs-5 flex-shrink-0"></i>
                        <span style="font-size: 0.85rem;">
                            Detectaremos automáticamente si eres <strong>Cliente</strong> o <strong>Empresa</strong> para llevarte a tu panel.
                        </span>
                    </div>

                    <!-- Alertas de éxito (ej. tras registrarse) -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 d-flex align-items-center gap-2 py-2 px-3 mb-4" role="alert">
                            <i class="bi bi-check-circle-fill fs-5"></i>
                            <span class="small">{{ session('success') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Alertas de error de credenciales -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 d-flex align-items-center gap-2 py-2 px-3 mb-4" role="alert">
                            <i class="bi bi-exclamation-triangle-fill fs-5 flex-shrink-0"></i>
                            <span class="small">{{ $errors->first() }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Formulario de Login -->
                    <form action="{{ route('login.store') }}" method="POST" novalidate>
                        @csrf

                        <!-- Correo Electrónico -->
                        <div class="mb-3">
                            <label for="email" class="form-label text-light small fw-semibold">Correo Electrónico</label>
                            <div class="input-group">
                                <span class="input-group-text border-0 text-secondary" style="background-color: #334155;">
                                    <i class="bi bi-envelope-fill"></i>
                                </span>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       value="{{ old('email') }}" 
                                       class="form-control border-0 text-white @error('email') is-invalid @enderror" 
                                       placeholder="tu@correo.com" 
                                       style="background-color: #334155; padding: 0.7rem 0.9rem;"
                                       required 
                                       autofocus>
                            </div>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contraseña -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="password" class="form-label text-light small fw-semibold mb-0">Contraseña</label>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text border-0 text-secondary" style="background-color: #334155;">
                                    <i class="bi bi-lock-fill"></i>
                                </span>
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       class="form-control border-0 text-white @error('password') is-invalid @enderror" 
                                       placeholder="••••••••" 
                                       style="background-color: #334155; padding: 0.7rem 0.9rem;"
                                       required>
                                <button class="btn border-0 text-secondary px-3" 
                                        type="button" 
                                        id="togglePassword" 
                                        style="background-color: #334155;"
                                        title="Mostrar/Ocultar contraseña">
                                    <i class="bi bi-eye-slash" id="togglePasswordIcon"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Recordar Sesión -->
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="form-check">
                                <input class="form-check-input bg-secondary border-0" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label text-secondary small" for="remember">
                                    Recordar mi sesión
                                </label>
                            </div>
                        </div>

                        <!-- Botón Submit -->
                        <button type="submit" 
                                class="btn btn-warning w-100 py-2 fw-bold text-dark rounded-3 shadow-lg d-flex align-items-center justify-content-center gap-2"
                                style="transition: all 0.2s ease;">
                            <span>Ingresar a SuperFast</span>
                            <i class="bi bi-arrow-right-circle-fill fs-5"></i>
                        </button>
                    </form>

                    <!-- Separador -->
                    <div class="d-flex align-items-center my-4">
                        <hr class="flex-grow-1 border-secondary opacity-25">
                        <span class="px-3 text-secondary small text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.05em;">¿Nuevo en SuperFast?</span>
                        <hr class="flex-grow-1 border-secondary opacity-25">
                    </div>

                    <!-- Accesos de Registro por Rol -->
                    <div class="d-grid gap-2">
                        <a href="{{ route('register') }}" 
                           class="btn btn-outline-light rounded-3 py-2 text-start d-flex align-items-center justify-content-between px-3 border-opacity-25"
                           onmouseover="this.style.backgroundColor='rgba(255,255,255,0.06)'" 
                           onmouseout="this.style.backgroundColor='transparent'">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-person text-warning fs-5"></i>
                                <span class="small fw-semibold">Crear cuenta como <strong>Cliente</strong></span>
                            </div>
                            <i class="bi bi-chevron-right text-secondary small"></i>
                        </a>

                        <a href="{{ route('register.empresa') }}" 
                           class="btn btn-outline-light rounded-3 py-2 text-start d-flex align-items-center justify-content-between px-3 border-opacity-25"
                           onmouseover="this.style.backgroundColor='rgba(255,255,255,0.06)'" 
                           onmouseout="this.style.backgroundColor='transparent'">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-shop text-warning fs-5"></i>
                                <span class="small fw-semibold">Registrar mi <strong>Empresa / Restaurante</strong></span>
                            </div>
                            <i class="bi bi-chevron-right text-secondary small"></i>
                        </a>
                    </div>

                    <!-- Enlace de regreso al Inicio -->
                    <div class="text-center mt-4 pt-2">
                        <a href="{{ route('inicio') }}" class="text-secondary text-decoration-none small d-inline-flex align-items-center gap-1 hover-warning"
                           onmouseover="this.classList.add('text-white')" onmouseout="this.classList.remove('text-white')">
                            <i class="bi bi-arrow-left"></i> Volver a la página principal
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('togglePasswordIcon');

        if (togglePassword && passwordInput && toggleIcon) {
            togglePassword.addEventListener('click', function() {
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                toggleIcon.classList.toggle('bi-eye-slash', !isPassword);
                toggleIcon.classList.toggle('bi-eye', isPassword);
            });
        }
    });
</script>
@endsection
