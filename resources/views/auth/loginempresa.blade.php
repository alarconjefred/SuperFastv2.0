@extends('layouts.publico')

@section('content')
<script>window.location.href = "{{ route('login') }}";</script>
<div class="container text-center py-5">
    <div class="spinner-border text-warning mb-3" role="status">
        <span class="visually-hidden">Cargando...</span>
    </div>
    <p class="text-secondary">Redirigiendo al inicio de sesión unificado...</p>
    <a href="{{ route('login') }}" class="btn btn-warning fw-semibold">Ir al inicio de sesión</a>
</div>
@endsection
