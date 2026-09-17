@extends('layouts.publico')

@section('title', 'Crear Cuenta - SuperFast')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center align-items-center min-vh-75 my-3">
        <div class="col-12 col-md-8 col-lg-5">

            <div class="card border-0 shadow-lg rounded-4 position-relative overflow-hidden" 
                 style="background-color: #FFFFFF; border: 1px solid #E2E8F0; box-shadow: 0 10px 30px rgba(23, 37, 84, 0.08);">
                
                <!-- Acento superior decorativo -->
                <div style="height: 5px; background: linear-gradient(90deg, #FF6B35, #FFB703, #FF6B35);"></div>

                <div class="card-body p-4 p-sm-5">

                    <!-- Cabecera -->
                    <div class="text-center mb-4">
                        <div class="d-inline-block p-2 rounded-3 bg-light border border-light shadow-sm mb-3">
                            <img src="{{ asset('img/Iconos/Version compacta.jpg') }}" alt="SuperFast" style="height: 48px; width: 48px; object-fit: contain;" class="rounded-2">
                        </div>
                        <h2 class="fw-bold mb-1" style="color: #172554;">Crear Cuenta</h2>
                        <p class="text-muted small mb-0">Regístrate para pedir tu comida favorita en minutos</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 py-2 px-3 mb-4" role="alert" style="background-color: #FEF2F2; color: #991B1B;">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-exclamation-triangle-fill flex-shrink-0" style="color: #EF4444;"></i>
                                <span class="small">{{ $errors->first() }}</span>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('register.store') }}" method="POST">
                        @csrf

                        <!-- Nombre Completo -->
                        <div class="mb-3">
                            <label for="name" class="form-label small fw-semibold" style="color: #1F2937;">Nombre Completo</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0 bg-light text-muted" style="border-color: #E2E8F0;">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       value="{{ old('name') }}" 
                                       class="form-control border-start-0" 
                                       placeholder="Tu nombre y apellido" 
                                       required 
                                       autofocus>
                            </div>
                        </div>

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
                                       class="form-control border-start-0" 
                                       placeholder="tu@correo.com" 
                                       required>
                            </div>
                        </div>

                        <!-- Contraseña -->
                        <div class="mb-3">
                            <label for="password" class="form-label small fw-semibold" style="color: #1F2937;">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0 bg-light text-muted" style="border-color: #E2E8F0;">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       class="form-control border-start-0" 
                                       placeholder="Mínimo 8 caracteres" 
                                       required>
                            </div>
                        </div>

                        <!-- Confirmar Contraseña -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label small fw-semibold" style="color: #1F2937;">Confirmar Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0 bg-light text-muted" style="border-color: #E2E8F0;">
                                    <i class="bi bi-shield-lock"></i>
                                </span>
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="password_confirmation" 
                                       class="form-control border-start-0" 
                                       placeholder="Repite tu contraseña" 
                                       required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-sf-primary w-100 py-2 fw-bold rounded-3 shadow d-flex align-items-center justify-content-center gap-2">
                            <span>Crear mi cuenta</span>
                            <i class="bi bi-arrow-right-circle-fill"></i>
                        </button>
                    </form>

                    <div class="text-center mt-4 pt-2 border-top border-light">
                        <small class="text-muted">
                            ¿Ya tienes una cuenta? 
                            <a href="{{ route('login') }}" class="fw-bold" style="color: #FF6B35;">Inicia sesión</a>
                        </small>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection
