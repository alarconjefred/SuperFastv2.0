@extends('layouts.publico')

@section('title', 'SuperFast - Domicilios rápidos en tu ciudad')

@section('content')

    <!-- HERO PRINCIPAL INSTITUCIONAL -->
    <section class="container-fluid text-white py-5 position-relative overflow-hidden" 
             style="background: linear-gradient(135deg, #172554 0%, #0F172A 100%); border-bottom: 3px solid #FF6B35;">
        <div class="container py-4">

            <div class="row align-items-center g-5">

                <div class="col-lg-6">
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" 
                         style="background-color: rgba(255, 183, 3, 0.15); border: 1px solid rgba(255, 183, 3, 0.3); color: #FFB703; font-size: 0.85rem; font-weight: 600;">
                        <i class="bi bi-lightning-charge-fill"></i>
                        <span>Entregas ultra rápidas en minutos</span>
                    </div>

                    <h1 class="display-4 fw-extrabold text-white mb-3 lh-sm">
                        Domicilios rápidos en <span style="color: #FFB703;">tu ciudad</span>
                    </h1>

                    <p class="lead text-white-50 mb-4" style="font-size: 1.15rem;">
                        Encuentra tus restaurantes y comercios locales favoritos y recibe tu pedido directamente en tu puerta con total confianza.
                    </p>

                    <!-- BUSCADOR INSTITUCIONAL FUNCIONAL -->
                    <form action="{{ route('dashboard') }}" method="GET" class="search-bar mt-4 ms-0">
                        <i class="bi bi-search text-muted fs-5 me-2"></i>
                        <input type="text" name="q" placeholder="Buscar restaurante, comida o producto..." autocomplete="off">
                        <button type="submit" class="btn-sf-primary d-flex align-items-center gap-2">
                            <span>Buscar</span>
                            <i class="bi bi-arrow-right"></i>
                        </button>
                    </form>

                    <div class="d-flex align-items-center gap-4 mt-4 text-white-50 small">
                        <div class="d-flex align-items-center gap-1">
                            <i class="bi bi-check-circle-fill text-warning"></i> Negocios locales
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <i class="bi bi-shield-check text-warning"></i> Pago 100% seguro
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <i class="bi bi-clock-history text-warning"></i> 30-45 mins promedio
                        </div>
                    </div>

                </div>

                <div class="col-lg-6 text-center">
                    <div class="position-relative d-inline-block p-3 rounded-4 shadow-lg" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255,255,255,0.15);">
                        <img src="{{ asset('img/Logos/Logo principal.jpeg') }}" 
                             class="img-fluid rounded-3 shadow" 
                             alt="SuperFast - Marca Oficial"
                             style="max-height: 280px; width: auto; object-fit: contain;">
                    </div>
                </div>

            </div>

        </div>
    </section>


    <!-- COMO FUNCIONA -->
    <section class="container py-5 my-3">

        <div class="text-center mb-5">
            <span class="badge px-3 py-2 rounded-pill mb-2" style="background-color: #FFF0EB; color: #FF6B35; font-weight: 700; font-size: 0.8rem;">
                PASO A PASO
            </span>
            <h2 class="fw-bold" style="color: #172554;">¿Cómo funciona SuperFast?</h2>
            <p class="text-muted">Hacer tu pedido nunca fue tan sencillo y seguro</p>
        </div>

        <div class="row g-4 text-center">

            <div class="col-md-4">
                <div class="card sf-card h-100 p-4 border-0 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center mx-auto mb-3 rounded-circle shadow-sm" 
                         style="width: 70px; height: 70px; background-color: #FFF0EB; color: #FF6B35; font-size: 2rem;">
                        🍔
                    </div>
                    <h4 class="fw-bold mb-2" style="color: #172554;">1. Elige tu comida</h4>
                    <p class="text-muted mb-0">Explora restaurantes locales y encuentra tus platos o productos favoritos.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card sf-card h-100 p-4 border-0 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center mx-auto mb-3 rounded-circle shadow-sm" 
                         style="width: 70px; height: 70px; background-color: #FFF0EB; color: #FF6B35; font-size: 2rem;">
                        🛒
                    </div>
                    <h4 class="fw-bold mb-2" style="color: #172554;">2. Haz tu pedido</h4>
                    <p class="text-muted mb-0">Agrega productos al carrito con facilidad y confirma tu orden en segundos.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card sf-card h-100 p-4 border-0 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center mx-auto mb-3 rounded-circle shadow-sm" 
                         style="width: 70px; height: 70px; background-color: #FFF0EB; color: #FF6B35; font-size: 2rem;">
                        🚴
                    </div>
                    <h4 class="fw-bold mb-2" style="color: #172554;">3. Recibe en tu puerta</h4>
                    <p class="text-muted mb-0">Un repartidor llevará tu pedido de manera rápida, segura y caliente.</p>
                </div>
            </div>

        </div>

    </section>


    <!-- SECCIÓN DE COMERCIOS Y EMPRESAS REGISTRADAS -->
    <section class="container py-5 my-2">

        <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-2">
            <div>
                <span class="badge px-3 py-1.5 rounded-pill mb-2 shadow-xs" style="background-color: #FFF0EB; color: #FF6B35; font-weight: 700; font-size: 0.8rem;">
                    <i class="bi bi-shop me-1"></i> COMERCIOS ALIADOS EN TU CIUDAD
                </span>
                <h2 class="fw-bold mb-0" style="color: #172554;">Negocios locales registrados</h2>
                <p class="text-muted small mb-0 mt-1">Descubre restaurantes y emprendimientos locales con despacho express en minutos.</p>
            </div>
            
            @if($empresas->isNotEmpty())
                @auth
                    <a href="{{ route('dashboard') }}" class="fw-bold d-flex align-items-center gap-1 text-decoration-none" style="color: #FF6B35;">
                        <span>Ver catálogo completo</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="fw-bold d-flex align-items-center gap-1 text-decoration-none" style="color: #FF6B35;">
                        <span>Explorar todos</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                @endauth
            @endif
        </div>

        @if($empresas->isEmpty())
            <!-- ESTADO ALTERNATIVO: CUANDO NO EXISTEN EMPRESAS REGISTRADAS (CASO 1) -->
            <div class="card sf-card border-0 shadow-sm rounded-4 p-5 text-center my-3 position-relative overflow-hidden" style="background-color: #FFFFFF; border: 1.5px dashed #CBD5E1 !important;">
                <div class="py-4 my-2">
                    <div class="d-inline-flex p-3 rounded-4 bg-light shadow-xs border border-light mb-4 position-relative">
                        <img src="{{ asset('img/Logos/Logo principal.jpeg') }}" 
                             alt="SuperFast" 
                             style="max-height: 85px; width: auto; object-fit: contain;" 
                             class="rounded-2">
                        <span class="sf-pulse-dot position-absolute top-0 end-0 m-2" style="background-color: #FF6B35;"></span>
                    </div>

                    <h4 class="fw-bold mb-2" style="color: #172554;">Próximamente comercios en tu zona</h4>
                    <p class="text-muted mx-auto mb-4" style="max-width: 520px; font-size: 0.95rem;">
                        Estamos sumando a los mejores restaurantes, panaderías y tiendas locales de tu ciudad. Muy pronto podrás ordenar tus productos favoritos con entregas en minutos.
                    </p>

                    <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap">
                        <a href="{{ route('register.empresa') }}" class="btn btn-sf-primary px-4 py-2.5 fw-bold rounded-3 shadow-sm d-inline-flex align-items-center gap-2">
                            <i class="bi bi-shop"></i>
                            <span>Registrar mi Empresa</span>
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-outline-secondary px-4 py-2.5 fw-semibold rounded-3 d-inline-flex align-items-center gap-2">
                            <i class="bi bi-bell"></i>
                            <span>Crear cuenta de cliente</span>
                        </a>
                    </div>
                </div>
            </div>
        @else
            <!-- CUADRÍCULA DE EMPRESAS Y PRODUCTOS REALES DE LA BASE DE DATOS -->
            <div class="row g-4 row-cols-1 row-cols-md-2 row-cols-lg-3">
                @foreach($empresas as $empresa)
                    <div class="col">
                        <div class="card sf-card h-100 border-0 shadow-sm rounded-4 overflow-hidden d-flex flex-column bg-white">
                            
                            <!-- Encabezado de la Empresa -->
                            <div class="p-3 px-4 bg-light border-bottom d-flex align-items-center justify-content-between gap-2" style="border-color: #F1F5F9 !important;">
                                <div class="d-flex align-items-center gap-2.5 min-w-0">
                                    <!-- Logo o Iniciales Estilizadas de la Empresa (Caso 5) -->
                                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-xs flex-shrink-0" 
                                         style="width: 42px; height: 42px; background: linear-gradient(135deg, #172554 0%, #1E3A8A 100%); font-size: 0.88rem; letter-spacing: 0.05em;">
                                        {{ $empresa->iniciales }}
                                    </div>
                                    
                                    <div class="min-w-0">
                                        <h5 class="fw-bold mb-0 text-truncate text-dark" title="{{ $empresa->nombre }}" style="font-size: 1.05rem;">
                                            {{ $empresa->nombre }}
                                        </h5>
                                        <!-- Información Opcional de la Empresa (Caso 6) -->
                                        @if($empresa->direccion)
                                            <small class="text-muted text-truncate d-block" style="font-size: 0.74rem;">
                                                <i class="bi bi-geo-alt-fill text-warning"></i> {{ $empresa->direccion }}
                                            </small>
                                        @else
                                            <small class="text-success fw-semibold d-block" style="font-size: 0.74rem;">
                                                <i class="bi bi-patch-check-fill"></i> Comercio Aliado Verificado
                                            </small>
                                        @endif
                                    </div>
                                </div>

                                <!-- Contador de Productos -->
                                <span class="badge rounded-pill bg-white border text-secondary shadow-2xs small px-2.5 py-1 flex-shrink-0" style="font-size: 0.72rem;">
                                    {{ $empresa->productos->count() }} {{ $empresa->productos->count() === 1 ? 'producto' : 'productos' }}
                                </span>
                            </div>

                            <!-- Cuerpo de la Tarjeta con Producto Publicado -->
                            <div class="card-body p-3 p-sm-4 d-flex flex-column flex-grow-1">
                                @if($empresa->productos->isNotEmpty())
                                    @php
                                        // Obtener el producto publicado más reciente
                                        $producto = $empresa->productos->first();
                                    @endphp

                                    <!-- Imagen del Producto (Ratio fijo, fallback institucional Caso 4) -->
                                    <div class="position-relative rounded-3 overflow-hidden mb-3 bg-light border shadow-2xs" style="height: 180px;">
                                        <img src="{{ $producto->imagen_url }}" 
                                             alt="{{ $producto->nombre }}" 
                                             class="w-100 h-100 object-fit-cover">
                                        
                                        <!-- Badge de Disponibilidad y Stock -->
                                        @if($producto->esta_agotado)
                                            <span class="badge bg-danger position-absolute top-0 end-0 m-2 px-2.5 py-1 rounded-pill small fw-bold shadow-xs">
                                                <i class="bi bi-x-circle me-1"></i> Agotado
                                            </span>
                                        @else
                                            <span class="badge bg-success position-absolute top-0 end-0 m-2 px-2.5 py-1 rounded-pill small fw-bold shadow-xs">
                                                <i class="bi bi-check-circle me-1"></i> En Stock ({{ $producto->stock }})
                                            </span>
                                        @endif

                                        <span class="badge bg-dark bg-opacity-75 text-white position-absolute bottom-0 start-0 m-2 px-2 py-0.5 rounded small" style="font-size: 0.68rem;">
                                            <i class="bi bi-tag-fill text-warning me-1"></i> Plato / Producto
                                        </span>
                                    </div>

                                    <!-- Datos del Producto -->
                                    <div class="mb-3 flex-grow-1">
                                        <h6 class="fw-bold mb-1 text-truncate" style="color: #172554; font-size: 0.98rem;" title="{{ $producto->nombre }}">
                                            {{ $producto->nombre }}
                                        </h6>
                                        <p class="small text-muted mb-0" style="font-size: 0.8rem; line-height: 1.4;">
                                            {{ Str::limit($producto->descripcion ?? 'Producto disponible para despacho express en tu ciudad.', 65) }}
                                        </p>
                                    </div>

                                    <!-- Precio y Acción -->
                                    <div class="d-flex justify-content-between align-items-center pt-2.5 border-top border-light mt-auto">
                                        <div>
                                            <span class="small text-muted d-block" style="font-size: 0.7rem; letter-spacing: 0.04em;">PRECIO</span>
                                            <span class="fw-bold fs-5" style="color: #FF6B35;">$ {{ number_format($producto->precio, 0, ',', '.') }}</span>
                                        </div>

                                        @auth
                                            @if(auth()->user()->role === 'empresa')
                                                <a href="{{ route('empresa.index') }}" class="btn btn-outline-sf-secondary btn-sm px-3 fw-bold d-inline-flex align-items-center gap-1">
                                                    <span>Mi Panel</span>
                                                </a>
                                            @else
                                                <a href="{{ route('dashboard', ['q' => $producto->nombre]) }}" class="btn btn-sf-primary btn-sm px-3 fw-bold d-inline-flex align-items-center gap-1 shadow-xs">
                                                    <i class="bi bi-bag-plus"></i>
                                                    <span>Pedir</span>
                                                </a>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-sf-primary btn-sm px-3 fw-bold d-inline-flex align-items-center gap-1 shadow-xs">
                                                <span>Pedir ahora</span>
                                                <i class="bi bi-arrow-right"></i>
                                            </a>
                                        @endauth
                                    </div>

                                @else
                                    <!-- CASO 2: EMPRESA REGISTRADA SIN PRODUCTOS PUBLICADOS -->
                                    <div class="rounded-3 p-4 text-center bg-light border border-dashed my-auto d-flex flex-column align-items-center justify-content-center" style="min-height: 190px;">
                                        <div class="rounded-circle p-2.5 mb-2 bg-white shadow-xs text-muted">
                                            <i class="bi bi-box-seam fs-4" style="color: #FFB703;"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark mb-1 small">Menú en preparación</h6>
                                        <p class="small text-muted mb-0" style="font-size: 0.76rem; max-width: 200px;">
                                            Este negocio aliado está configurando su catálogo para recibir órdenes.
                                        </p>
                                    </div>

                                    <div class="pt-3 border-top border-light mt-3 text-center">
                                        <span class="badge bg-white text-muted border px-2.5 py-1 small" style="font-size: 0.72rem;">
                                            <i class="bi bi-clock me-1"></i> Disponible próximamente
                                        </span>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            <!-- CASO 7: ENLACE PARA EXPLORAR MÁS CUANDO HAY VARIOS COMERCIOS -->
            <div class="text-center mt-4 pt-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-sf-primary px-4 py-2.5 fw-bold rounded-pill shadow-xs d-inline-flex align-items-center gap-2">
                        <span>Explorar todos los comercios y platillos</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-sf-primary px-4 py-2.5 fw-bold rounded-pill shadow-xs d-inline-flex align-items-center gap-2">
                        <span>Inicia sesión para ver todos los comercios</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                @endauth
            </div>
        @endif

    </section>


    <!-- BENEFICIOS INSTITUCIONALES -->
    <section class="container-fluid py-5 my-4" style="background-color: #FFFFFF; border-top: 1px solid #E2E8F0; border-bottom: 1px solid #E2E8F0;">

        <div class="container py-3">

            <div class="text-center mb-5">
                <span class="badge px-3 py-2 rounded-pill mb-2" style="background-color: #FFF0EB; color: #FF6B35; font-weight: 700; font-size: 0.8rem;">
                    CONFIANZA Y RAPIDEZ
                </span>
                <h2 class="fw-bold" style="color: #172554;">¿Por qué elegir SuperFast?</h2>
                <p class="text-muted">Diseñado para brindarte la mejor experiencia en cada entrega</p>
            </div>

            <div class="row text-center g-4">

                <div class="col-md-4">
                    <div class="p-3">
                        <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-circle shadow-sm" 
                             style="width: 65px; height: 65px; background-color: #172554; color: #FFB703; font-size: 1.8rem;">
                            <i class="bi bi-lightning-charge-fill"></i>
                        </div>
                        <h4 class="fw-bold mb-2" style="color: #172554;">Entrega ultra rápida</h4>
                        <p class="text-muted">Nuestra red de repartidores optimiza rutas para llegar siempre a tiempo.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-3">
                        <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-circle shadow-sm" 
                             style="width: 65px; height: 65px; background-color: #172554; color: #FF6B35; font-size: 1.8rem;">
                            <i class="bi bi-shop"></i>
                        </div>
                        <h4 class="fw-bold mb-2" style="color: #172554;">Apoyo local</h4>
                        <p class="text-muted">Con cada pedido impulsas negocios, emprendedores y restaurantes de tu ciudad.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-3">
                        <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-circle shadow-sm" 
                             style="width: 65px; height: 65px; background-color: #172554; color: #10B981; font-size: 1.8rem;">
                            <i class="bi bi-shield-lock-fill"></i>
                        </div>
                        <h4 class="fw-bold mb-2" style="color: #172554;">Transacciones seguras</h4>
                        <p class="text-muted">Tus compras y datos personales viajan con cifrado seguro en todo momento.</p>
                    </div>
                </div>

            </div>

        </div>

    </section>


    <!-- SECCION MEMBRESIA -->
    <section class="container py-5 my-3">

        <div class="row justify-content-center">
            <div class="col-lg-9">

                <div class="card border-0 shadow-lg text-center p-5 position-relative overflow-hidden"
                    style="border-radius: 24px; background: linear-gradient(135deg, #172554 0%, #0F172A 100%); color: white; border: 2px solid rgba(255, 183, 3, 0.3);">

                    <div class="mb-3">
                        <span class="d-inline-block p-3 rounded-circle" style="background-color: rgba(255, 183, 3, 0.15); color: #FFB703; font-size: 2.5rem;">
                            👑
                        </span>
                    </div>

                    <h2 class="fw-bold mb-2 text-white">Membresía SuperFast VIP</h2>

                    <p class="fs-5 fw-semibold" style="color: #FFB703;">
                        Lleva tu experiencia gastronómica al siguiente nivel
                    </p>

                    <p class="text-white-50 mx-auto mb-4" style="max-width: 550px;">
                        Disfruta de envíos sin costo en restaurantes asociados, promociones exclusivas cada semana y atención preferencial.
                    </p>

                    <div>
                        <button class="btn btn-sf-primary btn-lg fw-bold px-5 shadow-lg" data-bs-toggle="modal" data-bs-target="#vipModal">
                            Ver beneficios exclusivos
                        </button>
                    </div>

                </div>

            </div>
        </div>

    </section>

    <!-- MODAL VIP INSTITUCIONAL -->
    <div class="modal fade" id="vipModal" tabindex="-1" aria-labelledby="vipModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden" style="background-color: #FFFFFF;">

                <div class="modal-header text-white p-4" style="background-color: #172554;">
                    <h5 class="modal-title fw-bold d-flex align-items-center gap-2" id="vipModalLabel">
                        <span style="color: #FFB703;">👑</span> Beneficios SuperFast VIP
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <ul class="list-group list-group-flush gap-2">
                        <li class="list-group-item d-flex align-items-center gap-3 border-0 px-0">
                            <span class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 32px; height: 32px; background-color: #FF6B35;">
                                <i class="bi bi-truck"></i>
                            </span>
                            <span class="fw-medium text-dark">Envíos gratis ilimitados en pedidos seleccionados</span>
                        </li>

                        <li class="list-group-item d-flex align-items-center gap-3 border-0 px-0">
                            <span class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 32px; height: 32px; background-color: #FF6B35;">
                                <i class="bi bi-lightning-fill"></i>
                            </span>
                            <span class="fw-medium text-dark">Prioridad máxima en cocina y despacho</span>
                        </li>

                        <li class="list-group-item d-flex align-items-center gap-3 border-0 px-0">
                            <span class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 32px; height: 32px; background-color: #FF6B35;">
                                <i class="bi bi-gift-fill"></i>
                            </span>
                            <span class="fw-medium text-dark">Descuentos y combos exclusivos para miembros</span>
                        </li>

                        <li class="list-group-item d-flex align-items-center gap-3 border-0 px-0">
                            <span class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 32px; height: 32px; background-color: #FF6B35;">
                                <i class="bi bi-star-fill"></i>
                            </span>
                            <span class="fw-medium text-dark">Soporte prioritario 24/7 en tus órdenes</span>
                        </li>
                    </ul>
                </div>

                <div class="modal-footer p-3 bg-light border-0">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-sf-primary btn-sm px-4">
                        Activar membresía
                    </button>
                </div>

            </div>
        </div>
    </div>

@endsection
