@extends('layouts.publico')

@section('title', 'Registrar Empresa - SuperFast')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center min-vh-75 my-3">
        <div class="col-12 col-md-8 col-lg-5">

            <div class="card border-0 shadow-lg rounded-4 position-relative overflow-hidden" 
                 style="background-color: #FFFFFF; border: 1px solid #E2E8F0; box-shadow: 0 10px 30px rgba(23, 37, 84, 0.08);">
                
                <!-- Acento superior decorativo -->
                <div style="height: 5px; background: linear-gradient(90deg, #172554, #FFB703, #FF6B35);"></div>

                <div class="card-body p-4 p-sm-5">

                    <!-- Cabecera -->
                    <div class="text-center mb-4">
                        <div class="d-inline-block p-2 rounded-3 bg-light border border-light shadow-sm mb-3">
                            <img src="{{ asset('img/Iconos/Version compacta.jpg') }}" alt="SuperFast" style="height: 48px; width: 48px; object-fit: contain;" class="rounded-2">
                        </div>
                        <h2 class="fw-bold mb-1" style="color: #172554;">Registrar Empresa</h2>
                        <p class="text-muted small mb-0">Comienza a vender tus productos en SuperFast</p>
                    </div>

                    <form method="POST" action="{{ route('register.empresa.store') }}">
                        @csrf

                        <!-- Nombre de la Empresa -->
                        <div class="mb-3">
                            <label for="name" class="form-label small fw-semibold" style="color: #1F2937;">Nombre de la Empresa o Restaurante</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0 bg-light text-muted" style="border-color: #E2E8F0;">
                                    <i class="bi bi-building"></i>
                                </span>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       class="form-control border-start-0 @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" 
                                       placeholder="Ej: Pizza Napoli" 
                                       required 
                                       autofocus>
                            </div>
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Correo Electrónico Comercial -->
                        <div class="mb-3">
                            <label for="email" class="form-label small fw-semibold" style="color: #1F2937;">Correo Electrónico Comercial</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0 bg-light text-muted" style="border-color: #E2E8F0;">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       class="form-control border-start-0 @error('email') is-invalid @enderror" 
                                       value="{{ old('email') }}" 
                                       placeholder="contacto@restaurante.com" 
                                       required>
                            </div>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
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
                                       class="form-control border-start-0 @error('password') is-invalid @enderror" 
                                       placeholder="Mínimo 6 caracteres" 
                                       required>
                            </div>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
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
                            <span>Registrar mi Empresa</span>
                            <i class="bi bi-check-circle-fill"></i>
                        </button>

                        <div class="text-center mt-4 pt-2 border-top border-light">
                            <small class="text-muted">
                                ¿Ya tienes una cuenta registrada? 
                                <a href="{{ route('login') }}" class="fw-bold" style="color: #FF6B35;">Inicia sesión aquí</a>
                            </small>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
