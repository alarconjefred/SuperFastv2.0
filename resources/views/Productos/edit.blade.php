@extends('layouts.dashboardcliente')

@section('title', 'Editar Producto - SuperFast')

@section('content')
    <div class="container py-4" style="max-width: 680px;">
        <div class="card sf-card border-0 shadow-sm rounded-4 overflow-hidden" style="background-color: #FFFFFF; border: 1px solid #E2E8F0;">
            <div class="card-header text-white py-3 px-4 d-flex align-items-center gap-2" style="background-color: #172554;">
                <i class="bi bi-pencil-square" style="color: #FFB703;"></i>
                <h4 class="mb-0 fw-bold fs-5">Editar Producto: <span class="fw-normal text-white-50">{{ $producto->nombre }}</span></h4>
            </div>

            <div class="card-body p-4 p-sm-5">

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 py-2 px-3 mb-4" role="alert" style="background-color: #FEF2F2; color: #991B1B;">
                        <ul class="mb-0 small ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('productos.update', [$empresa, $producto]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Nombre del Producto -->
                    <div class="mb-3">
                        <label for="nombre" class="form-label small fw-semibold" style="color: #1F2937;">Nombre del Producto *</label>
                        <input type="text" 
                               id="nombre"
                               name="nombre" 
                               class="form-control @error('nombre') is-invalid @enderror" 
                               value="{{ old('nombre', $producto->nombre) }}" 
                               required>
                    </div>

                    <!-- Descripción -->
                    <div class="mb-3">
                        <label for="descripcion" class="form-label small fw-semibold" style="color: #1F2937;">Descripción del Producto</label>
                        <textarea id="descripcion" 
                                  name="descripcion" 
                                  rows="3" 
                                  class="form-control @error('descripcion') is-invalid @enderror" 
                                  placeholder="Ingredientes, características, tamaño o detalles...">{{ old('descripcion', $producto->descripcion) }}</textarea>
                    </div>

                    <!-- Fila Precio y Stock -->
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label for="precio" class="form-label small fw-semibold" style="color: #1F2937;">Precio ($) *</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted" style="border-color: #E2E8F0;">$</span>
                                <input type="number" 
                                       step="0.01" 
                                       id="precio"
                                       name="precio" 
                                       class="form-control border-start-0 @error('precio') is-invalid @enderror" 
                                       value="{{ old('precio', $producto->precio) }}" 
                                       required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="stock" class="form-label small fw-semibold" style="color: #1F2937;">Stock Disponible (Unidades) *</label>
                            <input type="number" 
                                   id="stock"
                                   name="stock" 
                                   min="0"
                                   class="form-control @error('stock') is-invalid @enderror" 
                                   value="{{ old('stock', $producto->stock) }}" 
                                   required>
                        </div>
                    </div>

                    <!-- Interruptor Disponible -->
                    <div class="form-check form-switch mb-4 p-2 rounded-3" style="background-color: #F8FAFC; border: 1px solid #E2E8F0; padding-left: 2.5rem !important;">
                        <input class="form-check-input" 
                               type="checkbox" 
                               role="switch" 
                               id="disponible" 
                               name="disponible" 
                               value="1" 
                               {{ old('disponible', $producto->disponible) ? 'checked' : '' }}>
                        <label class="form-check-label small fw-semibold text-dark ms-1" for="disponible">
                            Disponible en el catálogo (los clientes pueden ver y pedir este producto)
                        </label>
                    </div>

                    <!-- Imagen Actual y Modificación -->
                    <div class="mb-4 p-3 rounded-3" style="background-color: #F8FAFC; border: 1px solid #E2E8F0;">
                        <label class="form-label small fw-semibold text-dark d-block mb-2">Imagen del Producto</label>
                        
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div style="width: 80px; height: 80px; border-radius: 8px; overflow: hidden; border: 1px solid #CBD5E1; background: #FFF; flex-shrink: 0;">
                                <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div>
                                @if($producto->imagen)
                                    <div class="badge bg-success-subtle text-success border border-success-subtle mb-1">Imagen personalizada</div>
                                    <div class="form-check mt-1">
                                        <input class="form-check-input" type="checkbox" name="eliminar_imagen" value="1" id="eliminar_imagen" {{ old('eliminar_imagen') ? 'checked' : '' }}>
                                        <label class="form-check-label small text-danger fw-semibold" for="eliminar_imagen">
                                            <i class="bi bi-trash3 me-1"></i> Eliminar imagen actual (usar imagen predeterminada)
                                        </label>
                                    </div>
                                @else
                                    <div class="badge bg-secondary-subtle text-secondary border mb-1">Imagen por defecto</div>
                                    <p class="small text-muted mb-0">Sube una imagen para hacer tu producto más atractivo en el catálogo.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Selector de Nueva Imagen -->
                        <div>
                            <label for="imagenInput" class="form-label small text-muted">
                                {{ $producto->imagen ? 'Subir nueva imagen para reemplazar la actual:' : 'Seleccionar imagen:' }}
                            </label>
                            <input type="file" 
                                   name="imagen" 
                                   id="imagenInput" 
                                   accept="image/jpeg,image/png,image/jpg,image/webp" 
                                   class="form-control @error('imagen') is-invalid @enderror">
                            <div class="form-text small">Formatos permitidos: JPG, PNG, WEBP. Tamaño máximo: 3 MB.</div>

                            <!-- Contenedor de Previsualización en Vivo de la nueva imagen -->
                            <div id="previewContainer" class="mt-3 d-none position-relative rounded-3 overflow-hidden border p-1" style="max-height: 160px; background-color: #FFFFFF;">
                                <div class="small fw-semibold text-muted px-2 py-1">Nueva imagen a guardar:</div>
                                <img id="imagePreview" src="#" alt="Previsualización" style="width: 100%; height: 130px; object-fit: cover; border-radius: 6px;">
                                <button type="button" id="btnRemovePreview" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 rounded-circle" style="padding: 2px 7px;" title="Cancelar selección">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top border-light gap-2">
                        <a href="{{ route('empresa.index') }}" class="btn btn-sf-secondary d-flex align-items-center gap-1">
                            <i class="bi bi-arrow-left"></i>
                            <span>Volver</span>
                        </a>

                        <button type="submit" class="btn btn-sf-primary d-flex align-items-center gap-2 px-4">
                            <i class="bi bi-check-lg"></i>
                            <span>Guardar Cambios</span>
                        </button>
                    </div>
                </form>
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
