@extends('layouts.publico')

@section('title', 'Iniciar Sesión - SuperFast')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center min-vh-75 my-4">
        <div class="col-12 col-md-8 col-lg-5">

            <!-- Card Principal de Login -->
            <div class="card border-0 shadow-lg rounded-4 position-relative overflow-hidden" 
                 style="background-color: #FFFFFF; border: 1px solid #E2E8F0; box-shadow: 0 10px 30px rgba(23, 37, 84, 0.08);">
                
                <!-- Acento superior decorativo -->
                <div style="height: 5px; background: linear-gradient(90deg, #FF6B35, #FFB703, #FF6B35);"></div>

                <div class="card-body p-4 p-sm-5">

                    <!-- Cabecera con Logo y Título -->
                    <div class="text-center mb-4">
                        <div class="d-inline-block p-2 rounded-3 bg-light border border-light shadow-sm mb-3">
                            <img src="{{ asset('img/Iconos/Version compacta.jpg') }}" alt="SuperFast" style="height: 52px; width: 52px; object-fit: contain;" class="rounded-2">
                        </div>
                        <h2 class="fw-bold mb-1" style="color: #172554;">Iniciar Sesión</h2>
                        <p class="text-muted small mb-0">Acceso unificado para clientes y empresas colaboradoras</p>
                    </div>

                    <!-- Mensaje informativo de rol unificado -->
                    <div class="alert border-0 rounded-3 d-flex align-items-center gap-2 mb-4 py-2 px-3" 
                         style="background-color: #FFF0EB; border-left: 3.5px solid #FF6B35 !important; color: #172554;">
                        <i class="bi bi-shield-check fs-5 flex-shrink-0" style="color: #FF6B35;"></i>
                        <span style="font-size: 0.85rem;">
                            Detectaremos automáticamente si eres <strong>Cliente</strong> o <strong>Empresa</strong> para llevarte a tu panel correspondiente.
                        </span>
                    </div>

                    <!-- Alertas de éxito (ej. tras registrarse) -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 d-flex align-items-center gap-2 py-2 px-3 mb-4" role="alert" style="background-color: #ECFDF5; color: #065F46;">
                            <i class="bi bi-check-circle-fill fs-5" style="color: #10B981;"></i>
                            <span class="small">{{ session('success') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Alertas de error de credenciales -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 d-flex align-items-center gap-2 py-2 px-3 mb-4" role="alert" style="background-color: #FEF2F2; color: #991B1B;">
                            <i class="bi bi-exclamation-triangle-fill fs-5 flex-shrink-0" style="color: #EF4444;"></i>
                            <span class="small">{{ $errors->first() }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Formulario de Login -->
                    <form action="{{ route('login.store') }}" method="POST" novalidate>
                        @csrf

                        <!-- Correo Electrónico -->
                        <div class="mb-3">
                            <label for="email" class="form-label small fw-semibold" style="color: #1F2937;">Correo Electrónico</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0 bg-light text-muted" style="border-color: #E2E8F0;">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       value="{{ old('email') }}" 
                                       class="form-control border-start-0 @error('email') is-invalid @enderror" 
                                       placeholder="tu@correo.com" 
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
                                <label for="password" class="form-label small fw-semibold mb-0" style="color: #1F2937;">Contraseña</label>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text border-end-0 bg-light text-muted" style="border-color: #E2E8F0;">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror" 
                                       placeholder="••••••••" 
                                       required>
                                <button class="btn btn-light border border-start-0 text-muted px-3" 
                                        type="button" 
                                        id="togglePassword" 
                                        style="border-color: #E2E8F0;"
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
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} style="border-color: #CBD5E1;">
                                <label class="form-check-label text-muted small" for="remember">
                                    Recordar mi sesión
                                </label>
                            </div>
                        </div>

                        <!-- Botón Submit -->
                        <button type="submit" 
                                class="btn btn-sf-primary w-100 py-2 fw-bold rounded-3 shadow d-flex align-items-center justify-content-center gap-2">
                            <span>Ingresar a SuperFast</span>
                            <i class="bi bi-arrow-right-circle-fill fs-5"></i>
                        </button>
                    </form>

                    <!-- Separador -->
                    <div class="d-flex align-items-center my-4">
                        <hr class="flex-grow-1 border-secondary opacity-25">
                        <span class="px-3 text-muted small text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.05em;">¿Nuevo en SuperFast?</span>
                        <hr class="flex-grow-1 border-secondary opacity-25">
                    </div>

                    <!-- Accesos de Registro por Rol -->
                    <div class="d-grid gap-2">
                        <a href="{{ route('register') }}" 
                           class="btn btn-outline-secondary rounded-3 py-2 text-start d-flex align-items-center justify-content-between px-3"
                           style="border-color: #E2E8F0; background-color: #F8FAFC;"
                           onmouseover="this.style.backgroundColor='#FFF0EB'; this.style.borderColor='#FF6B35'" 
                           onmouseout="this.style.backgroundColor='#F8FAFC'; this.style.borderColor='#E2E8F0'">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-person text-danger fs-5" style="color: #FF6B35 !important;"></i>
                                <span class="small fw-semibold text-dark">Crear cuenta como <strong>Cliente</strong></span>
                            </div>
                            <i class="bi bi-chevron-right text-muted small"></i>
                        </a>

                        <a href="{{ route('register.empresa') }}" 
                           class="btn btn-outline-secondary rounded-3 py-2 text-start d-flex align-items-center justify-content-between px-3"
                           style="border-color: #E2E8F0; background-color: #F8FAFC;"
                           onmouseover="this.style.backgroundColor='#FFF0EB'; this.style.borderColor='#FF6B35'" 
                           onmouseout="this.style.backgroundColor='#F8FAFC'; this.style.borderColor='#E2E8F0'">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-shop fs-5" style="color: #172554 !important;"></i>
                                <span class="small fw-semibold text-dark">Registrar mi <strong>Empresa / Restaurante</strong></span>
                            </div>
                            <i class="bi bi-chevron-right text-muted small"></i>
                        </a>
                    </div>

                    <!-- Enlace de regreso al Inicio -->
                    <div class="text-center mt-4 pt-2">
                        <a href="{{ route('inicio') }}" class="text-muted text-decoration-none small d-inline-flex align-items-center gap-1"
                           onmouseover="this.style.color='#FF6B35'" onmouseout="this.style.color='#64748B'">
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
