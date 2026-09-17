@extends('layouts.dashboardcliente')

@section('title', 'Dashboard')

@section('content')
    <h4 class="mb-4">Restaurantes cerca de ti</h4>

    <div class="row">

        @for ($i = 0; $i < 6; $i++)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0">

                    <img src="https://via.placeholder.com/400x200" class="card-img-top">

                    <div class="card-body">
                        <h5 class="card-title">Restaurante {{ $i + 1 }}</h5>
                        <p class="card-text text-muted">
                            Comida rápida • 30-40 min
                        </p>
                        <button class="btn btn-dark w-100">
                            Ver menú
                        </button>
                    </div>

                </div>
            </div>
        @endfor

    </div>

@endsection
