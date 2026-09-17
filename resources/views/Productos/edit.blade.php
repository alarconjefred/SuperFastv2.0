@extends('layouts.dashboardcliente')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-dark text-white rounded-top-4">
                <h4 class="mb-0">✏️ Editar Producto</h4>
            </div>

            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('productos.update', [$empresa, $producto]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nombre -->
                    <div class="mb-3">
                        <label class="form-label">Nombre del producto</label>
                        <input type="text" name="nombre" class="form-control rounded-3" value="{{ $producto->nombre }}"
                            required>
                    </div>

                    <!-- Precio -->
                    <div class="mb-3">
                        <label class="form-label">Precio</label>
                        <input type="number" step="0.01" name="precio" class="form-control rounded-3"
                            value="{{ $producto->precio }}" required>
                    </div>

                    <!-- Botones -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('empresa.index') }}" class="btn btn-secondary">
                            ⬅ Volver
                        </a>

                        <button type="submit" class="btn btn-success">
                            💾 Actualizar Producto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
