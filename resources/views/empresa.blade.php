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
                    <span>{{ $productos->count() }} Productos en catálogo</span>
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

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 py-3 px-4 mb-4 shadow-sm" role="alert" style="background-color: #FEF2F2; color: #991B1B;">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <i class="bi bi-exclamation-triangle-fill fs-5" style="color: #EF4444;"></i>
                    <strong class="small">Revisa los campos del formulario:</strong>
                </div>
                <ul class="mb-0 small ps-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">

            <!-- Formulario para Agregar Productos -->
            <div class="col-lg-5 col-xl-4">
                <div class="card sf-card border-0 shadow-sm rounded-4 overflow-hidden" style="background-color: #FFFFFF; border: 1px solid #E2E8F0;">
                    <div class="card-header text-white py-3 px-4 d-flex align-items-center gap-2" style="background-color: #172554;">
                        <i class="bi bi-plus-circle-fill" style="color: #FF6B35;"></i>
                        <h5 class="mb-0 fw-bold fs-6">Agregar Nuevo Producto</h5>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('productos.store', $empresa) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Nombre del Producto -->
                            <div class="mb-3">
                                <label for="nombre" class="form-label small fw-semibold" style="color: #1F2937;">Nombre del Producto *</label>
                                <input type="text" 
                                       id="nombre"
                                       name="nombre" 
                                       value="{{ old('nombre') }}"
                                       class="form-control @error('nombre') is-invalid @enderror" 
                                       placeholder="Ej: Hamburguesa Doble Queso" 
                                       required>
                            </div>

                            <!-- Descripción -->
                            <div class="mb-3">
                                <label for="descripcion" class="form-label small fw-semibold" style="color: #1F2937;">Descripción</label>
                                <textarea id="descripcion" 
                                          name="descripcion" 
                                          rows="2" 
                                          class="form-control @error('descripcion') is-invalid @enderror" 
                                          placeholder="Ingredientes, porción o detalles del producto...">{{ old('descripcion') }}</textarea>
                            </div>

                            <!-- Fila Precio y Stock -->
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <label for="precio" class="form-label small fw-semibold" style="color: #1F2937;">Precio ($) *</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 text-muted" style="border-color: #E2E8F0;">$</span>
                                        <input type="number" 
                                               step="0.01" 
                                               id="precio"
                                               name="precio" 
                                               value="{{ old('precio') }}"
                                               class="form-control border-start-0 @error('precio') is-invalid @enderror" 
                                               placeholder="0.00" 
                                               required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="stock" class="form-label small fw-semibold" style="color: #1F2937;">Stock (Unid.) *</label>
                                    <input type="number" 
                                           id="stock"
                                           name="stock" 
                                           min="0"
                                           value="{{ old('stock', 10) }}"
                                           class="form-control @error('stock') is-invalid @enderror" 
                                           required>
                                </div>
                            </div>

                            <!-- Interruptor Disponible -->
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" role="switch" id="disponible" name="disponible" value="1" {{ old('disponible', true) ? 'checked' : '' }}>
                                <label class="form-check-label small fw-semibold text-dark" for="disponible">
                                    Disponible para la venta
                                </label>
                            </div>

                            <!-- Subida de Imagen con Previsualización -->
                            <div class="mb-4">
                                <label for="imagenInput" class="form-label small fw-semibold" style="color: #1F2937;">
                                    Imagen del Producto (JPG, PNG, WEBP máx 3MB)
                                </label>
                                <input type="file" 
                                       name="imagen" 
                                       id="imagenInput" 
                                       accept="image/jpeg,image/png,image/jpg,image/webp" 
                                       class="form-control @error('imagen') is-invalid @enderror">
                                
                                <!-- Contenedor de Vista Previa Controlada -->
                                <div id="previewContainer" class="mt-2 d-none position-relative rounded-3 overflow-hidden border p-1" style="max-height: 150px; background-color: #F8FAFC;">
                                    <img id="imagePreview" src="#" alt="Previsualización" style="width: 100%; height: 140px; object-fit: cover; border-radius: 6px;">
                                    <button type="button" id="btnRemovePreview" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 rounded-circle" style="padding: 2px 7px;" title="Quitar imagen">
                                        <i class="bi bi-x"></i>
                                    </button>
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

            <!-- Lista de Productos en Catálogo -->
            <div class="col-lg-7 col-xl-8">
                <div class="card sf-card border-0 shadow-sm rounded-4 overflow-hidden" style="background-color: #FFFFFF; border: 1px solid #E2E8F0;">
                    <div class="card-header text-white py-3 px-4 d-flex justify-content-between align-items-center" style="background-color: #172554;">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-card-list" style="color: #FFB703;"></i>
                            <h5 class="mb-0 fw-bold fs-6">Catálogo de Productos</h5>
                        </div>
                        <span class="badge" style="background-color: rgba(255, 183, 3, 0.2); color: #FFB703;">
                            {{ $productos->count() }} registrados
                        </span>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead style="background-color: #F8FAFC; border-bottom: 2px solid #E2E8F0;">
                                    <tr>
                                        <th class="ps-4 py-3 text-secondary text-uppercase small fw-bold" style="font-size: 0.75rem;">Producto</th>
                                        <th class="py-3 text-center text-secondary text-uppercase small fw-bold" style="font-size: 0.75rem;">Stock</th>
                                        <th class="py-3 text-center text-secondary text-uppercase small fw-bold" style="font-size: 0.75rem;">Estado</th>
                                        <th class="py-3 text-center text-secondary text-uppercase small fw-bold" style="font-size: 0.75rem;">Precio</th>
                                        <th class="pe-4 py-3 text-end text-secondary text-uppercase small fw-bold" style="font-size: 0.75rem;">Acciones</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($productos as $producto)
                                        <tr style="border-bottom: 1px solid #F1F5F9; transition: background-color 0.15s;" onmouseover="this.style.backgroundColor='#F8FAFC'" onmouseout="this.style.backgroundColor='transparent'">
                                            <td class="ps-4 py-3">
                                                <div class="d-flex align-items-center gap-3">
                                                    <!-- Miniatura controlada: nunca rompe la tabla -->
                                                    <div class="rounded-3 overflow-hidden border shadow-xs flex-shrink-0" style="width: 52px; height: 52px; background-color: #F1F5F9;">
                                                        <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                    </div>
                                                    <div>
                                                        <span class="fw-bold text-dark d-block">{{ $producto->nombre }}</span>
                                                        <small class="text-muted text-truncate d-block" style="max-width: 220px;">
                                                            {{ $producto->descripcion ?? 'Sin descripción añadida' }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="py-3 text-center">
                                                @if($producto->stock <= 0)
                                                    <span class="badge bg-danger rounded-pill px-2 py-1">
                                                        0 unidades (Agotado)
                                                    </span>
                                                @elseif($producto->stock <= 5)
                                                    <span class="badge bg-warning text-dark rounded-pill px-2 py-1">
                                                        {{ $producto->stock }} unid. (Bajo)
                                                    </span>
                                                @else
                                                    <span class="badge rounded-pill px-2 py-1" style="background-color: #ECFDF5; color: #065F46; border: 1px solid #A7F3D0;">
                                                        {{ $producto->stock }} unid.
                                                    </span>
                                                @endif
                                            </td>

                                            <td class="py-3 text-center">
                                                @if($producto->esta_agotado)
                                                    <span class="badge bg-secondary text-white rounded-pill px-2 py-1">
                                                        {{ !$producto->disponible ? 'Desactivado' : 'Agotado' }}
                                                    </span>
                                                @else
                                                    <span class="badge rounded-pill px-2 py-1" style="background-color: #EFF6FF; color: #1E40AF; border: 1px solid #BFDBFE;">
                                                        Disponible
                                                    </span>
                                                @endif
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
                                                                onclick="return confirm('¿Seguro que deseas eliminar este producto del catálogo?')"
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
                                            <td colspan="5" class="text-center py-5">
                                                <i class="bi bi-box2 fs-1 text-muted d-block mb-2"></i>
                                                <p class="text-muted mb-0 fw-semibold">No tienes productos registrados en tu catálogo.</p>
                                                <small class="text-muted">Utiliza el formulario de la izquierda para agregar tu primer producto con foto, precio y stock.</small>
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

    <!-- Script para Previsualización en Vivo de Imagen -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('imagenInput');
            const preview = document.getElementById('imagePreview');
            const container = document.getElementById('previewContainer');
            const btnRemove = document.getElementById('btnRemovePreview');

            if (input && preview && container && btnRemove) {
                input.addEventListener('change', function () {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            preview.src = e.target.result;
                            container.classList.remove('d-none');
                        };
                        reader.readAsDataURL(file);
                    }
                });

                btnRemove.addEventListener('click', function () {
                    input.value = '';
                    preview.src = '#';
                    container.classList.add('d-none');
                });
            }
        });
    </script>
@endsection
