<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body style="background-color:#f5f5f5;">

    <div class="d-flex">

        {{-- SIDEBAR --}}
        <div style="width:250px; background:#111827; min-height:100vh;" class="text-white p-3">

            <h4 class="mb-4">Mi App</h4>

            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="#" class="nav-link text-white">
                        <i class="bi bi-house"></i> Inicio
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="#" class="nav-link text-white">
                        <i class="bi bi-bag"></i> Productos
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="#" class="nav-link text-white">
                        <i class="bi bi-receipt"></i> Pedidos
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="/login-empresa" class="nav-link text-white">
                        <i class="bi bi-receipt"></i> Empresas
                    </a>
                </li>

                <li class="nav-item mt-4">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-danger w-100">
                            Cerrar sesión
                        </button>
                    </form>
                </li>
            </ul>
        </div>

        {{-- CONTENIDO PRINCIPAL --}}
        <div class="flex-fill">

            {{-- NAV SUPERIOR --}}
            <nav class="navbar bg-white shadow-sm px-4">
                <div class="container-fluid">

                    <form class="d-flex w-50">
                        <input class="form-control me-2" type="search" placeholder="Buscar productos...">
                    </form>

                    <div>
                        <span class="me-3 fw-bold">
                            {{ auth()->user()->name }}
                        </span>
                    </div>

                </div>
            </nav>

            {{-- CONTENIDO --}}
            <div class="container py-4">
                @yield('content')
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
