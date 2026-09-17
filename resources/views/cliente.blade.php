@extends('layouts.dashboardcliente')

@section('title', 'Catálogo de Productos - SuperFast')

@section('content')

    <!-- Notificaciones Flash -->
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

    <!-- Encabezado y Filtros Rápidos -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold mb-1" style="color: #172554;">Catálogo de Productos</h2>
            <p class="text-muted mb-0">Descubre productos frescos, platos gourmet y artículos locales con entrega rápida</p>
        </div>

        <div class="d-flex gap-2 flex-wrap align-items-center">
            @if(request('q'))
                <div class="badge px-3 py-2 rounded-pill bg-light text-dark border d-flex align-items-center gap-2">
                    <span>Filtrando por: <strong>"{{ request('q') }}"</strong></span>
                    <a href="{{ route('dashboard') }}" class="text-danger text-decoration-none" title="Quitar filtro">&times;</a>
                </div>
            @endif

            <span class="badge px-3 py-2 rounded-pill" style="background-color: #FF6B35; color: #FFFFFF; font-weight: 600;">
                <i class="bi bi-grid-fill me-1"></i> Todos los productos ({{ $productos->count() }})
            </span>
        </div>
    </div>

    <!-- Grilla Dinámica de Productos -->
    <div class="row g-4">

        @forelse ($productos as $producto)
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card sf-card h-100 border-0 shadow-sm overflow-hidden d-flex flex-column" style="background-color: #FFFFFF; border-radius: 16px; border: 1px solid #E2E8F0;">

                    <!-- Contenedor Seguro de Imagen (Proporciones Fijas sin deformación) -->
                    <div class="position-relative" style="height: 190px; width: 100%; overflow: hidden; background-color: #F8FAFC;">
                        <img src="{{ $producto->imagen_url }}" 
                             alt="{{ $producto->nombre }}" 
                             style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;"
                             onmouseover="this.style.transform='scale(1.04)'"
                             onmouseout="this.style.transform='scale(1)'">

                        <!-- Badge de Comercio Vendedor -->
                        <span class="badge position-absolute top-0 start-0 m-3 px-3 py-1 rounded-pill shadow-sm" style="background-color: rgba(255, 255, 255, 0.95); color: #172554; font-size: 0.75rem; font-weight: 700; backdrop-filter: blur(4px);">
                            <i class="bi bi-shop me-1" style="color: #FF6B35;"></i> {{ $producto->empresa ? $producto->empresa->nombre : 'SuperFast Partner' }}
                        </span>

                        <!-- Badge de Disponibilidad / Stock -->
                        @if(!$producto->disponible)
                            <span class="badge position-absolute top-0 end-0 m-3 px-3 py-1 rounded-pill bg-secondary text-white shadow-sm" style="font-size: 0.75rem;">
                                <i class="bi bi-slash-circle me-1"></i> No disponible
                            </span>
                        @elseif($producto->stock <= 0)
                            <span class="badge position-absolute top-0 end-0 m-3 px-3 py-1 rounded-pill bg-danger text-white shadow-sm" style="font-size: 0.75rem;">
                                <i class="bi bi-x-circle me-1"></i> Agotado
                            </span>
                        @else
                            <span class="badge position-absolute top-0 end-0 m-3 px-3 py-1 rounded-pill shadow-sm" style="background-color: #172554; color: #FFFFFF; font-size: 0.75rem;">
                                {{ $producto->stock }} disp.
                            </span>
                        @endif
                    </div>

                    <!-- Cuerpo de la Tarjeta -->
                    <div class="card-body p-4 d-flex flex-column justify-content-between flex-grow-1">
                        <div>
                            <h5 class="card-title fw-bold mb-1 text-truncate" style="color: #172554;" title="{{ $producto->nombre }}">
                                {{ $producto->nombre }}
                            </h5>
                            
                            <p class="card-text text-muted small mb-3" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 38px;">
                                {{ $producto->descripcion ?: 'Producto exclusivo disponible para entrega rápida en SuperFast.' }}
                            </p>
                        </div>

                        <div>
                            <!-- Fila Precio y Estado -->
                            <div class="d-flex justify-content-between align-items-center pt-2 mb-3 border-top border-light">
                                <div>
                                    <span class="text-muted d-block" style="font-size: 0.7rem; text-transform: uppercase; font-weight: 600;">Precio</span>
                                    <span class="fw-bolder fs-5" style="color: #FF6B35;">
                                        ${{ number_format($producto->precio, 2) }}
                                    </span>
                                </div>

                                <div>
                                    @if(!$producto->disponible)
                                        <span class="badge bg-secondary-subtle text-secondary border small">Inactivo</span>
                                    @elseif($producto->stock <= 0)
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle small">Agotado</span>
                                    @else
                                        <span class="badge bg-success-subtle text-success border border-success-subtle small">
                                            <i class="bi bi-check-circle me-1"></i>En stock
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Botón Agregar al Carrito (Control estricto de Stock) -->
                            @if($producto->disponible && $producto->stock > 0)
                                <form action="{{ route('carrito.agregar', $producto) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="cantidad" value="1">
                                    <button type="submit" class="btn btn-sf-primary w-100 py-2 d-flex align-items-center justify-content-center gap-2">
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
                        <i class="bi bi-box-seam fs-1" style="color: #FF6B35;"></i>
                    </div>
                    <h4 class="fw-bold" style="color: #172554;">No se encontraron productos disponibles</h4>
                    <p class="text-muted mx-auto" style="max-width: 480px;">
                        @if(request('q'))
                            No hay coincidencias para tu búsqueda "{{ request('q') }}". Intenta con otro término o limpia el buscador.
                        @else
                            Aún no hay productos registrados en el catálogo. ¡Las empresas asociadas pronto añadirán su oferta gastronómica!
                        @endif
                    </p>
                    @if(request('q'))
                        <div class="mt-2">
                            <a href="{{ route('dashboard') }}" class="btn btn-sf-secondary">Ver todo el catálogo</a>
                        </div>
                    @endif
                </div>
            </div>
        @endforelse

    </div>

@endsection
