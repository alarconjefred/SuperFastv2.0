@extends('layouts.dashboardcliente')

@section('title', 'Restaurantes y Comercios - SuperFast')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold mb-1" style="color: #172554;">Restaurantes cerca de ti</h2>
            <p class="text-muted mb-0">Descubre deliciosos platos y negocios locales con entrega rápida</p>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <span class="badge px-3 py-2 rounded-pill" style="background-color: #FF6B35; color: #FFFFFF; font-weight: 600; cursor: pointer;">
                Todos los comercios
            </span>
            <span class="badge px-3 py-2 rounded-pill bg-white text-dark border" style="font-weight: 500; cursor: pointer;">
                🍔 Hamburguesas
            </span>
            <span class="badge px-3 py-2 rounded-pill bg-white text-dark border" style="font-weight: 500; cursor: pointer;">
                🍕 Pizzas
            </span>
            <span class="badge px-3 py-2 rounded-pill bg-white text-dark border" style="font-weight: 500; cursor: pointer;">
                🍣 Sushi
            </span>
        </div>
    </div>

    <div class="row g-4">

        @php
            $restaurants = [
                ['name' => 'Burger House Gourmet', 'cat' => 'Hamburguesas & Grill', 'img' => 'img/Productos/Burger2.png', 'rating' => '4.9', 'time' => '20-30 min', 'desc' => 'Hamburguesas artesanales con carne premium y salsas especiales.'],
                ['name' => 'Pizza Express & Leña', 'cat' => 'Pizzas & Pastas', 'img' => 'img/Productos/Pizza.png', 'rating' => '4.8', 'time' => '25-35 min', 'desc' => 'Auténtica pizza napolitana horneada al momento con queso mozarella.'],
                ['name' => 'Sushi Go Oriental', 'cat' => 'Comida Japonesa', 'img' => 'img/Productos/Sushi.png', 'rating' => '5.0', 'time' => '30-40 min', 'desc' => 'Rolls frescos, nigiris y combos orientales preparados por expertos.'],
                ['name' => 'Mega Burger SF', 'cat' => 'Fast Food', 'img' => 'img/Productos/Burger.png', 'rating' => '4.7', 'time' => '15-25 min', 'desc' => 'Combos rápidos, papas crujientes y malteadas deliciosas.'],
                ['name' => 'Trattoria Bella SF', 'cat' => 'Pizzas & Calzones', 'img' => 'img/Productos/Pizza.png', 'rating' => '4.9', 'time' => '30-45 min', 'desc' => 'Especialidades italianas con ingredientes frescos importados.'],
                ['name' => 'Tokyo Roll Express', 'cat' => 'Sushi & Wok', 'img' => 'img/Productos/Sushi.png', 'rating' => '4.8', 'time' => '25-35 min', 'desc' => 'Comida japonesa fresca con las mejores promociones de la ciudad.'],
            ];
        @endphp

        @foreach ($restaurants as $rest)
            <div class="col-md-6 col-lg-4">
                <div class="card sf-card restaurant-card h-100 border-0 shadow-sm overflow-hidden" style="background-color: #FFFFFF; border-radius: 16px;">

                    <div class="position-relative">
                        <img src="{{ asset($rest['img']) }}" class="card-img-top" alt="{{ $rest['name'] }}" style="height: 180px; object-fit: cover;">
                        <span class="badge position-absolute top-0 end-0 m-3 px-3 py-1 rounded-pill" style="background-color: #172554; color: #FFFFFF; font-size: 0.75rem;">
                            {{ $rest['cat'] }}
                        </span>
                    </div>

                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title fw-bold mb-0" style="color: #172554;">{{ $rest['name'] }}</h5>
                                <div class="d-flex align-items-center gap-1">
                                    <span style="color: #FFB703;">★</span>
                                    <span class="fw-bold small text-dark">{{ $rest['rating'] }}</span>
                                </div>
                            </div>
                            <p class="card-text text-muted small mb-3">
                                {{ $rest['desc'] }}
                            </p>
                        </div>

                        <div>
                            <div class="d-flex justify-content-between align-items-center pt-2 mb-3 border-top border-light">
                                <span class="small fw-semibold text-muted d-flex align-items-center gap-1">
                                    <i class="bi bi-clock-history text-warning"></i> {{ $rest['time'] }}
                                </span>
                                <span class="badge px-2 py-1" style="background-color: #FFF0EB; color: #FF6B35; font-size: 0.75rem; font-weight: 600;">
                                    Envío rápido
                                </span>
                            </div>

                            <button class="btn btn-sf-primary w-100 py-2 d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-bag-plus"></i>
                                <span>Ver menú y pedir</span>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach

    </div>
@endsection
