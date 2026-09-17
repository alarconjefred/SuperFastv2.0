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

    <div class="d-flex">

        {{-- SIDEBAR INSTITUCIONAL --}}
        <aside style="width: 260px; background-color: #172554; min-height: 100vh; border-right: 1px solid rgba(255,255,255,0.08);" class="text-white p-3 d-flex flex-column justify-content-between">
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
                            <a href="{{ route('empresa.index') }}" class="nav-link text-white rounded px-3 py-2 d-flex align-items-center gap-2" style="background-color: rgba(255, 107, 53, 0.2); border-left: 3px solid #FF6B35;">
                                <i class="bi bi-shop fs-5" style="color: #FF6B35;"></i>
                                <span class="fw-bold">Mi Empresa</span>
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link text-white rounded px-3 py-2 d-flex align-items-center gap-2" style="background-color: rgba(255, 107, 53, 0.2); border-left: 3px solid #FF6B35;">
                                <i class="bi bi-grid-fill fs-5" style="color: #FF6B35;"></i>
                                <span class="fw-bold">Restaurantes</span>
                            </a>
                        </li>
                    @endif

                    <li class="nav-item">
                        <a href="#" class="nav-link text-white-50 rounded px-3 py-2 d-flex align-items-center gap-2" onmouseover="this.style.backgroundColor='rgba(255,255,255,0.08)'; this.style.color='#FFFFFF'" onmouseout="this.style.backgroundColor='transparent'; this.style.color='rgba(255,255,255,0.5)'">
                            <i class="bi bi-bag-check fs-5"></i>
                            <span class="fw-medium">Mis Pedidos</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Footer Sidebar con Cerrar Sesión -->
            <div class="pt-3 border-top border-white border-opacity-10">
                <div class="d-flex align-items-center gap-2 mb-3 px-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width: 38px; height: 38px; background-color: #FF6B35;">
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

        {{-- CONTENIDO PRINCIPAL --}}
        <div class="flex-fill d-flex flex-column min-vh-100">

            {{-- NAV SUPERIOR --}}
            <nav class="navbar bg-white shadow-sm px-4 py-3 border-bottom" style="border-color: #E2E8F0 !important;">
                <div class="container-fluid d-flex justify-content-between align-items-center">

                    <form class="d-flex w-50 position-relative">
                        <i class="bi bi-search position-absolute top-50 translate-middle-y text-muted" style="left: 15px;"></i>
                        <input class="form-control ps-5" type="search" placeholder="Buscar productos, negocios o comida..." style="background-color: #F8FAFC; border-radius: 50px;">
                    </form>

                    <div class="d-flex align-items-center gap-3">
                        <div class="text-end">
                            <span class="fw-bold d-block text-dark" style="font-size: 0.95rem;">
                                {{ auth()->user()->name ?? 'Usuario' }}
                            </span>
                            <small class="text-muted" style="font-size: 0.75rem;">
                                SuperFast • {{ ucfirst(auth()->user()->role ?? 'Cliente') }}
                            </small>
                        </div>
                    </div>

                </div>
            </nav>

            {{-- CONTENIDO DE CADA VISTA --}}
            <main class="container-fluid p-4 p-md-5 flex-grow-1" style="background-color: #F5F7FA;">
                @yield('content')
            </main>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
