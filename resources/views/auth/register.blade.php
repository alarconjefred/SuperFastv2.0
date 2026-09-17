@extends('layouts.app')

@section('title', 'Register')

@section('content')

    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow" style="width: 350px; border-radius: 15px;">

            <div class="text-start mb-3">
                <a href="{{ route('inicio') }}" class="btn btn-sm btn-outline-secondary">
                    ← Inicio
                </a>
            </div>

            <h3 class="text-center mb-3">Crear Cuenta</h3>

            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('register.store') }}" method="POST">
                @csrf

                <input type="text" name="name" value="{{ old('name') }}" class="form-control mb-2"
                    placeholder="Nombre" required>

                <input type="email" name="email" value="{{ old('email') }}" class="form-control mb-2"
                    placeholder="Email" required>

                <input type="password" name="password" class="form-control mb-2" placeholder="Contraseña" required>

                <input type="password" name="password_confirmation" class="form-control mb-3"
                    placeholder="Confirmar contraseña" required>

                <button type="submit" class="btn btn-primary w-100">
                    Registrarse
                </button>
            </form>

            <div class="text-center mt-3">
                <small>
                    ¿Ya tienes cuenta?
                    <a href="{{ route('login') }}">Iniciar sesión</a>
                </small>
            </div>
        </div>
    </div>

@endsection

</html>
