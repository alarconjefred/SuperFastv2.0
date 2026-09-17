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

                    <!-- BUSCADOR INSTITUCIONAL -->
                    <div class="search-bar mt-4">
                        <i class="bi bi-search text-muted fs-5 me-2"></i>
                        <input type="text" placeholder="Buscar restaurante, comida o producto...">
                        <button type="button" class="btn-sf-primary d-flex align-items-center gap-2">
                            <span>Buscar</span>
                            <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>

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


    <!-- RESTAURANTES DESTACADOS -->
    <section class="container py-5">

        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="badge px-3 py-2 rounded-pill mb-2" style="background-color: #FFF0EB; color: #FF6B35; font-weight: 700; font-size: 0.8rem;">
                    SELECCIÓN DESTACADA
                </span>
                <h2 class="fw-bold mb-0" style="color: #172554;">Restaurantes populares</h2>
            </div>
            <a href="{{ route('login') }}" class="fw-bold d-flex align-items-center gap-1" style="color: #FF6B35;">
                <span>Ver todos</span>
                <i class="bi bi-chevron-right"></i>
            </a>
        </div>

        <div class="row g-4">

            <div class="col-md-4">
                <div class="card sf-card restaurant-card h-100 border-0">
                    <div class="position-relative">
                        <img src="{{ asset('img/Productos/Pizza.png') }}" class="card-img-top" alt="Pizza Express">
                        <span class="badge position-absolute top-0 end-0 m-3 px-3 py-2 rounded-pill" style="background-color: #172554; color: #FFFFFF; font-size: 0.75rem;">
                            🍕 Italiana
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-1 mb-2">
                            <span style="color: #FFB703;">★★★★★</span>
                            <span class="fw-bold small ms-1" style="color: #172554;">4.9</span>
                            <span class="text-muted small">(120+ reseñas)</span>
                        </div>
                        <h5 class="card-title fw-bold" style="color: #172554;">Pizza Express</h5>
                        <p class="card-text text-muted small mb-3">Pizzas artesanales al horno de leña y comida italiana de primera calidad.</p>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top border-light">
                            <span class="small fw-semibold text-muted">
                                <i class="bi bi-clock text-warning"></i> 25-35 min
                            </span>
                            <a href="{{ route('login') }}" class="btn btn-sf-primary btn-sm px-3">
                                Pedir ahora
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card sf-card restaurant-card h-100 border-0">
                    <div class="position-relative">
                        <img src="{{ asset('img/Productos/Burger2.png') }}" class="card-img-top" alt="Burger House">
                        <span class="badge position-absolute top-0 end-0 m-3 px-3 py-2 rounded-pill" style="background-color: #172554; color: #FFFFFF; font-size: 0.75rem;">
                            🍔 Burgers
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-1 mb-2">
                            <span style="color: #FFB703;">★★★★★</span>
                            <span class="fw-bold small ms-1" style="color: #172554;">4.8</span>
                            <span class="text-muted small">(95+ reseñas)</span>
                        </div>
                        <h5 class="card-title fw-bold" style="color: #172554;">Burger House</h5>
                        <p class="card-text text-muted small mb-3">Hamburguesas gourmet 100% carne de res, quesos fundidos y papas rústicas.</p>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top border-light">
                            <span class="small fw-semibold text-muted">
                                <i class="bi bi-clock text-warning"></i> 20-30 min
                            </span>
                            <a href="{{ route('login') }}" class="btn btn-sf-primary btn-sm px-3">
                                Pedir ahora
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card sf-card restaurant-card h-100 border-0">
                    <div class="position-relative">
                        <img src="{{ asset('img/Productos/Sushi.png') }}" class="card-img-top" alt="Sushi Go">
                        <span class="badge position-absolute top-0 end-0 m-3 px-3 py-2 rounded-pill" style="background-color: #172554; color: #FFFFFF; font-size: 0.75rem;">
                            🍣 Japonesa
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-1 mb-2">
                            <span style="color: #FFB703;">★★★★★</span>
                            <span class="fw-bold small ms-1" style="color: #172554;">5.0</span>
                            <span class="text-muted small">(150+ reseñas)</span>
                        </div>
                        <h5 class="card-title fw-bold" style="color: #172554;">Sushi Go</h5>
                        <p class="card-text text-muted small mb-3">Rolls frescos, nigiris y combinados orientales preparados al momento.</p>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top border-light">
                            <span class="small fw-semibold text-muted">
                                <i class="bi bi-clock text-warning"></i> 30-40 min
                            </span>
                            <a href="{{ route('login') }}" class="btn btn-sf-primary btn-sm px-3">
                                Pedir ahora
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

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
