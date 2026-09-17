@extends('layouts.dashboardcliente')

@section('title', 'Panel de Empresa - SuperFast')

@section('content')
    <div class="container-fluid">

        <!-- Cabecera de Empresa -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3 p-4 rounded-4 shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E2E8F0;">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm text-white" style="width: 60px; height: 60px; background-color: #172554;">
                    <i class="bi bi-shop fs-3" style="color: #FFB703;"></i>
                </div>
                <div>
                    <div class="d-flex align-items-center gap-2">
                        <h2 class="fw-bold mb-0" style="color: #172554;">{{ $empresa->nombre }}</h2>
                        <span class="badge px-2 py-1 rounded-pill" style="background-color: #FFF0EB; color: #FF6B35; font-size: 0.75rem; font-weight: 600;">
                            Comercio Activo
                        </span>
                    </div>
                    <p class="text-muted mb-0 small mt-1">
                        <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $empresa->direccion ?? 'Dirección registrada en SuperFast' }}
                    </p>
                </div>
            </div>

            <div class="d-flex gap-2">
                <span class="badge px-3 py-2 rounded-pill d-flex align-items-center gap-1" style="background-color: #172554; color: #FFFFFF;">
                    <i class="bi bi-box-seam" style="color: #FFB703;"></i>
                    <span>{{ $productos->count() }} Productos</span>
                </span>
            </div>
        </div>

        <!-- Mensajes de Éxito / Error -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 d-flex align-items-center gap-2 py-3 px-4 mb-4 shadow-sm" role="alert" style="background-color: #ECFDF5; color: #065F46;">
                <i class="bi bi-check-circle-fill fs-5" style="color: #10B981;"></i>
                <span class="fw-medium">{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">

            <!-- Formulario para Agregar Productos -->
            <div class="col-lg-4">
                <div class="card sf-card border-0 shadow-sm rounded-4 overflow-hidden" style="background-color: #FFFFFF; border: 1px solid #E2E8F0;">
                    <div class="card-header text-white py-3 px-4 d-flex align-items-center gap-2" style="background-color: #172554;">
                        <i class="bi bi-plus-circle-fill" style="color: #FF6B35;"></i>
                        <h5 class="mb-0 fw-bold fs-6">Agregar Nuevo Producto</h5>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('productos.store', $empresa) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label small fw-semibold" style="color: #1F2937;">Nombre del Producto</label>
                                <input type="text" 
                                       name="nombre" 
                                       class="form-control" 
                                       placeholder="Ej: Pizza Cuatro Quesos" 
                                       required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-semibold" style="color: #1F2937;">Precio ($ USD / Local)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted" style="border-color: #E2E8F0;">$</span>
                                    <input type="number" 
                                           step="0.01" 
                                           name="precio" 
                                           class="form-control border-start-0" 
                                           placeholder="0.00" 
                                           required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-sf-primary w-100 py-2 d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-check2-circle fs-5"></i>
                                <span>Guardar Producto</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Lista de Productos -->
            <div class="col-lg-8">
                <div class="card sf-card border-0 shadow-sm rounded-4 overflow-hidden" style="background-color: #FFFFFF; border: 1px solid #E2E8F0;">
                    <div class="card-header text-white py-3 px-4 d-flex justify-content-between align-items-center" style="background-color: #172554;">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-card-list" style="color: #FFB703;"></i>
                            <h5 class="mb-0 fw-bold fs-6">Catálogo de Productos</h5>
                        </div>
                        <span class="badge" style="background-color: rgba(255, 183, 3, 0.2); color: #FFB703;">
                            En inventario
                        </span>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead style="background-color: #F8FAFC; border-bottom: 2px solid #E2E8F0;">
                                    <tr>
                                        <th class="ps-4 py-3 text-secondary text-uppercase small fw-bold" style="font-size: 0.75rem;">Producto</th>
                                        <th class="py-3 text-center text-secondary text-uppercase small fw-bold" style="font-size: 0.75rem;">Precio</th>
                                        <th class="pe-4 py-3 text-end text-secondary text-uppercase small fw-bold" style="font-size: 0.75rem;">Acciones</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($productos as $producto)
                                        <tr style="border-bottom: 1px solid #F1F5F9; transition: background-color 0.15s;" onmouseover="this.style.backgroundColor='#F8FAFC'" onmouseout="this.style.backgroundColor='transparent'">
                                            <td class="ps-4 py-3">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 38px; height: 38px; background-color: #FFF0EB; color: #FF6B35 !important;">
                                                        <i class="bi bi-box-seam"></i>
                                                    </div>
                                                    <div>
                                                        <span class="fw-bold text-dark d-block">{{ $producto->nombre }}</span>
                                                        <small class="text-muted">Disponible para órdenes</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-3 text-center">
                                                <span class="fw-bold fs-6" style="color: #FF6B35;">
                                                    ${{ number_format($producto->precio, 2) }}
                                                </span>
                                            </td>
                                            <td class="pe-4 py-3 text-end">
                                                <div class="d-inline-flex gap-2">
                                                    <!-- Editar -->
                                                    <a href="{{ route('productos.edit', [$empresa, $producto]) }}"
                                                       class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1"
                                                       title="Editar Producto"
                                                       style="border-color: #CBD5E1;"
                                                       onmouseover="this.style.backgroundColor='#172554'; this.style.color='#FFFFFF'"
                                                       onmouseout="this.style.backgroundColor='transparent'; this.style.color='#475569'">
                                                        <i class="bi bi-pencil-square"></i>
                                                        <span class="d-none d-sm-inline">Editar</span>
                                                    </a>

                                                    <!-- Eliminar -->
                                                    <form action="{{ route('productos.destroy', [$empresa, $producto]) }}"
                                                          method="POST" 
                                                          style="display:inline">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1"
                                                                onclick="return confirm('¿Seguro que deseas eliminar este producto?')"
                                                                title="Eliminar">
                                                            <i class="bi bi-trash3"></i>
                                                            <span class="d-none d-sm-inline">Eliminar</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-5">
                                                <i class="bi bi-box2 fs-1 text-muted d-block mb-2"></i>
                                                <p class="text-muted mb-0">No tienes productos registrados en tu catálogo.</p>
                                                <small class="text-muted">Utiliza el formulario de la izquierda para agregar tu primer producto.</small>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
