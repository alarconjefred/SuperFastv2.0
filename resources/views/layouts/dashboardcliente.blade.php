<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel - SuperFast')</title>

    <link rel="icon" type="image/jpeg" href="{{ asset('img/Iconos/Version compacta.jpg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body style="background-color: var(--sf-background, #F5F7FA); color: var(--sf-text, #1F2937); min-height: 100vh;">

    @php
        $cartCount = array_sum(array_column(session('cart', []), 'cantidad'));
    @endphp

    <div class="d-flex">

        {{-- SIDEBAR DESKTOP INSTITUCIONAL (Pantallas grandes >= 992px) --}}
        <aside style="width: 260px; background-color: #172554; min-height: 100vh; border-right: 1px solid rgba(255,255,255,0.08);" class="d-none d-lg-flex text-white p-3 flex-column justify-content-between position-sticky top-0 h-100 shrink-0">
            <div>
                <!-- Brand / Logo -->
                <div class="mb-4 pb-3 border-bottom border-white border-opacity-10 d-flex align-items-center gap-2">
                    <img src="{{ asset('img/Iconos/Version compacta.jpg') }}" alt="SuperFast" style="height: 34px; width: 34px; object-fit: contain;" class="rounded-2 shadow-sm">
                    <a href="{{ route('inicio') }}" class="text-white fw-bold fs-5 text-decoration-none">
                        Super<span style="color: #FF6B35;">Fast</span>
                    </a>
                </div>

                <!-- Menú de Navegación -->
                <ul class="nav flex-column gap-1">
                    <li class="nav-item">
                        <a href="{{ route('inicio') }}" class="nav-link text-white-50 rounded px-3 py-2 d-flex align-items-center gap-2" onmouseover="this.style.backgroundColor='rgba(255,255,255,0.08)'; this.style.color='#FFFFFF'" onmouseout="this.style.backgroundColor='transparent'; this.style.color='rgba(255,255,255,0.5)'">
                            <i class="bi bi-house fs-5 text-warning"></i>
                            <span class="fw-medium">Inicio Web</span>
                        </a>
                    </li>

                    @if(auth()->check() && auth()->user()->role === 'empresa')
                        <li class="nav-item">
                            <a href="{{ route('empresa.index') }}" class="nav-link {{ request()->routeIs('empresa.*') ? 'text-white' : 'text-white-50' }} rounded px-3 py-2 d-flex align-items-center gap-2" style="{{ request()->routeIs('empresa.*') ? 'background-color: rgba(255, 107, 53, 0.2); border-left: 3px solid #FF6B35;' : '' }}">
                                <i class="bi bi-shop fs-5" style="color: #FF6B35;"></i>
                                <span class="fw-bold">Mi Empresa</span>
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'text-white' : 'text-white-50' }} rounded px-3 py-2 d-flex align-items-center gap-2" style="{{ request()->routeIs('dashboard') ? 'background-color: rgba(255, 107, 53, 0.2); border-left: 3px solid #FF6B35;' : '' }}">
                                <i class="bi bi-grid-fill fs-5" style="color: #FF6B35;"></i>
                                <span class="fw-bold">Catálogo</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('carrito.index') }}" class="nav-link {{ request()->routeIs('carrito.*') ? 'text-white' : 'text-white-50' }} rounded px-3 py-2 d-flex align-items-center justify-content-between" style="{{ request()->routeIs('carrito.*') ? 'background-color: rgba(255, 107, 53, 0.2); border-left: 3px solid #FF6B35;' : '' }}">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-cart3 fs-5" style="color: #FFB703;"></i>
                                    <span class="fw-medium">Mi Carrito</span>
                                </div>
                                @if($cartCount > 0)
                                    <span class="badge rounded-pill" style="background-color: #FF6B35; font-size: 0.72rem; font-weight: 700;">{{ $cartCount }}</span>
                                @endif
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            <!-- Footer Sidebar con Cerrar Sesión -->
            <div class="pt-3 border-top border-white border-opacity-10">
                <div class="d-flex align-items-center gap-2 mb-3 px-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-sm shrink-0" style="width: 38px; height: 38px; background-color: #FF6B35;">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="overflow-hidden">
                        <div class="fw-semibold text-white text-truncate" style="font-size: 0.9rem;">{{ auth()->user()->name ?? 'Usuario' }}</div>
                        <span class="badge" style="background-color: #FFB703; color: #172554; font-size: 0.65rem; text-transform: uppercase;">
                            {{ auth()->user()->role ?? 'Cliente' }}
                        </span>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn w-100 py-2 d-flex align-items-center justify-content-center gap-2 text-white border-0" style="background-color: rgba(239, 68, 68, 0.2); color: #FCA5A5 !important; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#EF4444'; this.style.color='#FFFFFF'" onmouseout="this.style.backgroundColor='rgba(239, 68, 68, 0.2)'; this.style.color='#FCA5A5'">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Cerrar sesión</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- SIDEBAR OFFCANVAS MÓVIL (Pantallas < 992px) --}}
        <div class="offcanvas offcanvas-start text-white d-lg-none" tabindex="-1" id="offcanvasMobileSidebar" aria-labelledby="offcanvasMobileSidebarLabel" style="background-color: #172554; width: 280px;">
            <div class="offcanvas-header border-bottom border-white border-opacity-10 py-3">
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ asset('img/Iconos/Version compacta.jpg') }}" alt="SuperFast" style="height: 32px; width: 32px; object-fit: contain;" class="rounded-2">
                    <span class="fw-bold fs-5 text-white">Super<span style="color: #FF6B35;">Fast</span></span>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body d-flex flex-column justify-content-between p-3">
                <ul class="nav flex-column gap-2">
                    <li class="nav-item">
                        <a href="{{ route('inicio') }}" class="nav-link text-white-50 rounded px-3 py-2 d-flex align-items-center gap-2">
                            <i class="bi bi-house fs-5 text-warning"></i>
                            <span>Inicio Web</span>
                        </a>
                    </li>

                    @if(auth()->check() && auth()->user()->role === 'empresa')
                        <li class="nav-item">
                            <a href="{{ route('empresa.index') }}" class="nav-link text-white rounded px-3 py-2 d-flex align-items-center gap-2" style="background-color: rgba(255, 107, 53, 0.2); border-left: 3px solid #FF6B35;">
                                <i class="bi bi-shop fs-5" style="color: #FF6B35;"></i>
                                <span class="fw-bold">Mi Empresa</span>
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'text-white bg-white-10' : 'text-white-50' }} rounded px-3 py-2 d-flex align-items-center gap-2" style="{{ request()->routeIs('dashboard') ? 'background-color: rgba(255, 107, 53, 0.2); border-left: 3px solid #FF6B35;' : '' }}">
                                <i class="bi bi-grid-fill fs-5" style="color: #FF6B35;"></i>
                                <span class="fw-bold">Catálogo de Productos</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('carrito.index') }}" class="nav-link {{ request()->routeIs('carrito.*') ? 'text-white' : 'text-white-50' }} rounded px-3 py-2 d-flex align-items-center justify-content-between" style="{{ request()->routeIs('carrito.*') ? 'background-color: rgba(255, 107, 53, 0.2); border-left: 3px solid #FF6B35;' : '' }}">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-cart3 fs-5" style="color: #FFB703;"></i>
                                    <span>Mi Carrito</span>
                                </div>
                                @if($cartCount > 0)
                                    <span class="badge rounded-pill" style="background-color: #FF6B35;">{{ $cartCount }}</span>
                                @endif
                            </a>
                        </li>
                    @endif
                </ul>

                <div class="pt-3 border-top border-white border-opacity-10">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-sm" style="width: 36px; height: 36px; background-color: #FF6B35;">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <div class="fw-semibold text-white small">{{ auth()->user()->name ?? 'Usuario' }}</div>
                            <span class="badge bg-warning text-dark" style="font-size: 0.65rem;">{{ ucfirst(auth()->user()->role ?? 'Cliente') }}</span>
                        </div>
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-sm w-100 py-2 d-flex align-items-center justify-content-center gap-2 text-danger border-0" style="background-color: rgba(239, 68, 68, 0.15);">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Cerrar sesión</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- CONTENIDO PRINCIPAL FLUIDO Y RESPONSIVO --}}
        <div class="flex-fill d-flex flex-column min-vh-100 w-100 sf-mobile-padded-bottom" style="min-width: 0;">

            {{-- NAV SUPERIOR --}}
            <nav class="navbar bg-white shadow-sm px-3 px-md-4 py-2 py-md-3 border-bottom position-sticky top-0 z-3" style="border-color: #E2E8F0 !important;">
                <div class="container-fluid p-0 d-flex justify-content-between align-items-center gap-2">

                    <!-- Botón Hamburguesa Móvil (Visible solo en < 992px) -->
                    <button class="btn btn-light d-lg-none p-2 rounded-circle border shadow-xs d-flex align-items-center justify-content-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMobileSidebar" aria-controls="offcanvasMobileSidebar" title="Menú">
                        <i class="bi bi-list fs-4 text-dark"></i>
                    </button>

                    <!-- Buscador Responsivo -->
                    <form class="d-flex flex-grow-1 position-relative mx-1 mx-md-2" style="max-width: 500px;" action="{{ route('dashboard') }}" method="GET">
                        <i class="bi bi-search position-absolute top-50 translate-middle-y text-muted" style="left: 14px;"></i>
                        <input class="form-control ps-5 py-2" type="search" name="q" value="{{ request('q') }}" placeholder="Buscar en el catálogo..." style="background-color: #F8FAFC; border-radius: 50px; border: 1px solid #E2E8F0; font-size: 0.88rem;">
                    </form>

                    <!-- Accesos Rápidos Derecho -->
                    <div class="d-flex align-items-center gap-2 gap-sm-3 shrink-0">
                        @if(auth()->check() && auth()->user()->role !== 'empresa')
                            <a href="{{ route('carrito.index') }}" class="btn btn-light position-relative d-flex align-items-center justify-content-center rounded-circle border shadow-sm" style="width: 40px; height: 40px; background-color: #F8FAFC; border-color: #E2E8F0 !important;" title="Mi Carrito">
                                <i class="bi bi-cart3 fs-5" style="color: #FF6B35;"></i>
                                @if($cartCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill" style="background-color: #FF6B35; color: #FFFFFF; font-size: 0.68rem; font-weight: 700; border: 2px solid #FFFFFF;">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </a>
                        @endif

                        <div class="d-none d-sm-block text-end">
                            <span class="fw-bold d-block text-dark lh-1" style="font-size: 0.9rem;">
                                {{ auth()->user()->name ?? 'Usuario' }}
                            </span>
                            <small class="text-muted" style="font-size: 0.72rem;">
                                {{ ucfirst(auth()->user()->role ?? 'Cliente') }}
                            </small>
                        </div>
                    </div>

                </div>
            </nav>

            {{-- CONTENIDO DE CADA VISTA --}}
            <main class="container-fluid p-3 p-sm-4 p-md-5 flex-grow-1" style="background-color: #F5F7FA;">
                @yield('content')
            </main>

        </div>

    </div>

    {{-- BARRA INFERIOR MÓVIL (BOTTOM APP BAR) --}}
    <nav class="sf-mobile-bottom-nav d-lg-none">
        <a href="{{ route('inicio') }}" class="sf-mobile-nav-item {{ request()->routeIs('inicio') ? 'active' : '' }}">
            <i class="bi bi-house"></i>
            <span>Inicio</span>
        </a>

        @if(auth()->check() && auth()->user()->role === 'empresa')
            <a href="{{ route('empresa.index') }}" class="sf-mobile-nav-item {{ request()->routeIs('empresa.*') ? 'active' : '' }}">
                <i class="bi bi-shop"></i>
                <span>Mi Tienda</span>
            </a>
        @else
            <a href="{{ route('dashboard') }}" class="sf-mobile-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-fill"></i>
                <span>Catálogo</span>
            </a>

            <a href="{{ route('carrito.index') }}" class="sf-mobile-nav-item position-relative {{ request()->routeIs('carrito.*') ? 'active' : '' }}">
                <i class="bi bi-cart3"></i>
                <span>Carrito</span>
                @if($cartCount > 0)
                    <span class="position-absolute top-0 end-0 translate-middle-x badge rounded-pill bg-danger" style="font-size: 0.6rem; padding: 2px 5px;">
                        {{ $cartCount }}
                    </span>
                @endif
            </a>
        @endif

        <a href="#" class="sf-mobile-nav-item" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMobileSidebar">
            <i class="bi bi-person-circle"></i>
            <span>Menú</span>
        </a>
    </nav>

    {{-- Chatbot Asistente Virtual SuperFast (Vercel) --}}
    <x-chatbot-widget />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
