@extends('layouts.dashboardcliente')

@section('content')
    <div class="container mt-5">

        <!-- Empresa -->
        <div class="mb-4">
            <h1 class="fw-bold">{{ $empresa->nombre }}</h1>
            <p class="text-muted">{{ $empresa->direccion }}</p>
        </div>

        <!-- Mensaje -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">

            <!-- formulario agregar productos -->
            <div class="col-md-4">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-primary text-white rounded-top-4">
                        <h5 class="mb-0">➕ Agregar Producto</h5>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('productos.store', $empresa) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" name="nombre" class="form-control rounded-3" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Precio</label>
                                <input type="number" step="0.01" name="precio" class="form-control rounded-3" required>
                            </div>

                            <button class="btn btn-success w-100">
                                Guardar Producto
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- lista de productos -->
            <div class="col-md-8">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-dark text-white rounded-top-4">
                        <h5 class="mb-0">📦 Productos</h5>
                    </div>

                    <div class="card-body p-0">
                        <table class="table mb-0 text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($productos as $producto)
                                    <tr>
                                        <td>{{ $producto->nombre }}</td>
                                        <td>${{ number_format($producto->precio, 2) }}</td>
                                        <td>
                                            <!-- Editar -->
                                            <a href="{{ route('productos.edit', [$empresa, $producto]) }}"
                                                class="btn btn-warning btn-sm">
                                                ✏️
                                            </a>

                                            <!-- Eliminar -->
                                            <form action="{{ route('productos.destroy', [$empresa, $producto]) }}"
                                                method="POST" style="display:inline">
                                                @csrf
                                                @method('DELETE')

                                                <button class="btn btn-danger btn-sm"
                                                    onclick="return confirm('¿Eliminar producto?')">
                                                    🗑️
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">No hay productos</td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
