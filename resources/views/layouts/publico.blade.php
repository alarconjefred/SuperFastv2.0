<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SuperFast - Domicilios y Negocios Locales')</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('img/Iconos/Version compacta.jpg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body style="background-color: var(--sf-background, #F5F7FA); color: var(--sf-text, #1F2937); min-height: 100vh; display: flex; flex-direction: column;">

    <!-- NAVBAR INSTITUCIONAL DIRECTAMENTE VISIBLE Y RESPONSIVO -->
    <nav class="navbar py-2 shadow-sm sf-navbar position-sticky top-0 z-3" style="background-color: #172554; border-bottom: 2.5px solid #FF6B35;">
        <div class="container-fluid px-3 px-md-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <!-- Brand / Logo -->
            <a class="navbar-brand d-flex align-items-center gap-2 text-white fw-bold fs-4 text-decoration-none m-0" href="{{ route('inicio') }}">
                <img src="{{ asset('img/Iconos/Version compacta.jpg') }}" alt="SuperFast" 
                     style="height: 38px !important; width: 38px !important; object-fit: contain;" 
                     class="rounded-2 shadow-sm">
                <span>Super<span style="color: #FF6B35;">Fast</span></span>
            </a>

            <!-- Botones de Navegación Directamente Visibles -->
            <div class="d-flex align-items-center gap-2 flex-wrap ms-auto">
                @guest
                    <!-- Iniciar Sesión -->
                    <a href="{{ route('login') }}" class="btn btn-sf-primary btn-sm px-3 shadow-sm d-flex align-items-center gap-1">
                        <i class="bi bi-box-arrow-in-right"></i>
                        <span>Iniciar Sesión</span>
                    </a>

                    <!-- Crear Cuenta (estilo accent de Registrar Empresa) -->
                    <a href="{{ route('register') }}" class="btn btn-sf-accent btn-sm px-3 fw-bold shadow-sm d-flex align-items-center gap-1">
                        <i class="bi bi-person-plus-fill"></i>
                        <span>Crear Cuenta</span>
                    </a>
                @else
                    <!-- Usuario autenticado -->
                    @if(auth()->user()->role === 'empresa')
                        <a href="{{ route('empresa.index') }}" class="btn btn-outline-light btn-sm fw-semibold d-flex align-items-center gap-1">
                            <i class="bi bi-shop" style="color: #FFB703;"></i>
                            <span>Panel Empresa</span>
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm fw-semibold d-flex align-items-center gap-1">
                            <i class="bi bi-person-circle" style="color: #FF6B35;"></i>
                            <span>Mi Cuenta</span>
                        </a>

                        @php
                            $publicCartCount = array_sum(array_column(session('cart', []), 'cantidad'));
                        @endphp
                        <a href="{{ route('carrito.index') }}" class="btn btn-outline-light btn-sm position-relative d-inline-flex align-items-center gap-1">
                            <i class="bi bi-cart3" style="color: #FFB703;"></i>
                            <span>Carrito</span>
                            @if($publicCartCount > 0)
                                <span class="badge rounded-pill bg-danger" style="font-size: 0.7rem;">{{ $publicCartCount }}</span>
                            @endif
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="d-inline m-0">
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-sm px-3" style="background-color: rgba(255,255,255,0.15); border: none;">
                            <i class="bi bi-power me-1"></i> Salir
                        </button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="flex-grow-1">
        @yield('content')
    </main>

    <!-- FOOTER INSTITUCIONAL -->
    <footer class="sf-footer text-white py-4 mt-5" style="background-color: #0F172A; border-top: 3px solid #FF6B35;">
        <div class="container text-center">
            <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                <img src="{{ asset('img/Iconos/Version compacta.jpg') }}" alt="SuperFast" style="height: 28px; width: 28px; object-fit: contain;" class="rounded-1">
                <span class="fw-bold fs-5">Super<span style="color: #FF6B35;">Fast</span></span>
            </div>
            <p class="text-white-50 small mb-2">Conectando clientes con los mejores comercios y restaurantes locales.</p>
            <p class="mb-0 text-white-50 small">&copy; {{ date('Y') }} SuperFast • Rapidez, Confianza y Calidad</p>
        </div>
    </footer>

    {{-- Chatbot Asistente Virtual SuperFast (Vercel) --}}
    <x-chatbot-widget />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
