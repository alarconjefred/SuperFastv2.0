@extends('layouts.publico')

@section('content')
    <div class="container mt-5" style="max-width:400px;">
        <h1 class="text-center mb-4">Registro Empresa</h1>
        <form method="POST" action="{{ route('register.empresa.store') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nombre de la empresa</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}"
                    required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" id="password" class="form-control" required>
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                    required>
            </div>

            <button class="btn btn-primary w-100">Registrar Empresa</button>

            <div class="mt-3 text-center">
                ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-primary fw-semibold">Inicia sesión aquí</a>
            </div>
        </form>
    </div>
@endsection
