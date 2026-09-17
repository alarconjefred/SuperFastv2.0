@extends('layouts.dashboardcliente')

@section('title', 'Catálogo de Productos - SuperFast')

@section('content')

    <!-- Alertas Flash -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 rounded-4 shadow-sm py-3 px-4 mb-4 d-flex align-items-center gap-3" role="alert" style="background-color: #ECFDF5; color: #065F46;">
            <i class="bi bi-check-circle-fill fs-4" style="color: #10B981;"></i>
            <div class="flex-grow-1">
                <strong>{{ session('success') }}</strong>
                <a href="{{ route('carrito.index') }}" class="alert-link ms-2 text-decoration-underline" style="color: #047857;">Ver mi carrito &rarr;</a>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 rounded-4 shadow-sm py-3 px-4 mb-4 d-flex align-items-center gap-3" role="alert" style="background-color: #FEF2F2; color: #991B1B;">
            <i class="bi bi-exclamation-triangle-fill fs-4" style="color: #EF4444;"></i>
            <div class="flex-grow-1">
                {{ session('error') }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- TICKER LIVE STITCH: Estado de Red y Entregas en Vivo -->
    <div class="rounded-4 p-3 mb-4 text-white d-flex align-items-center justify-content-between flex-wrap gap-2 shadow-sm" style="background: linear-gradient(135deg, #172554 0%, #0F172A 100%); border-left: 4px solid #FF6B35;">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <span class="sf-pulse-dot" style="background-color: #FF6B35;"></span>
            <span class="badge rounded-pill" style="background-color: #FF6B35; font-size: 0.75rem; font-weight: 700;">¡EN RUTA!</span>
            <span class="small text-white-50 d-none d-sm-inline">Despacho exprés garantizado:</span>
            <span class="small fw-bold text-white"><i class="bi bi-lightning-charge-fill text-warning me-1"></i>Entrega en 20-35 min</span>
        </div>
        <div class="d-flex align-items-center gap-2 small text-white-50">
            <span class="d-none d-md-inline"><i class="bi bi-shield-check text-warning me-1"></i>Pago 100% protegido</span>
            <span class="badge bg-white bg-opacity-10 text-white rounded-pill px-2.5 py-1">
                <i class="bi bi-shop me-1 text-warning"></i> Locales abiertos
            </span>
        </div>
    </div>

    <!-- ENCABEZADO Y FILTROS RÁPIDOS DE CATEGORÍAS (STITCH SPEC) -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div>
            <h3 class="fw-bold mb-0" style="color: #172554; font-size: clamp(1.25rem, 2.5vw, 1.65rem);">
                Catálogo de Productos
            </h3>
            <p class="text-muted small mb-0">Selecciona tus comidas favoritas y recíbelas al instante</p>
        </div>

        @if(request('q'))
            <div class="badge px-3 py-2 rounded-pill bg-light text-dark border d-flex align-items-center gap-2">
                <span class="small">Búsqueda: <strong>"{{ request('q') }}"</strong></span>
                <a href="{{ route('dashboard') }}" class="text-danger text-decoration-none fw-bold" title="Limpiar">&times;</a>
            </div>
        @else
            <span class="badge px-3 py-2 rounded-pill" style="background-color: #FFF0EB; color: #FF6B35; font-weight: 700; font-size: 0.78rem;">
                <i class="bi bi-grid-fill me-1"></i> {{ $productos->count() }} ítems disponibles
            </span>
        @endif
    </div>

    <!-- Píldoras Horizontales con Scroll Suave Responsivo -->
    <div class="d-flex align-items-center gap-2 overflow-x-auto pb-2 mb-4 no-scrollbar">
        <a href="{{ route('dashboard') }}" class="btn btn-sm px-3 py-1.5 rounded-pill shrink-0 fw-bold {{ !request('q') ? 'btn-sf-primary shadow-xs' : 'btn-light border text-dark' }}">
            Todos ({{ $productos->count() }})
        </a>
        <a href="{{ route('dashboard', ['q' => 'Burger']) }}" class="btn btn-sm btn-light border px-3 py-1.5 rounded-pill shrink-0 text-dark fw-medium">
            🍔 Hamburguesas
        </a>
        <a href="{{ route('dashboard', ['q' => 'Pizza']) }}" class="btn btn-sm btn-light border px-3 py-1.5 rounded-pill shrink-0 text-dark fw-medium">
            🍕 Pizzas
        </a>
        <a href="{{ route('dashboard', ['q' => 'Sushi']) }}" class="btn btn-sm btn-light border px-3 py-1.5 rounded-pill shrink-0 text-dark fw-medium">
            🍣 Sushi & Bowls
        </a>
        <a href="{{ route('dashboard', ['q' => 'Tacos']) }}" class="btn btn-sm btn-light border px-3 py-1.5 rounded-pill shrink-0 text-dark fw-medium">
            🌮 Parrilla & Tacos
        </a>
        <a href="{{ route('dashboard', ['q' => 'Bebida']) }}" class="btn btn-sm btn-light border px-3 py-1.5 rounded-pill shrink-0 text-dark fw-medium">
            🥤 Bebidas & Postres
        </a>
    </div>

    <!-- GRID DINÁMICO TOTALMENTE RESPONSIVO (1 col en móvil, 2 en tablet, 3 en desktop, 4 en pantallas amplias) -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-3 g-md-4">

        @forelse ($productos as $producto)
            <div class="col">
                <div class="card sf-card h-100 border-0 shadow-sm overflow-hidden d-flex flex-column" style="background-color: #FFFFFF; border-radius: 16px; border: 1px solid #E2E8F0; transition: transform 0.2s ease, box-shadow 0.2s ease;">

                    <!-- Contenedor Seguro de Imagen (Proporciones Fijas sin Deformación) -->
                    <div class="position-relative" style="height: 185px; width: 100%; overflow: hidden; background-color: #F8FAFC;">
                        <img src="{{ $producto->imagen_url }}" 
                             alt="{{ $producto->nombre }}" 
                             style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.35s ease;"
                             onmouseover="this.style.transform='scale(1.05)'"
                             onmouseout="this.style.transform='scale(1)'">

                        <!-- Badge Comercio (Stitch Floating Vendor Tag) -->
                        <span class="badge position-absolute top-0 start-0 m-2 m-sm-2.5 px-2.5 py-1 rounded-pill shadow-sm" style="background-color: rgba(255, 255, 255, 0.92); color: #172554; font-size: 0.72rem; font-weight: 700; backdrop-filter: blur(4px); max-width: 60%; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                            <i class="bi bi-shop me-1" style="color: #FF6B35;"></i> {{ $producto->empresa ? $producto->empresa->nombre : 'SuperFast Partner' }}
                        </span>

                        <!-- Badge Disponibilidad / Stock (Stitch Status Pill) -->
                        @if(!$producto->disponible)
                            <span class="badge position-absolute top-0 end-0 m-2 m-sm-2.5 px-2.5 py-1 rounded-pill bg-secondary text-white shadow-sm" style="font-size: 0.72rem;">
                                <i class="bi bi-slash-circle me-1"></i> Pausado
                            </span>
                        @elseif($producto->stock <= 0)
                            <span class="badge position-absolute top-0 end-0 m-2 m-sm-2.5 px-2.5 py-1 rounded-pill bg-danger text-white shadow-sm font-bold" style="font-size: 0.72rem;">
                                <i class="bi bi-x-circle me-1"></i> Agotado
                            </span>
                        @elseif($producto->stock <= 3)
                            <span class="badge position-absolute top-0 end-0 m-2 m-sm-2.5 px-2.5 py-1 rounded-pill shadow-sm text-dark font-bold" style="background-color: #FFB703; font-size: 0.72rem;">
                                <i class="bi bi-exclamation-triangle me-1"></i> ¡Últimas {{ $producto->stock }}!
                            </span>
                        @else
                            <span class="badge position-absolute top-0 end-0 m-2 m-sm-2.5 px-2.5 py-1 rounded-pill shadow-sm" style="background-color: #172554; color: #FFFFFF; font-size: 0.72rem;">
                                <span class="sf-pulse-dot me-1" style="background-color: #10B981; width: 6px; height: 6px;"></span>{{ $producto->stock }} disp.
                            </span>
                        @endif
                    </div>

                    <!-- Cuerpo de la Tarjeta -->
                    <div class="card-body p-3 p-sm-4 d-flex flex-column justify-content-between flex-grow-1">
                        <div>
                            <h5 class="card-title fw-bold mb-1 text-truncate" style="color: #172554; font-size: 1.05rem;" title="{{ $producto->nombre }}">
                                {{ $producto->nombre }}
                            </h5>
                            
                            <p class="card-text text-muted small mb-3" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 38px; line-height: 1.35;">
                                {{ $producto->descripcion ?: 'Elaborado al momento con ingredientes frescos de la mejor calidad.' }}
                            </p>
                        </div>

                        <div>
                            <!-- Fila Precio y Estado -->
                            <div class="d-flex justify-content-between align-items-center pt-2 mb-3 border-top border-light">
                                <div>
                                    <span class="text-muted d-block" style="font-size: 0.68rem; text-transform: uppercase; font-weight: 700;">Precio</span>
                                    <span class="fw-bolder fs-5" style="color: #FF6B35;">
                                        ${{ number_format($producto->precio, 2) }}
                                    </span>
                                </div>

                                <div>
                                    @if(!$producto->disponible)
                                        <span class="badge bg-secondary-subtle text-secondary border small">No disponible</span>
                                    @elseif($producto->stock <= 0)
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle small font-bold">Agotado</span>
                                    @elseif($producto->stock <= 3)
                                        <span class="badge bg-warning-subtle text-dark border border-warning-subtle small">Bajo Stock</span>
                                    @else
                                        <span class="badge bg-success-subtle text-success border border-success-subtle small">
                                            <i class="bi bi-check-circle me-1"></i>En stock
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Botón Agregar al Carrito (Control Estricto de Stock) -->
                            @if($producto->disponible && $producto->stock > 0)
                                <form action="{{ route('carrito.agregar', $producto) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="cantidad" value="1">
                                    <button type="submit" class="btn btn-sf-primary w-100 py-2 d-flex align-items-center justify-content-center gap-2 shadow-xs">
                                        <i class="bi bi-cart-plus"></i>
                                        <span>Agregar al carrito</span>
                                    </button>
                                </form>
                            @elseif(!$producto->disponible)
                                <button type="button" class="btn btn-secondary w-100 py-2 d-flex align-items-center justify-content-center gap-2 opacity-50" disabled>
                                    <i class="bi bi-slash-circle"></i>
                                    <span>No disponible</span>
                                </button>
                            @else
                                <button type="button" class="btn btn-danger w-100 py-2 d-flex align-items-center justify-content-center gap-2 opacity-75" disabled>
                                    <i class="bi bi-x-circle"></i>
                                    <span>Agotado</span>
                                </button>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card sf-card border-0 shadow-sm rounded-4 p-5 text-center my-4" style="background-color: #FFFFFF; border: 1px solid #E2E8F0;">
                    <div class="mb-3">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 70px; background-color: #FFF0EB;">
                            <i class="bi bi-box-seam fs-2" style="color: #FF6B35;"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold" style="color: #172554;">No se encontraron productos</h4>
                    <p class="text-muted mx-auto mb-3" style="max-width: 460px;">
                        @if(request('q'))
                            No hay coincidencias para tu búsqueda "{{ request('q') }}". Intenta con otro término o limpia el buscador.
                        @else
                            Aún no hay productos registrados en el catálogo. ¡Pronto los mejores restaurantes añadirán sus platos!
                        @endif
                    </p>
                    @if(request('q'))
                        <div>
                            <a href="{{ route('dashboard') }}" class="btn btn-sf-secondary btn-sm px-3 py-2">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Ver todo el catálogo
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @endforelse

    </div>

@endsection
