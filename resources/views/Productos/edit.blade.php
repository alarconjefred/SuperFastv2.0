@extends('layouts.dashboardcliente')

@section('title', 'Editar Producto - SuperFast')

@section('content')
    <div class="container py-4" style="max-width: 650px;">
        <div class="card sf-card border-0 shadow-sm rounded-4 overflow-hidden" style="background-color: #FFFFFF; border: 1px solid #E2E8F0;">
            <div class="card-header text-white py-3 px-4 d-flex align-items-center gap-2" style="background-color: #172554;">
                <i class="bi bi-pencil-square" style="color: #FFB703;"></i>
                <h4 class="mb-0 fw-bold fs-5">Editar Producto</h4>
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

                <form action="{{ route('productos.update', [$empresa, $producto]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nombre del Producto -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold" style="color: #1F2937;">Nombre del Producto</label>
                        <input type="text" 
                               name="nombre" 
                               class="form-control" 
                               value="{{ old('nombre', $producto->nombre) }}" 
                               required>
                    </div>

                    <!-- Precio -->
                    <div class="mb-4">
                        <label class="form-label small fw-semibold" style="color: #1F2937;">Precio ($ USD / Local)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted" style="border-color: #E2E8F0;">$</span>
                            <input type="number" 
                                   step="0.01" 
                                   name="precio" 
                                   class="form-control border-start-0" 
                                   value="{{ old('precio', $producto->precio) }}" 
                                   required>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top border-light gap-2">
                        <a href="{{ route('empresa.index') }}" class="btn btn-sf-secondary d-flex align-items-center gap-1">
                            <i class="bi bi-arrow-left"></i>
                            <span>Volver</span>
                        </a>

                        <button type="submit" class="btn btn-sf-primary d-flex align-items-center gap-2">
                            <i class="bi bi-check-lg"></i>
                            <span>Actualizar Producto</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
