@extends('layouts.dashboardcliente')

@section('title', 'Panel Empresa - SuperFast')

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

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 rounded-4 shadow-sm py-3 px-4 mb-4" role="alert" style="background-color: #FEF2F2; color: #991B1B;">
            <div class="d-flex align-items-center gap-2 mb-2">
                <i class="bi bi-exclamation-octagon-fill fs-5" style="color: #EF4444;"></i>
                <h6 class="mb-0 fw-bold">Por favor corrige los siguientes errores:</h6>
            </div>
            <ul class="mb-0 small ps-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- BANNER DE ENCABEZADO Y RESUMEN KPI (STITCH MERCHANT SPEC) -->
    <div class="card sf-card border-0 shadow-sm rounded-4 p-4 mb-4" style="background-color: #FFFFFF; border: 1px solid #E2E8F0;">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                    <span class="badge px-3 py-1 rounded-pill" style="background-color: #FFF0EB; color: #FF6B35; font-size: 0.75rem; font-weight: 700;">
                        <i class="bi bi-shop me-1"></i> {{ $empresa->nombre }}
                    </span>
                    <span class="badge bg-light text-dark border rounded-pill px-3 py-1" style="font-size: 0.75rem;">
                        <span class="sf-pulse-dot me-1" style="background-color: #10B981; width: 6px; height: 6px;"></span> Sincronizado en tiempo real
                    </span>
                </div>
                <h1 class="fw-bold mb-1" style="color: #172554; font-size: clamp(1.4rem, 2.5vw, 1.85rem);">
                    Catálogo y Gestión de Productos
                </h1>
                <p class="text-muted small mb-0">
                    Administra tu inventario, sube nuevos platillos con fotos de alta resolución y controla el stock para los repartidores.
                </p>
            </div>

            <!-- Resumen de Métricas Rápidas (KPIs) -->
            <div class="d-flex gap-2 flex-wrap w-100 w-lg-auto justify-content-start justify-content-lg-end">
                <div class="px-3 py-2 rounded-3 border bg-light text-center flex-fill flex-lg-grow-0">
                    <div class="text-muted small" style="font-size: 0.72rem; text-transform: uppercase; font-weight: 700;">Total Ítems</div>
                    <div class="fw-bold fs-5" style="color: #172554;">{{ $productos->count() }}</div>
                </div>
                <div class="px-3 py-2 rounded-3 border bg-light text-center flex-fill flex-lg-grow-0">
                    <div class="text-muted small" style="font-size: 0.72rem; text-transform: uppercase; font-weight: 700;">Disponibles</div>
                    <div class="fw-bold fs-5 text-success">{{ $productos->where('disponible', true)->where('stock', '>', 0)->count() }}</div>
                </div>
                <div class="px-3 py-2 rounded-3 border bg-light text-center flex-fill flex-lg-grow-0">
                    <div class="text-muted small" style="font-size: 0.72rem; text-transform: uppercase; font-weight: 700;">Agotados</div>
                    <div class="fw-bold fs-5 text-danger">{{ $productos->where('stock', '<=', 0)->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECCIÓN PRINCIPAL: FORMULARIO Y TABLA DE CATÁLOGO -->
    <div class="row g-4">

        <!-- Formulario de Creación de Producto (Stitch Upload Module) -->
        <div class="col-lg-5 col-xl-4">
            <div class="card sf-card border-0 shadow-sm rounded-4 overflow-hidden" style="background-color: #FFFFFF; border: 1px solid #E2E8F0;">
                <div class="card-header text-white py-3 px-4 d-flex align-items-center gap-2" style="background-color: #172554;">
                    <i class="bi bi-plus-circle-fill" style="color: #FFB703;"></i>
                    <h5 class="mb-0 fw-bold fs-6">Subir Nuevo Producto</h5>
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
                                   placeholder="Ej: Super Doble Bacon Cheddar" 
                                   required>
                        </div>

                        <!-- Descripción -->
                        <div class="mb-3">
                            <label for="descripcion" class="form-label small fw-semibold" style="color: #1F2937;">Descripción del Producto</label>
                            <textarea id="descripcion" 
                                      name="descripcion" 
                                      rows="2" 
                                      class="form-control @error('descripcion') is-invalid @enderror" 
                                      placeholder="Ingredientes, características o detalles...">{{ old('descripcion') }}</textarea>
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
                        <div class="form-check form-switch mb-3 p-2 rounded-3" style="background-color: #F8FAFC; border: 1px solid #E2E8F0; padding-left: 2.5rem !important;">
                            <input class="form-check-input" type="checkbox" role="switch" id="disponible" name="disponible" value="1" {{ old('disponible', true) ? 'checked' : '' }}>
                            <label class="form-check-label small fw-semibold text-dark" for="disponible">
                                Disponible para entrega inmediata
                            </label>
                        </div>

                        <!-- Dropzone de Imagen con Previsualización (Stitch Media Pattern) -->
                        <div class="mb-4">
                            <label class="form-label small fw-semibold" style="color: #1F2937;">
                                Fotografía del Producto (JPG, PNG, WEBP máx 3MB)
                            </label>
                            
                            <div class="sf-dropzone p-3 text-center position-relative" onclick="document.getElementById('imagenInput').click();">
                                <i class="bi bi-cloud-arrow-up fs-2" style="color: #FF6B35;"></i>
                                <div class="small fw-bold text-dark mt-1">Haz clic para seleccionar o arrastra una imagen</div>
                                <div class="text-muted" style="font-size: 0.72rem;">Se normalizará a 190px de alto sin deformación</div>
                                <input type="file" 
                                       name="imagen" 
                                       id="imagenInput" 
                                       accept="image/jpeg,image/png,image/jpg,image/webp" 
                                       class="d-none"
                                       onchange="handleImagePreview(this)">
                            </div>
                            
                            <!-- Contenedor de Vista Previa Controlada -->
                            <div id="previewContainer" class="mt-2 d-none position-relative rounded-3 overflow-hidden border p-1" style="max-height: 160px; background-color: #F8FAFC;">
                                <img id="imagePreview" src="#" alt="Previsualización" style="width: 100%; height: 140px; object-fit: cover; border-radius: 8px;">
                                <button type="button" id="btnRemovePreview" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 rounded-circle" style="padding: 2px 7px;" title="Quitar imagen">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-sf-primary w-100 py-2.5 d-flex align-items-center justify-content-center gap-2 shadow-xs">
                            <i class="bi bi-check2-circle fs-5"></i>
                            <span>Publicar en Catálogo</span>
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
                        <h5 class="mb-0 fw-bold fs-6">Catálogo Activo de la Tienda</h5>
                    </div>
                    <span class="badge rounded-pill" style="background-color: rgba(255, 183, 3, 0.2); color: #FFB703;">
                        {{ $productos->count() }} ítems
                    </span>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead style="background-color: #F8FAFC; border-bottom: 2px solid #E2E8F0;">
                                <tr>
                                    <th class="ps-4 py-3 text-secondary text-uppercase small fw-bold" style="font-size: 0.72rem; min-width: 200px;">Producto</th>
                                    <th class="py-3 text-center text-secondary text-uppercase small fw-bold" style="font-size: 0.72rem;">Stock</th>
                                    <th class="py-3 text-center text-secondary text-uppercase small fw-bold" style="font-size: 0.72rem;">Estado</th>
                                    <th class="py-3 text-center text-secondary text-uppercase small fw-bold" style="font-size: 0.72rem;">Precio</th>
                                    <th class="pe-4 py-3 text-end text-secondary text-uppercase small fw-bold" style="font-size: 0.72rem; min-width: 110px;">Acciones</th>
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
                                                <div class="min-w-0">
                                                    <span class="fw-bold text-dark d-block text-truncate" style="max-width: 210px;">{{ $producto->nombre }}</span>
                                                    <small class="text-muted text-truncate d-block" style="max-width: 210px;">
                                                        {{ $producto->descripcion ?? 'Sin descripción añadida' }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="py-3 text-center">
                                            @if($producto->stock <= 0)
                                                <span class="badge bg-danger rounded-pill px-2 py-1">
                                                    0 unid. (Agotado)
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
                                                    {{ !$producto->disponible ? 'Pausado' : 'Agotado' }}
                                                </span>
                                            @else
                                                <span class="badge rounded-pill px-2 py-1" style="background-color: #EFF6FF; color: #1E40AF; border: 1px solid #BFDBFE;">
                                                    Activo
                                                </span>
                                            @endif
                                        </td>

                                        <td class="py-3 text-center">
                                            <span class="fw-bold fs-6" style="color: #FF6B35;">
                                                ${{ number_format($producto->precio, 2) }}
                                            </span>
                                        </td>

                                        <td class="pe-4 py-3 text-end">
                                            <div class="d-inline-flex gap-1">
                                                <!-- Editar -->
                                                <a href="{{ route('productos.edit', [$empresa, $producto]) }}"
                                                   class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1"
                                                   title="Editar Producto"
                                                   style="border-color: #CBD5E1;">
                                                    <i class="bi bi-pencil-square"></i>
                                                    <span class="d-none d-sm-inline">Editar</span>
                                                </a>

                                                <!-- Eliminar -->
                                                <form action="{{ route('productos.destroy', [$empresa, $producto]) }}"
                                                      method="POST" 
                                                      style="display:inline"
                                                      onsubmit="return confirm('¿Seguro que deseas eliminar este producto del catálogo?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-outline-danger d-flex align-items-center"
                                                            title="Eliminar">
                                                        <i class="bi bi-trash3"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="bi bi-box-seam fs-1 d-block mb-2 text-warning"></i>
                                                <h6 class="fw-bold text-dark">Aún no has registrado ningún producto</h6>
                                                <p class="small text-muted mb-0">Usa el formulario de la izquierda para publicar tu primer plato o artículo.</p>
                                            </div>
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

    <!-- Script de Previsualización en Vivo de Imagen -->
    <script>
        function handleImagePreview(input) {
            const preview = document.getElementById('imagePreview');
            const container = document.getElementById('previewContainer');
            const btnRemove = document.getElementById('btnRemovePreview');

            if (input && input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    container.classList.remove('d-none');
                };
                reader.readAsDataURL(input.files[0]);
            }

            if (btnRemove) {
                btnRemove.onclick = function (e) {
                    e.stopPropagation();
                    input.value = '';
                    preview.src = '#';
                    container.classList.add('d-none');
                };
            }
        }
    </script>

@endsection
