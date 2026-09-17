@extends('layouts.publico')

@section('title', 'SuperFast')

@section('content')

    <!-- HERO PRINCIPAL -->
    <section class="container-fluid bg-dark text-white py-5">
        <div class="container">

            <div class="row align-items-center">

                <div class="col-md-6">
                    <h1 class="display-4 fw-bold">Domicilios rápidos en tu ciudad</h1>

                    <p class="lead">
                        Encuentra restaurantes cercanos y recibe tu comida favorita
                        en minutos directamente en tu puerta.
                    </p>

                    <!-- BUSCADOR -->
                    <div class="search-bar mt-4">
                        <input type="text" class="form-control form-control-lg"
                            placeholder="Buscar restaurante o comida...">
                        <button class="btn btn-warning btn-lg">
                            Buscar
                        </button>
                    </div>

                </div>

                <div class="col-md-6 text-center">
                    <img src="{{ asset('img/LogoSF2.png') }}" class="img-fluid rounded shadow" style="max-height: 260px; object-fit: contain;">
                </div>

            </div>

        </div>
    </section>


    <!-- COMO FUNCIONA -->
    <section class="container py-5">

        <h2 class="text-center mb-5">¿Cómo funciona?</h2>

        <div class="row text-center">

            <div class="col-md-4">
                <div class="card shadow border-0 restaurant-card h-100">
                    <h2>🍔</h2>
                    <h4>Elige tu comida</h4>
                    <p>Explora restaurantes y encuentra tus platos favoritos.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow border-0 restaurant-card h-100">
                    <h2>🛒</h2>
                    <h4>Haz tu pedido</h4>
                    <p>Agrega productos al carrito y confirma tu orden.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow border-0 restaurant-card h-100">
                    <h2>🚴</h2>
                    <h4>Recibe tu domicilio</h4>
                    <p>Un repartidor llevará tu comida hasta tu puerta.</p>
                </div>
            </div>

        </div>

    </section>


    <!-- RESTAURANTES DESTACADOS -->
    <section class="container py-5">

        <h2 class="text-center mb-5">Restaurantes populares</h2>

        <div class="row g-4">

            <div class="col-md-4">
                <div class="card shadow border-0 restaurant-card h-100">
                    <img src="{{ asset('img/Pizza.png') }}" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Pizza Express</h5>
                        <p class="card-text">Pizzas artesanales y comida italiana.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow border-0 restaurant-card h-100">
                    <img src="{{ asset('img/Burger2.png') }}" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Burger House</h5>
                        <p class="card-text">Hamburguesas gourmet y papas fritas.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow border-0 restaurant-card h-100">
                    <img src="{{ asset('img/Sushi.png') }}" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Sushi Go</h5>
                        <p class="card-text">Sushi fresco preparado al momento.</p>
                    </div>
                </div>
            </div>

        </div>

    </section>


    <!-- BENEFICIOS -->
    <section class="container-fluid bg-dark text-white py-5">

        <div class="container">

            <h2 class="text-center mb-5">¿Por qué usar nuestra app?</h2>

            <div class="row text-center">

                <div class="col-md-4">
                    <h3>⚡ Entrega rápida</h3>
                    <p>Recibe tu comida en pocos minutos.</p>
                </div>

                <div class="col-md-4">
                    <h3>🍽 Restaurantes locales</h3>
                    <p>Apoya negocios de tu ciudad con cada pedido.</p>
                </div>

                <div class="col-md-4">
                    <h3>🔒 Pagos seguros</h3>
                    <p>Tus datos y pagos están protegidos.</p>
                </div>

            </div>

        </div>

    </section>


    <!-- SECCION MEMBRESIA -->
    <section class="container-fluid py-5" style="background: linear-gradient(135deg,#0f172a,#1e293b);">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7">

                    <div class="card border-0 shadow-lg text-center p-5"
                        style="border-radius:20px; background:linear-gradient(135deg,#1d4ed8,#3b82f6); color:white;">

                        <h2 class="mb-3">👑 Membresía Premium</h2>

                        <p class="fs-4 fw-bold">
                            Mejora tu experiencia de pedidos
                        </p>

                        <p class="opacity-75">
                            Obtén beneficios exclusivos como envíos gratis y prioridad
                            en tus pedidos.
                        </p>

                        <button class="btn btn-light btn-lg fw-bold mt-3 px-5" data-bs-toggle="modal"
                            data-bs-target="#vipModal">
                            Ver beneficios
                        </button>

                    </div>

                </div>
            </div>
        </div>

    </section>
    <!-- MODAL VIP -->
    <div class="modal fade" id="vipModal" tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">👑 Membresía Premium</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <ul class="list-group list-group-flush">

                        <li class="list-group-item">
                            🚚 Envíos gratis en pedidos seleccionados
                        </li>

                        <li class="list-group-item">
                            ⚡ Prioridad en la preparación de pedidos
                        </li>

                        <li class="list-group-item">
                            🎁 Promociones exclusivas
                        </li>

                        <li class="list-group-item">
                            ⭐ Experiencia sin publicidad
                        </li>

                    </ul>

                </div>

                <div class="modal-footer">

                    <button class="btn btn-primary">
                        Activar membresía
                    </button>

                </div>

            </div>
        </div>

    </div>

@endsection
