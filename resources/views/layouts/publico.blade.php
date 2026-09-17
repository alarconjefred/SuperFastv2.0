<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>

<body style="background-color: #0f172a; color: #f1f5f9;">

    <nav class="navbar py-2 shadow-sm" style="background-color: #ad5757;">
        <div class="container-fluid px-4 d-flex justify-content-between align-items-center">
            <!-- Brand / Logo -->
            <a class="navbar-brand d-flex align-items-center gap-2 text-white fw-bold fs-4 text-decoration-none" href="{{ route('inicio') }}">
                <img src="{{ asset('img/LogoSF2.png') }}" alt="SuperFast" 
                     style="height: 38px !important; width: 38px !important; max-height: 38px !important; max-width: 38px !important; object-fit: contain; display: inline-block;" 
                     class="rounded">
                <span>Super<span class="text-warning">Fast</span></span>
            </a>

            <!-- Botones visibles siempre -->
            <div class="d-flex align-items-center gap-2">
                @guest
                    <!-- ÚNICO APARTADO DE INICIAR SESIÓN -->
                    <a href="{{ route('login') }}" class="btn btn-warning fw-bold btn-sm px-3 shadow-sm d-flex align-items-center gap-1 text-dark">
                        <i class="bi bi-box-arrow-in-right"></i>
                        <span>Iniciar Sesión</span>
                    </a>

                    <!-- Botones de registro -->
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm px-3">
                        Crear Cuenta
                    </a>
                    <a href="{{ route('register.empresa') }}" class="btn btn-outline-warning btn-sm px-3">
                        Registrar Empresa
                    </a>
                @else
                    <!-- Usuario autenticado -->
                    @if(auth()->user()->role === 'empresa')
                        <a href="{{ route('empresa.index') }}" class="btn btn-light btn-sm fw-semibold d-flex align-items-center gap-1">
                            <i class="bi bi-speedometer2 text-danger"></i>
                            <span>Panel Empresa</span>
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm fw-semibold d-flex align-items-center gap-1">
                            <i class="bi bi-person-circle text-danger"></i>
                            <span>Mi Cuenta</span>
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-dark btn-sm px-3">
                            Salir
                        </button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    @yield('content')

    <footer style="background-color: #5a0202;" class="text-center text-white py-4 mt-5">
        <p class="mb-0">© Desarrollo de Software Seguro</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
