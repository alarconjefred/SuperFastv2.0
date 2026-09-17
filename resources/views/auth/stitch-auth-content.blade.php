@php
    $defaultMode = $defaultMode ?? 'login';
    $defaultRole = $defaultRole ?? 'buyer';
@endphp

<div class="container py-4 py-lg-5" style="max-width: 1240px;">

    <!-- Top Branding & Status Strip (Stitch Spec) -->
    <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom flex-wrap gap-2" style="border-color: #E2E8F0 !important;">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-3 d-flex align-items-center justify-content-center text-white shadow-sm" style="width: 44px; height: 44px; background-color: #FF6B35;">
                <span class="material-symbols-outlined fs-4" style="font-variation-settings: 'FILL' 1;">bolt</span>
            </div>
            <div>
                <div class="d-flex align-items-center gap-2">
                    <span class="fw-bold fs-4" style="color: #172554;">Super<span style="color: #FF6B35;">Fast</span></span>
                    <span class="badge rounded-pill" style="background-color: #FFF0EB; color: #FF6B35; font-size: 0.72rem; font-weight: 700;">v2.4</span>
                </div>
                <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.08em;">Acceso unificado para clientes y empresas</small>
            </div>
        </div>

        <div class="d-none d-sm-flex align-items-center gap-3">
            <div class="d-flex align-items-center gap-2 px-3 py-1.5 rounded-pill border bg-white shadow-xs">
                <span class="sf-pulse-dot" style="background-color: #10B981;"></span>
                <span class="small text-muted">Despachos Express Activos (Bogotá, CDMX, Lima)</span>
            </div>
            <a href="{{ route('inicio') }}" class="small fw-semibold text-muted text-decoration-none d-flex align-items-center gap-1" onmouseover="this.style.color='#FF6B35'" onmouseout="this.style.color='#64748B'">
                <span class="material-symbols-outlined fs-6">arrow_back</span>
                <span>Volver al Inicio</span>
            </a>
        </div>
    </div>

    <!-- Main Kinetic Split Shell (Stitch 7 cols / 5 cols Layout) -->
    <div class="row g-4 g-lg-5 align-items-start">

        <!-- Columna Izquierda: Formulario Interactivo (7 Columnas) -->
        <div class="col-lg-7">
            <div class="card sf-card border-0 shadow-lg rounded-4 position-relative overflow-hidden" style="background-color: #FFFFFF; border: 1px solid #E2E8F0;">
                
                <!-- Borde Superior Gradiente Oficial Stitch -->
                <div style="height: 6px; background: linear-gradient(90deg, #FF6B35 0%, #FFB703 50%, #172554 100%);"></div>

                <div class="card-body p-4 p-sm-5">

                    <!-- Selector de Rol: Comprador vs Comercio (Stitch Role Switcher) -->
                    <div class="mb-4">
                        <div class="small fw-bold text-muted text-uppercase mb-2" style="font-size: 0.72rem; letter-spacing: 0.05em;">
                            Selecciona el tipo de acceso
                        </div>
                        <div class="d-flex p-1.5 rounded-3" style="background-color: #F1F5F9;">
                            <button type="button" 
                                    id="role-buyer-btn" 
                                    onclick="setRole('buyer')" 
                                    class="btn w-50 py-2.5 rounded-3 fw-bold d-flex align-items-center justify-content-center gap-2 transition-all shadow-sm" 
                                    style="background-color: #FFFFFF; color: #172554;">
                                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1; color: #FF6B35;">local_mall</span>
                                <span>Soy Comprador</span>
                            </button>
                            <button type="button" 
                                    id="role-merchant-btn" 
                                    onclick="setRole('merchant')" 
                                    class="btn w-50 py-2.5 rounded-3 fw-semibold d-flex align-items-center justify-content-center gap-2 transition-all" 
                                    style="background-color: transparent; color: #64748B;">
                                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">storefront</span>
                                <span>Comercio Aliado</span>
                            </button>
                        </div>
                    </div>

                    <!-- Selector de Modo: Iniciar Sesión vs Crear Cuenta (Stitch Mode Toggle) -->
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-4" style="border-color: #E2E8F0 !important;">
                        <div class="d-flex gap-4">
                            <button type="button" 
                                    id="tab-login" 
                                    onclick="setMode('login')" 
                                    class="btn p-0 pb-2 border-0 fw-bold position-relative text-dark fs-5">
                                <span>Iniciar Sesión</span>
                                <span id="tab-indicator-login" class="position-absolute bottom-0 start-0 w-100 rounded-pill" style="height: 3px; background-color: #FF6B35;"></span>
                            </button>
                            <button type="button" 
                                    id="tab-register" 
                                    onclick="setMode('register')" 
                                    class="btn p-0 pb-2 border-0 fw-semibold position-relative text-muted fs-5">
                                <span>Crear Cuenta</span>
                                <span id="tab-indicator-register" class="position-absolute bottom-0 start-0 w-100 rounded-pill d-none" style="height: 3px; background-color: #FF6B35;"></span>
                            </button>
                        </div>

                        <span class="badge rounded-pill px-3 py-1.5 d-none d-sm-inline-flex align-items-center gap-1" style="background-color: #F8FAFC; border: 1px solid #CBD5E1; color: #172554; font-size: 0.75rem;">
                            <span class="material-symbols-outlined text-success" style="font-size: 16px;">verified_user</span>
                            <span id="role-badge-text">Portal Clientes</span>
                        </span>
                    </div>

                    <!-- Banner Dinámico Informativo (Stitch Dynamic Announcement) - Solo visible en Crear Cuenta -->
                    <div id="role-banner" class="p-3 rounded-3 mb-4 {{ $defaultMode === 'login' ? 'd-none' : 'd-flex' }} align-items-center gap-3 transition-all" style="background-color: #FFF0EB; border-left: 4px solid #FF6B35;">
                        <span id="banner-icon" class="material-symbols-outlined fs-3" style="color: #FF6B35;">electric_moped</span>
                        <div>
                            <h6 id="banner-title" class="fw-bold mb-0 text-dark">Entregas Ultra-Rápidas en tu Puerta</h6>
                            <p id="banner-desc" class="small text-muted mb-0">Accede a tus restaurantes locales, compras de conveniencia y seguimiento GPS en vivo.</p>
                        </div>
                    </div>

                    <!-- Mensajes de Éxito y Errores Flash -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 py-2 px-3 mb-4" role="alert" style="background-color: #ECFDF5; color: #065F46;">
                            <i class="bi bi-check-circle-fill me-1" style="color: #10B981;"></i>
                            <span class="small">{{ session('success') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 py-2 px-3 mb-4" role="alert" style="background-color: #FEF2F2; color: #991B1B;">
                            <i class="bi bi-exclamation-triangle-fill me-1" style="color: #EF4444;"></i>
                            <span class="small">{{ session('error') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('info'))
                        <div class="alert alert-info alert-dismissible fade show border-0 rounded-3 py-2 px-3 mb-4" role="alert" style="background-color: #EFF6FF; color: #1E40AF;">
                            <i class="bi bi-info-circle-fill me-1" style="color: #3B82F6;"></i>
                            <span class="small">{{ session('info') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 py-2 px-3 mb-4" role="alert" style="background-color: #FEF2F2; color: #991B1B;">
                            <i class="bi bi-exclamation-triangle-fill me-1" style="color: #EF4444;"></i>
                            <span class="small">{{ $errors->first() }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Formulario Principal -->
                    <form id="auth-form" action="{{ route('login.store') }}" method="POST">
                        @csrf

                        <!-- CAMPOS EXCLUSIVOS DE REGISTRO (Ocultos por defecto en modo Login) -->
                        <div id="register-fields" class="d-none">
                            <!-- Nombre Completo / Representante / Negocio -->
                            <div class="mb-3">
                                <label for="name" id="name-label" class="form-label small fw-semibold">Nombre Completo *</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted" style="border-color: #E2E8F0;">
                                        <span class="material-symbols-outlined fs-5">person</span>
                                    </span>
                                    <input type="text" 
                                           name="name" 
                                           id="name" 
                                           value="{{ old('name') }}" 
                                           class="form-control border-start-0" 
                                           placeholder="Ej: Carlos Mendoza">
                                </div>
                            </div>

                            <!-- Teléfono Móvil / WhatsApp (Opcional) -->
                            <div id="phone-field-wrapper" class="mb-3">
                                <label for="phone" class="form-label small fw-semibold">WhatsApp / Móvil</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted" style="border-color: #E2E8F0;">
                                        <span class="material-symbols-outlined fs-5">smartphone</span>
                                    </span>
                                    <input type="tel" 
                                           name="phone" 
                                           id="phone" 
                                           class="form-control border-start-0" 
                                           placeholder="+57 300 000 0000">
                                </div>
                            </div>
                        </div>

                        <!-- Correo Electrónico / Identidad -->
                        <div class="mb-3">
                            <label for="email" id="email-label" class="form-label small fw-semibold">Correo Electrónico *</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted" style="border-color: #E2E8F0;">
                                    <span class="material-symbols-outlined fs-5">mail</span>
                                </span>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       value="{{ old('email') }}" 
                                       class="form-control border-start-0" 
                                       placeholder="tu@correo.com" 
                                       required>
                            </div>
                        </div>

                        <!-- Contraseña -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="password" class="form-label small fw-semibold mb-0">Contraseña *</label>
                                <button type="button" id="forgot-password-link" class="btn btn-link p-0 small text-decoration-none" style="color: #FF6B35; font-size: 0.8rem;" onclick="alert('Te enviaremos un enlace de recuperación seguro por correo.');">
                                    ¿Olvidaste tu contraseña?
                                </button>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted" style="border-color: #E2E8F0;">
                                    <span class="material-symbols-outlined fs-5">lock</span>
                                </span>
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       class="form-control border-start-0 border-end-0" 
                                       placeholder="••••••••••••" 
                                       required>
                                <button type="button" class="btn btn-light border border-start-0 text-muted px-3" onclick="togglePasswordVisibility('password', 'password-eye')">
                                    <span class="material-symbols-outlined fs-5" id="password-eye">visibility</span>
                                </button>
                            </div>
                        </div>

                        <!-- Confirmación de Contraseña (Solo en Registro) -->
                        <div id="confirm-password-field" class="mb-3 d-none">
                            <label for="password_confirmation" class="form-label small fw-semibold">Confirmar Contraseña *</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted" style="border-color: #E2E8F0;">
                                    <span class="material-symbols-outlined fs-5">shield_lock</span>
                                </span>
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="password_confirmation" 
                                       class="form-control border-start-0" 
                                       placeholder="Repite tu contraseña">
                            </div>
                        </div>

                        <!-- Opciones de Recordar Sesión & Seguridad -->
                        <div class="d-flex justify-content-between align-items-center mb-4 pt-1 flex-wrap gap-2">
                            <div class="form-check m-0">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" checked style="border-color: #CBD5E1;">
                                <label class="form-check-label text-muted small" for="remember">
                                    Recordar sesión en este equipo
                                </label>
                            </div>
                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5 py-1 small d-inline-flex align-items-center gap-1">
                                <span class="material-symbols-outlined" style="font-size: 14px;">verified_user</span> SSL 256-bit
                            </span>
                        </div>

                        <!-- Botón de Envío Primario -->
                        <button type="submit" id="submit-btn" class="btn btn-sf-primary w-100 py-3 fw-bold rounded-3 shadow d-flex align-items-center justify-content-center gap-2">
                            <span id="submit-btn-text">Ingresar a SuperFast</span>
                            <span class="material-symbols-outlined fs-5">arrow_forward</span>
                        </button>
                    </form>

                    <!-- Separador Elegante (Stitch Divider) -->
                    <div class="d-flex align-items-center my-4">
                        <hr class="flex-grow-1 border-secondary opacity-25">
                        <span class="px-3 text-muted small text-uppercase" style="font-size: 0.68rem; letter-spacing: 0.06em;">O continúa con</span>
                        <hr class="flex-grow-1 border-secondary opacity-25">
                    </div>

                    <!-- Fast Social Buttons (Stitch Fast Social Auth) -->
                    <div class="row g-2 mb-4">
                        <div class="col-4">
                            <a id="google-auth-btn" href="{{ route('auth.google', ['role' => $defaultRole === 'merchant' ? 'empresa' : 'cliente']) }}" class="btn btn-light border w-100 py-2 d-flex align-items-center justify-content-center gap-2 small shadow-xs text-decoration-none" title="Continuar con Google">
                                <svg class="w-4 h-4" width="16" height="16" viewBox="0 0 24 24">
                                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" fill="#FBBC05"/>
                                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"/>
                                </svg>
                                <span class="d-none d-sm-inline fw-semibold text-dark">Google</span>
                            </a>
                        </div>
                        <div class="col-4">
                            <button type="button" class="btn btn-light border w-100 py-2 d-flex align-items-center justify-content-center gap-2 small shadow-xs" onclick="alert('Iniciando con Apple ID...');">
                                <i class="bi bi-apple fs-6"></i>
                                <span class="d-none d-sm-inline">Apple</span>
                            </button>
                        </div>
                        <div class="col-4">
                            <button type="button" class="btn w-100 py-2 d-flex align-items-center justify-content-center gap-2 small shadow-xs" style="background-color: #ECFDF5; color: #065F46; border: 1px solid #A7F3D0;" onclick="alert('Enviando código temporal a tu WhatsApp...');">
                                <i class="bi bi-whatsapp text-success fs-6"></i>
                                <span class="d-none d-sm-inline">WhatsApp</span>
                            </button>
                        </div>
                    </div>

                    <!-- Enlace Inferior para Alternar Modo -->
                    <div class="text-center pt-3 border-top border-light">
                        <p id="bottom-switch-text" class="small text-muted mb-0">
                            ¿Aún no tienes cuenta? 
                            <button type="button" class="btn btn-link p-0 small fw-bold text-decoration-none" style="color: #FF6B35;" onclick="setMode('register')">
                                Regístrate gratis en 30 segundos
                            </button>
                        </p>
                    </div>

                </div>
            </div>
        </div>

        <!-- Columna Derecha: High-Value Kinetic Value Board (Stitch 5 Columnas) -->
        <div class="col-lg-5">
            <div class="d-flex flex-column gap-4">

                <!-- Tarjeta Principal de Valor y Marca en Azul Marino Stitch -->
                <div class="card border-0 rounded-4 p-4 p-sm-5 text-white shadow-xl position-relative overflow-hidden" style="background-color: #172554;">
                    
                    <!-- Resplandor decorativo de fondo -->
                    <div class="position-absolute rounded-circle" style="width: 220px; height: 220px; top: -60px; right: -60px; background: rgba(255, 107, 53, 0.25); filter: blur(60px); pointer-events: none;"></div>
                    <div class="position-absolute rounded-circle" style="width: 200px; height: 200px; bottom: -50px; left: -50px; background: rgba(255, 183, 3, 0.2); filter: blur(60px); pointer-events: none;"></div>

                    <!-- Tag Superior Stitch y Estado en Vivo -->
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-1 position-relative z-1 flex-wrap gap-2">
                        <span id="card-tag" class="badge rounded-pill px-3 py-1.5 d-flex align-items-center gap-1 shadow-sm" style="background-color: #FF6B35; color: #FFFFFF; font-size: 0.75rem; font-weight: 700;">
                            <span class="material-symbols-outlined" style="font-size: 15px;">flash_on</span>
                            <span>Garantía SuperFast</span>
                        </span>
                        <div class="d-flex align-items-center gap-2 bg-white bg-opacity-10 px-3 py-1 rounded-pill border border-white border-opacity-10">
                            <span class="sf-pulse-dot" style="background-color: #10B981;"></span>
                            <span class="small fw-semibold text-white" id="img-status-label">14,280 repartidores en ruta</span>
                        </div>
                    </div>

                    <!-- Contenido Dinámico según Perfil (Comprador vs Comercio) -->
                    <div id="persona-buyer-content" class="position-relative z-1">
                        <h4 class="fw-bold mb-2 lh-sm text-white">
                            Pide tus platillos favoritos con entregas de 15 a 25 min garantizadas.
                        </h4>
                        <p class="small text-white-50 mb-4">
                            Tu comida llega caliente y a tiempo con tracking satelital en tiempo real, menú de miles de restaurantes aliados y cobertura total.
                        </p>

                        <!-- Métricas Rápidas Comprador -->
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="p-3 rounded-3" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255,255,255,0.12);">
                                    <div class="small text-warning text-uppercase fw-bold mb-1 d-flex align-items-center gap-1" style="font-size: 0.68rem;">
                                        <span class="material-symbols-outlined" style="font-size: 14px;">timer</span>
                                        <span>Velocidad</span>
                                    </div>
                                    <div class="fw-bold fs-5 text-white">15-25 min</div>
                                    <div class="text-white-50" style="font-size: 0.72rem;">Entrega récord urbana</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 rounded-3" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255,255,255,0.12);">
                                    <div class="small text-success text-uppercase fw-bold mb-1 d-flex align-items-center gap-1" style="font-size: 0.68rem;">
                                        <span class="material-symbols-outlined" style="font-size: 14px;">verified</span>
                                        <span>A Tiempo</span>
                                    </div>
                                    <div class="fw-bold fs-5 text-white">99.4%</div>
                                    <div class="text-white-50" style="font-size: 0.72rem;">Cumplimiento puntual</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="persona-merchant-content" class="position-relative z-1 d-none">
                        <h4 class="fw-bold mb-2 lh-sm text-white">
                            Multiplica tus ventas x3 con logística autónoma y catálogo en vivo.
                        </h4>
                        <p class="small text-white-50 mb-4">
                            Sube tu inventario en segundos, controla turnos de cocina, activa promociones relámpago y liquida ingresos diariamente a tu cuenta bancaria.
                        </p>

                        <!-- Métricas de Comercio Aliado -->
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="p-3 rounded-3" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255,255,255,0.12);">
                                    <div class="small text-warning text-uppercase fw-bold mb-1 d-flex align-items-center gap-1" style="font-size: 0.68rem;">
                                        <span class="material-symbols-outlined" style="font-size: 14px;">trending_up</span>
                                        <span>Crecimiento</span>
                                    </div>
                                    <div class="fw-bold fs-5 text-white">+320%</div>
                                    <div class="text-white-50" style="font-size: 0.72rem;">Pedidos promedio 90d</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 rounded-3" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255,255,255,0.12);">
                                    <div class="small text-success text-uppercase fw-bold mb-1 d-flex align-items-center gap-1" style="font-size: 0.68rem;">
                                        <span class="material-symbols-outlined" style="font-size: 14px;">payments</span>
                                        <span>Liquidación</span>
                                    </div>
                                    <div class="fw-bold fs-5 text-white">24 Horas</div>
                                    <div class="text-white-50" style="font-size: 0.72rem;">Depósito automático</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Tarjeta de Confianza / Social Proof & Testimonio (Stitch Pattern) -->
                <div class="card sf-card border-0 shadow-sm rounded-4 p-4 bg-white" style="border: 1px solid #E2E8F0;">
                    <div class="d-flex align-items-center justify-content-between pb-3 border-bottom" style="border-color: #E2E8F0 !important;">
                        <div class="d-flex align-items-center gap-2">
                            <div class="d-flex align-items-center">
                                <span class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-xs" style="width: 32px; height: 32px; background-color: #FF6B35; font-size: 0.75rem;">JD</span>
                                <span class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-xs ms-n2" style="width: 32px; height: 32px; background-color: #172554; font-size: 0.75rem; margin-left: -8px;">MR</span>
                                <span class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-xs ms-n2" style="width: 32px; height: 32px; background-color: #FFB703; font-size: 0.75rem; margin-left: -8px; color: #172554 !important;">AL</span>
                            </div>
                            <div class="ms-1">
                                <div class="fw-bold text-dark small">+120,000 pedidos</div>
                                <div class="text-muted" style="font-size: 0.72rem;">Completados este mes</div>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="text-warning small">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <span class="small fw-bold text-dark">4.9 / 5.0</span>
                        </div>
                    </div>

                    <!-- Testimonio Micro-Quote -->
                    <div class="pt-3">
                        <p id="quote-text" class="small text-muted fst-italic mb-2">
                            "El pedido llegó en exactamente 19 minutos un viernes por la noche en plena lluvia. La mejor app de delivery de la ciudad."
                        </p>
                        <div class="d-flex align-items-center justify-content-between">
                            <span id="quote-author" class="small fw-bold text-dark">— Valentina Ospina, Cliente VIP</span>
                            <span class="small text-success d-flex align-items-center gap-1 fw-semibold">
                                <span class="material-symbols-outlined" style="font-size: 16px;">support_agent</span>
                                <span>Soporte 24/7</span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Cuadrícula de Badges Operacionales (Stitch Grid) -->
                <div class="row g-2 text-center">
                    <div class="col-4">
                        <div class="p-2.5 rounded-3 bg-white border shadow-xs">
                            <span class="material-symbols-outlined text-warning fs-5">lock</span>
                            <div class="fw-bold text-dark" style="font-size: 0.72rem;">Pagos Seguros</div>
                            <div class="text-muted" style="font-size: 0.65rem;">PCI-DSS Nivel 1</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2.5 rounded-3 bg-white border shadow-xs">
                            <span class="material-symbols-outlined text-primary fs-5" style="color: #172554 !important;">distance</span>
                            <div class="fw-bold text-dark" style="font-size: 0.72rem;">Tracking GPS</div>
                            <div class="text-muted" style="font-size: 0.65rem;">Latencia &lt; 2 seg</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2.5 rounded-3 bg-white border shadow-xs">
                            <span class="material-symbols-outlined text-success fs-5">verified_user</span>
                            <div class="fw-bold text-dark" style="font-size: 0.72rem;">Cero Fraude</div>
                            <div class="text-muted" style="font-size: 0.65rem;">3D Secure 2.0</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<!-- Lógica Interactiva Stitch para Modo (Login/Registro) y Rol (Comprador/Comercio) -->
<script>
    let currentRole = "{{ $defaultRole }}"; // 'buyer' o 'merchant'
    let currentMode = "{{ $defaultMode }}"; // 'login' o 'register'

    document.addEventListener('DOMContentLoaded', function () {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('role') === 'merchant' || window.location.pathname.includes('empresa')) {
            currentRole = 'merchant';
        }
        if (urlParams.get('mode') === 'register' || window.location.pathname.includes('register')) {
            currentMode = 'register';
        }

        // Aplicar estado inicial
        setRole(currentRole);
        setMode(currentMode);
    });

    function setRole(role) {
        currentRole = role;
        const buyerBtn = document.getElementById('role-buyer-btn');
        const merchantBtn = document.getElementById('role-merchant-btn');
        const roleBadge = document.getElementById('role-badge-text');
        const cardTag = document.getElementById('card-tag');
        const bannerTitle = document.getElementById('banner-title');
        const bannerDesc = document.getElementById('banner-desc');
        const bannerIcon = document.getElementById('banner-icon');
        const buyerContent = document.getElementById('persona-buyer-content');
        const merchantContent = document.getElementById('persona-merchant-content');
        const nameLabel = document.getElementById('name-label');
        const emailLabel = document.getElementById('email-label');
        const emailInput = document.getElementById('email');
        const imgStatus = document.getElementById('img-status-label');
        const imgMetric = document.getElementById('img-metric-label');
        const quoteText = document.getElementById('quote-text');
        const quoteAuthor = document.getElementById('quote-author');

        if (role === 'buyer') {
            buyerBtn.style.backgroundColor = '#FFFFFF';
            buyerBtn.style.color = '#172554';
            buyerBtn.classList.add('shadow-sm', 'fw-bold');
            merchantBtn.style.backgroundColor = 'transparent';
            merchantBtn.style.color = '#64748B';
            merchantBtn.classList.remove('shadow-sm', 'fw-bold');

            roleBadge.textContent = 'Portal Clientes';
            cardTag.innerHTML = `<span class="material-symbols-outlined" style="font-size: 15px;">flash_on</span><span>Garantía SuperFast</span>`;
            bannerTitle.textContent = 'Entregas Ultra-Rápidas en tu Puerta';
            bannerDesc.textContent = 'Accede a tus restaurantes locales, compras de conveniencia y seguimiento GPS en vivo.';
            bannerIcon.textContent = 'electric_moped';
            nameLabel.textContent = 'Nombre Completo *';
            emailLabel.textContent = 'Correo Electrónico *';
            emailInput.placeholder = 'tu@correo.com';

            if (imgStatus) imgStatus.textContent = '14,280 repartidores en ruta';
            if (imgMetric) imgMetric.textContent = '18 min prom.';
            quoteText.textContent = '"El pedido llegó en exactamente 19 minutos un viernes por la noche en plena lluvia. La mejor app de delivery de la ciudad."';
            quoteAuthor.textContent = '— Valentina Ospina, Cliente VIP';

            buyerContent.classList.remove('d-none');
            merchantContent.classList.add('d-none');
        } else {
            merchantBtn.style.backgroundColor = '#FFFFFF';
            merchantBtn.style.color = '#172554';
            merchantBtn.classList.add('shadow-sm', 'fw-bold');
            buyerBtn.style.backgroundColor = 'transparent';
            buyerBtn.style.color = '#64748B';
            buyerBtn.classList.remove('shadow-sm', 'fw-bold');

            roleBadge.textContent = 'Merchant Hub Aliados';
            cardTag.innerHTML = `<span class="material-symbols-outlined" style="font-size: 15px;">verified</span><span>Merchant Partner Hub</span>`;
            bannerTitle.textContent = 'Plataforma Oficial para Comercios y Restaurantes';
            bannerDesc.textContent = 'Gestiona cartas digitales, controla inventario de cocina y despacha con la flota SuperFast.';
            bannerIcon.textContent = 'storefront';
            nameLabel.textContent = 'Nombre de la Empresa o Restaurante *';
            emailLabel.textContent = 'Correo Corporativo del Negocio *';
            emailInput.placeholder = 'gerencia@turestaurante.com';

            if (imgStatus) imgStatus.textContent = '+3,400 comercios activos';
            if (imgMetric) imgMetric.textContent = '0% comis. primer mes';
            quoteText.textContent = '"Integramos el catálogo de nuestras 6 sucursales en 40 minutos. Nuestras órdenes digitales se triplicaron desde el primer mes."';
            quoteAuthor.textContent = '— Chef Mateo Rivas, Grupo Trattoria';

            merchantContent.classList.remove('d-none');
            buyerContent.classList.add('d-none');
        }

        // Actualizar enlace de Google OAuth según el rol activo
        const googleBtn = document.getElementById('google-auth-btn');
        if (googleBtn) {
            const targetRole = role === 'merchant' ? 'empresa' : 'cliente';
            googleBtn.href = "{{ route('auth.google') }}?role=" + targetRole;
        }

        updateFormAction();
    }

    function setMode(mode) {
        currentMode = mode;
        const tabLogin = document.getElementById('tab-login');
        const tabRegister = document.getElementById('tab-register');
        const indLogin = document.getElementById('tab-indicator-login');
        const indRegister = document.getElementById('tab-indicator-register');
        const registerFields = document.getElementById('register-fields');
        const confirmPassField = document.getElementById('confirm-password-field');
        const forgotPassLink = document.getElementById('forgot-password-link');
        const bottomSwitchText = document.getElementById('bottom-switch-text');
        const nameInput = document.getElementById('name');
        const confirmPassInput = document.getElementById('password_confirmation');

        const roleBanner = document.getElementById('role-banner');

        if (mode === 'login') {
            tabLogin.classList.add('text-dark', 'fw-bold');
            tabLogin.classList.remove('text-muted');
            tabRegister.classList.add('text-muted');
            tabRegister.classList.remove('text-dark', 'fw-bold');
            indLogin.classList.remove('d-none');
            indRegister.classList.add('d-none');

            // Ocultar banner de anuncio en modo Iniciar Sesión (comprador y empresa)
            if (roleBanner) {
                roleBanner.classList.add('d-none');
                roleBanner.classList.remove('d-flex');
            }

            registerFields.classList.add('d-none');
            confirmPassField.classList.add('d-none');
            if (forgotPassLink) forgotPassLink.classList.remove('d-none');
            if (nameInput) nameInput.required = false;
            if (confirmPassInput) confirmPassInput.required = false;

            bottomSwitchText.innerHTML = `¿Aún no tienes cuenta? <button type="button" class="btn btn-link p-0 small fw-bold text-decoration-none" style="color: #FF6B35;" onclick="setMode('register')">Regístrate gratis en 30 segundos</button>`;
        } else {
            tabRegister.classList.add('text-dark', 'fw-bold');
            tabRegister.classList.remove('text-muted');
            tabLogin.classList.add('text-muted');
            tabLogin.classList.remove('text-dark', 'fw-bold');
            indRegister.classList.remove('d-none');
            indLogin.classList.add('d-none');

            // Mostrar banner de anuncio únicamente en modo Crear Cuenta
            if (roleBanner) {
                roleBanner.classList.remove('d-none');
                roleBanner.classList.add('d-flex');
            }

            registerFields.classList.remove('d-none');
            confirmPassField.classList.remove('d-none');
            if (forgotPassLink) forgotPassLink.classList.add('d-none');
            if (nameInput) nameInput.required = true;
            if (confirmPassInput) confirmPassInput.required = true;

            bottomSwitchText.innerHTML = `¿Ya tienes cuenta registrada? <button type="button" class="btn btn-link p-0 small fw-bold text-decoration-none" style="color: #FF6B35;" onclick="setMode('login')">Inicia sesión aquí</button>`;
        }

        updateFormAction();
    }

    function updateFormAction() {
        const form = document.getElementById('auth-form');
        const submitText = document.getElementById('submit-btn-text');

        if (currentMode === 'login') {
            form.action = "{{ route('login.store') }}";
            submitText.textContent = currentRole === 'buyer' ? "Ingresar a SuperFast" : "Acceder al Merchant Portal";
        } else {
            if (currentRole === 'buyer') {
                form.action = "{{ route('register.store') }}";
                submitText.textContent = "Crear mi Cuenta Express";
            } else {
                form.action = "{{ route('register.empresa.store') }}";
                submitText.textContent = "Registrar mi Negocio Aliado";
            }
        }
    }

    function togglePasswordVisibility(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.textContent = 'visibility_off';
        } else {
            input.type = 'password';
            icon.textContent = 'visibility';
        }
    }
</script>
