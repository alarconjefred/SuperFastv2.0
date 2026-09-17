@extends('layouts.dashboardcliente')

@section('title', 'Mi Carrito - SuperFast')

@section('content')

    <!-- Alertas Flash -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 rounded-4 shadow-sm py-3 px-4 mb-4 d-flex align-items-center gap-3" role="alert" style="background-color: #ECFDF5; color: #065F46;">
            <i class="bi bi-check-circle-fill fs-4" style="color: #10B981;"></i>
            <div class="flex-grow-1">
                {{ session('success') }}
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

    <!-- Advertencias de Sincronización Automática de Stock -->
    @if(!empty($warnings) && count($warnings) > 0)
        <div class="alert alert-warning alert-dismissible fade show border-0 rounded-4 shadow-sm py-3 px-4 mb-4" role="alert" style="background-color: #FFFBEB; color: #92400E; border-left: 4px solid #F59E0B !important;">
            <div class="d-flex align-items-center gap-2 mb-2">
                <i class="bi bi-info-circle-fill fs-5" style="color: #F59E0B;"></i>
                <h6 class="mb-0 fw-bold">Actualización de disponibilidad en tu carrito</h6>
            </div>
            <ul class="mb-0 small ps-4">
                @foreach($warnings as $warn)
                    <li>{{ $warn }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold mb-1" style="color: #172554;">Mi Carrito de Compras</h2>
            <p class="text-muted mb-0">Revisa tus artículos seleccionados antes de confirmar el pedido</p>
        </div>

        <a href="{{ route('dashboard') }}" class="btn btn-sf-secondary d-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i>
            <span>Seguir comprando</span>
        </a>
    </div>

    @if(empty($cart) || count($cart) === 0)
        <!-- Estado Vacío -->
        <div class="card sf-card border-0 shadow-sm rounded-4 p-5 text-center my-4" style="background-color: #FFFFFF; border: 1px solid #E2E8F0;">
            <div class="mb-3">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background-color: #FFF0EB;">
                    <i class="bi bi-cart-x fs-1" style="color: #FF6B35;"></i>
                </div>
            </div>
            <h3 class="fw-bold" style="color: #172554;">Tu carrito está vacío</h3>
            <p class="text-muted mx-auto mb-4" style="max-width: 450px;">
                Aún no has añadido ningún producto delicioso a tu pedido. Explora nuestro catálogo y aprovecha el despacho rápido.
            </p>
            <div>
                <a href="{{ route('dashboard') }}" class="btn btn-sf-primary px-4 py-2">
                    <i class="bi bi-grid me-2"></i> Explorar Catálogo
                </a>
            </div>
        </div>
    @else
        <div class="row g-4">

            <!-- Lista de Productos en el Carrito -->
            <div class="col-lg-8">
                <div class="card sf-card border-0 shadow-sm rounded-4 overflow-hidden" style="background-color: #FFFFFF; border: 1px solid #E2E8F0;">
                    <div class="card-header text-white py-3 px-4 d-flex justify-content-between align-items-center" style="background-color: #172554;">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-bag-check-fill" style="color: #FFB703;"></i>
                            <h5 class="mb-0 fw-bold fs-6">Productos seleccionados ({{ $totalArticulos }})</h5>
                        </div>

                        <!-- Botón Vaciar Carrito -->
                        <form action="{{ route('carrito.vaciar') }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas vaciar todo el carrito?');">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-light text-white-50 border-0" onmouseover="this.style.color='#EF4444'" onmouseout="this.style.color='rgba(255,255,255,0.5)'" title="Vaciar todo el carrito">
                                <i class="bi bi-trash3 me-1"></i> Vaciar Carrito
                            </button>
                        </form>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light text-muted small text-uppercase">
                                    <tr>
                                        <th class="ps-4" style="min-width: 240px;">Producto</th>
                                        <th class="text-center" style="min-width: 100px;">Precio Unit.</th>
                                        <th class="text-center" style="min-width: 140px;">Cantidad</th>
                                        <th class="text-end" style="min-width: 110px;">Subtotal</th>
                                        <th class="text-center pe-4" style="width: 50px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart as $id => $item)
                                        <tr class="border-bottom border-light">
                                            <!-- Imagen y Nombre -->
                                            <td class="ps-4 py-3">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div style="width: 60px; height: 60px; border-radius: 10px; overflow: hidden; border: 1px solid #E2E8F0; background: #F8FAFC; flex-shrink: 0;">
                                                        <img src="{{ $item['imagen_url'] }}" alt="{{ $item['nombre'] }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                    </div>
                                                    <div>
                                                        <h6 class="fw-bold text-dark mb-0">{{ $item['nombre'] }}</h6>
                                                        <span class="small text-muted d-block">
                                                            <i class="bi bi-shop me-1" style="color: #FF6B35;"></i> {{ $item['empresa_nombre'] }}
                                                        </span>
                                                        <span class="small text-secondary" style="font-size: 0.72rem;">
                                                            Stock disp: {{ $item['stock'] }} unid.
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Precio Unitario -->
                                            <td class="text-center py-3">
                                                <span class="fw-semibold text-dark">
                                                    ${{ number_format($item['precio'], 2) }}
                                                </span>
                                            </td>

                                            <!-- Controles de Cantidad -->
                                            <td class="text-center py-3">
                                                <div class="d-inline-flex align-items-center rounded-3 border p-1" style="background-color: #F8FAFC; border-color: #E2E8F0 !important;">
                                                    <!-- Decrementar -->
                                                    <form action="{{ route('carrito.decrementar', $id) }}" method="POST" class="m-0">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-light border-0 px-2 py-1 text-dark" title="Disminuir">
                                                            <i class="bi bi-dash"></i>
                                                        </button>
                                                    </form>

                                                    <!-- Cantidad Actual -->
                                                    <span class="fw-bold px-3 text-dark fs-6">{{ $item['cantidad'] }}</span>

                                                    <!-- Incrementar -->
                                                    <form action="{{ route('carrito.incrementar', $id) }}" method="POST" class="m-0">
                                                        @csrf
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-light border-0 px-2 py-1 text-dark {{ $item['cantidad'] >= $item['stock'] ? 'opacity-50' : '' }}" 
                                                                {{ $item['cantidad'] >= $item['stock'] ? 'disabled' : '' }}
                                                                title="{{ $item['cantidad'] >= $item['stock'] ? 'Stock máximo alcanzado' : 'Aumentar' }}">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                                @if($item['cantidad'] >= $item['stock'])
                                                    <div class="small text-danger fw-semibold mt-1" style="font-size: 0.68rem;">
                                                        Máximo disponible
                                                    </div>
                                                @endif
                                            </td>

                                            <!-- Subtotal -->
                                            <td class="text-end py-3">
                                                <span class="fw-bold fs-6" style="color: #FF6B35;">
                                                    ${{ number_format($item['precio'] * $item['cantidad'], 2) }}
                                                </span>
                                            </td>

                                            <!-- Eliminar Producto -->
                                            <td class="text-center pe-4 py-3">
                                                <form action="{{ route('carrito.eliminar', $id) }}" method="POST" class="m-0" onsubmit="return confirm('¿Quitar este producto del carrito?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm text-danger border-0 p-1" title="Eliminar producto">
                                                        <i class="bi bi-trash3 fs-6"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resumen de Compra -->
            <div class="col-lg-4">
                <div class="card sf-card border-0 shadow-sm rounded-4 overflow-hidden" style="background-color: #FFFFFF; border: 1px solid #E2E8F0;">
                    <div class="card-header text-white py-3 px-4" style="background-color: #172554;">
                        <h5 class="mb-0 fw-bold fs-6 d-flex align-items-center gap-2">
                            <i class="bi bi-receipt" style="color: #FFB703;"></i>
                            <span>Resumen del Pedido</span>
                        </h5>
                    </div>

                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Total Artículos</span>
                            <span class="fw-semibold text-dark">{{ $totalArticulos }} unidades</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Subtotal</span>
                            <span class="fw-semibold text-dark">${{ number_format($total, 2) }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-3 pb-3 border-bottom border-light">
                            <span class="text-muted small">Costo de Envío SuperFast</span>
                            <span class="badge bg-success-subtle text-success border border-success-subtle">¡Gratis!</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="fw-bold fs-5" style="color: #172554;">Total a Pagar</span>
                            <span class="fw-bolder fs-3" style="color: #FF6B35;">${{ number_format($total, 2) }}</span>
                        </div>

                        <!-- Botón Confirmar Orden -->
                        <button type="button" class="btn btn-sf-primary w-100 py-3 d-flex align-items-center justify-content-center gap-2 shadow" data-bs-toggle="modal" data-bs-target="#modalConfirmarPedido">
                            <i class="bi bi-credit-card-2-front fs-5"></i>
                            <span class="fw-bold">Proceder al Pago</span>
                        </button>

                        <!-- Sellos de Confianza y Calidad -->
                        <div class="mt-4 pt-3 border-top border-light">
                            <div class="d-flex align-items-center gap-2 text-muted small mb-2">
                                <i class="bi bi-shield-check text-success fs-5"></i>
                                <span>Compra protegida y garantizada</span>
                            </div>
                            <div class="d-flex align-items-center gap-2 text-muted small mb-2">
                                <i class="bi bi-lightning-charge text-warning fs-5"></i>
                                <span>Entrega exprés en minutos</span>
                            </div>
                            <div class="d-flex align-items-center gap-2 text-muted small">
                                <i class="bi bi-headset text-primary fs-5"></i>
                                <span>Soporte al cliente SuperFast 24/7</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Modal de Confirmación / Checkout -->
        <div class="modal fade" id="modalConfirmarPedido" tabindex="-1" aria-labelledby="modalConfirmarPedidoLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 border-0 shadow">
                    <div class="modal-header text-white" style="background-color: #172554;">
                        <h5 class="modal-title fw-bold" id="modalConfirmarPedidoLabel">
                            <i class="bi bi-bag-check-fill me-2" style="color: #FFB703;"></i> Confirmar Pedido
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 text-center">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px; background-color: #FFF0EB;">
                            <i class="bi bi-box2-heart fs-1" style="color: #FF6B35;"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">¡Tu orden está lista para prepararse!</h4>
                        <p class="text-muted small mb-4">
                            Se enviará la solicitud de despacho a los comercios seleccionados con un total de <strong>${{ number_format($total, 2) }}</strong> ({{ $totalArticulos }} artículos).
                        </p>
                        <div class="p-3 rounded-3 mb-4 text-start small" style="background-color: #F8FAFC; border: 1px solid #E2E8F0;">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Cliente:</span>
                                <span class="fw-semibold text-dark">{{ auth()->user()->name }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Email:</span>
                                <span class="fw-semibold text-dark">{{ auth()->user()->email }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Método:</span>
                                <span class="badge bg-success-subtle text-success">Contraentrega / Pago Móvil</span>
                            </div>
                        </div>
                        <form action="{{ route('carrito.vaciar') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sf-primary w-100 py-2 fw-bold mb-2">
                                <i class="bi bi-check2-circle me-1"></i> Aceptar y Realizar Pedido
                            </button>
                        </form>
                        <button type="button" class="btn btn-light text-muted w-100 py-2 small" data-bs-dismiss="modal">
                            Revisar más productos
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
