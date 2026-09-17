# SuperFast — Especificación y Documentación del Frontend

> **Documento de Referencia Técnica y Visual para Modelado en Stitch y Nuevos Diseños**  
> **Proyecto:** SuperFast Web Platform (Plataforma de Domicilios Rápidos y Comercio Local)  
> **Stack:** Laravel 11 (Blade) + Bootstrap 5.3 + Tailwind CSS v4 + Vanilla CSS Design System + Vite  
> **Última Actualización:** Septiembre 2026

---

## 1. Visión General del Proyecto y Objetivos

**SuperFast** es una plataforma web orientada al comercio local y despacho ultrarrápido de comidas y productos. Cuenta con dos tipos de roles de usuario claramente diferenciados en la interfaz:
1. **Clientes (`cliente`):** Exploran el catálogo dinámico de productos, buscan por comida/negocio, agregan artículos al carrito de compras en tiempo real y gestionan sus pedidos.
2. **Comercios / Empresas (`empresa`):** Disponen de un panel de gestión donde dan de alta productos, configuran stock, activan/desactivan disponibilidad, cargan y previsualizan fotografías de catálogo y gestionan su inventario.

---

## 2. Sistema de Diseño e Identidad Visual (Design Tokens)

Toda la plataforma se rige bajo una identidad cromática estricta para garantizar un look premium, moderno y unificado. Estas variables se encuentran declaradas en `resources/css/app.css`:

### 2.1 Paleta de Colores Oficial

| Token CSS | Código HEX | Rol / Uso en la Interfaz |
| :--- | :--- | :--- |
| `--sf-primary` | `#FF6B35` | **Naranja Enérgico:** Botones de compra (CTA), agregar al carrito, badges destacados, acentos de marca. |
| `--sf-primary-hover`| `#E85822` | Estado hover de botones y enlaces primarios. |
| `--sf-primary-light`| `#FFF0EB` | Fondos tenues para badges, estados activos y contenedores de íconos. |
| `--sf-secondary` | `#172554` | **Azul Noche / Marino:** Navbar superior, sidebar principal, encabezados (`h1`-`h6`), tarjetas institucionales. |
| `--sf-secondary-hover`| `#1E3A8A` | Estado hover en navegación institucional. |
| `--sf-secondary-dark` | `#0F172A` | Fondos de gradientes oscuros en Hero sections. |
| `--sf-accent` | `#FFB703` | **Amarillo Acento:** Estrellas de valoración, badges de rol, íconos llamativos. |
| `--sf-accent-hover` | `#E5A502` | Hover en elementos de acento. |
| `--sf-background` | `#F5F7FA` | **Fondo Global:** Gris claro neutro y limpio para todas las vistas internas. |
| `--sf-white` | `#FFFFFF` | Superficies de tarjetas (`cards`), modales, dropdowns y formularios. |
| `--sf-text` | `#1F2937` | Color de texto principal (alta legibilidad). |
| `--sf-text-muted` | `#64748B` | Textos secundarios, descripciones, metadatos y subtítulos. |
| `--sf-border` | `#E2E8F0` | Bordes sutiles y divisores estructurales. |

### 2.2 Estados Semánticos y Badges

- **En Stock / Éxito:** Fondo `#ECFDF5`, Texto `#065F46`, Borde `#A7F3D0` (`bi-check-circle`).
- **Agotado / Error:** Fondo `#FEF2F2`, Texto `#991B1B`, Borde `#FECACA` (`bi-x-circle`).
- **Bajo Stock / Advertencia:** Fondo `#FFFBEB`, Texto `#92400E`, Borde `#FDE68A` (`bi-exclamation-triangle`).
- **Inactivo / No Disponible:** Fondo `#F1F5F9`, Texto `#475569`, Borde `#CBD5E1` (`bi-slash-circle`).

### 2.3 Tipografía
- **Familia tipográfica:** `'Plus Jakarta Sans', system-ui, -apple-system, sans-serif`.
- **Pesos utilizados:** `400` (Regular), `500` (Medium), `600` (Semi-bold), `700` (Bold), `800` (Extra-bold).

### 2.4 Sombras y Bordes Redondeados
- `border-radius: 16px` para tarjetas principales (`sf-card`).
- `border-radius: 50px` (pill) para badges, filtros y barras de búsqueda.
- `border-radius: 8px - 10px` para inputs, botones y miniaturas de imagen.
- Sombra estándar: `box-shadow: 0 4px 14px rgba(23, 37, 84, 0.08);`.

---

## 3. Arquitectura de Imágenes y Recursos Reutilizables

La plataforma cuenta con un repositorio organizado de imágenes estáticas y dinámicas ya vinculadas a la base de datos MySQL (`pageweb`).

### 3.1 Directorio de Activos Estáticos (`public/img/`)

```text
public/img/
├── Logos/
│   └── Logo principal.jpeg          # Isotipo + logotipo horizontal institucional
├── Iconos/
│   └── Version compacta.jpg         # Ícono cuadrado / Favicon / Fallback oficial de productos
└── Productos/
    ├── Burger.png                   # Hamburguesa Gourmet (alta resolución)
    ├── Burger2.png                  # Mega Burger Doble BBQ
    ├── Pizza.png                    # Pizza Suprema Mozzarella al horno
    ├── Sushi.png                    # Combo Roll Oriental
    └── LogoSF2.png                  # Variante de marca gráfica
```

### 3.2 Imágenes Dinámicas en Base de Datos y Almacenamiento

1. **Ruta física de almacenamiento:** `storage/app/public/productos/`
2. **Acceso público mediante enlace simbólico:** `public/storage/productos/`
3. **Accessor en el Modelo `Producto.php`:**
   ```php
   public function getImagenUrlAttribute(): string
   {
       if ($this->imagen && Storage::disk('public')->exists($this->imagen)) {
           return asset('storage/' . $this->imagen);
       }
       return asset('img/Iconos/Version compacta.jpg'); // Fallback profesional
   }
   ```
4. **Productos precargados en la Base de Datos con imágenes reutilizables:**
   - **ID 1:** `Hamburguesa Clásica SuperFast` → `productos/Burger.png` (Stock: 15)
   - **ID 2:** `Pizza Suprema Mozzarella` → `productos/Pizza.png` (Stock: 8)
   - **ID 3:** `Combo Roll Oriental (12 pcs)` → `productos/Sushi.png` (Stock: 5)
   - **ID 4:** `Mega Burger Doble BBQ` → `productos/Burger2.png` (Stock: 0 → Estado: **Agotado**)

### 3.3 Regla Crítica de Dimensiones y Proporciones (Layout Safety)

> **IMPORTANTE PARA STITCH:** En Tailwind CSS v4, las etiquetas `<img>` tienen por defecto `height: auto`. Para evitar que imágenes de diferentes resoluciones rompan el grid de tarjetas, **siempre** deben encerrarse en un contenedor con altura fija y aplicar `object-fit: cover`:

- **Tarjeta de Catálogo (Cliente):**
  ```html
  <div style="height: 190px; width: 100%; overflow: hidden; background-color: #F8FAFC; position: relative;">
      <img src="{{ $producto->imagen_url }}" style="width: 100%; height: 100%; object-fit: cover;">
  </div>
  ```
- **Miniatura en Carrito:** `width: 60px; height: 60px; border-radius: 10px; object-fit: cover;`
- **Miniatura en Tabla de Empresa:** `width: 52px; height: 52px; border-radius: 8px; object-fit: cover;`
- **Previsualización en Formularios:** `height: 140px; width: 100%; object-fit: cover;`

---

## 4. Estructura de Layouts y Navegación

### 4.1 Layout Público (`resources/views/layouts/publico.blade.php`)
- Utilizado en la página de bienvenida (`/`) y vistas no autenticadas.
- **Navbar Superior:** Fondo `#172554` con borde inferior `#FF6B35` de `2.5px`.
  - Logotipo institucional con `Version compacta.jpg`.
  - Botón de **Iniciar Sesión Unificado** (`.btn-sf-primary`).
  - Botones de **Crear Cuenta** (`.btn-outline-light`) y **Registrar Empresa** (`.btn-sf-accent`).
  - Acceso directo a carrito para usuarios autenticados con contador numérico.
- **Footer Institucional:** Enlaces rápidos, sellos de confianza y derechos de autor.

### 4.2 Layout de Dashboard (`resources/views/layouts/dashboardcliente.blade.php`)
- Utilizado en `/dashboard`, `/carrito`, `/empresa`, `/empresa/{empresa}/productos/*`.
- **Sidebar Izquierdo Fijo (260px):**
  - Fondo `#172554`, borde derecho sutil.
  - Logotipo SuperFast en blanco y naranja.
  - Navegación con detección de ruta activa (`request()->routeIs(...)`):
    - **Catálogo** (`route('dashboard')`)
    - **Mi Carrito** (`route('carrito.index')`) con badge numérico en tiempo real
    - **Mi Empresa** (`route('empresa.index')`) si el usuario tiene rol `empresa`
  - Sección inferior con avatar circular (inicial del nombre sobre fondo `#FF6B35`), rol del usuario y botón de cerrar sesión.
- **Topbar Superior Blanco (`#FFFFFF`):**
  - Buscador global redondeado con ícono `bi-search`.
  - Botón circular de carrito con badge flotante.
  - Nombre y rol del usuario logueado.
- **Área de Contenido:** Fondo `#F5F7FA`, espaciado responsivo `p-4 p-md-5`.

---

## 5. Vistas Desarrolladas y Componentes Clave

### 5.1 Landing Page (`resources/views/inicio.blade.php`)
- **Hero Section:** Gradiente `#172554` a `#0F172A`, titulares con acento `#FFB703`, buscador rápido y tarjeta con el `Logo principal.jpeg`.
- **Paso a Paso:** "¿Cómo funciona SuperFast?" en 3 pasos (Elige, Pide, Recibe).
- **Categorías Populares:** Pills interactivas con íconos de alimentos.
- **Garantías:** Entregas rápidas, pago seguro y soporte local.

### 5.2 Catálogo del Cliente (`resources/views/cliente.blade.php`)
- **Encabezado Dinámico:** Contador de productos disponibles y tag del filtro activo de búsqueda si existe `?q=param`.
- **Grid de Productos (Responsive: `col-md-6 col-lg-4 col-xl-3`):**
  - **Badge de Comercio:** Flotante en la esquina superior izquierda sobre la foto (`<i class="bi bi-shop"></i> Nombre de la Empresa`).
  - **Badge de Disponibilidad:** Flotante en la esquina superior derecha:
    - Stock > 0: `X disp.` (Fondo `#172554`).
    - Stock = 0: `Agotado` (Fondo `#EF4444`).
    - Inactivo: `No disponible` (Fondo `#64748B`).
  - **Cuerpo:** Título truncado, descripción (máximo 2 líneas mediante `-webkit-line-clamp: 2`), precio destacado en `$XX.XX` (`#FF6B35`).
  - **Botón de Acción:**
    - Si disponible: Formulario `POST` a `carrito.agregar` con botón naranja "Agregar al carrito".
    - Si agotado/inactivo: Botón gris/rojo deshabilitado (`disabled`).
- **Estado Vacío:** Card centrada con ícono `bi-box-seam` si no hay productos que coincidan con la búsqueda.

### 5.3 Carrito de Compras (`resources/views/carrito.blade.php`)
- **Sincronización en Tiempo Real:** Si un comercio cambia el stock o apaga un producto, se despliega una alerta amarilla destacando los ajustes realizados automáticamente.
- **Tabla de Ítems (Columna Izquierda 8 cols):**
  - Miniatura de `60x60px`, nombre y negocio.
  - Controles de cantidad integrados: Botón `-`, display de cantidad y botón `+` (deshabilitado si se alcanza el stock máximo del producto).
  - Subtotal calculado en tiempo real.
  - Botón de eliminación individual con ícono de papelera y confirmación.
  - Opción de "Vaciar Carrito".
- **Resumen del Pedido (Columna Derecha 4 cols):**
  - Subtotal, costo de envío gratis, total en grande (`#FF6B35`).
  - Botón "Proceder al Pago" que abre el modal de confirmación.
  - Sellos de garantía (pago seguro, entrega exprés, soporte 24/7).
- **Modal de Confirmación de Pedido:** Resumen con nombre del cliente, correo, método de pago y confirmación de despacho.

### 5.4 Panel de la Empresa (`resources/views/empresa.blade.php`)
- **Formulario de Alta de Producto:**
  - Input file para imagen con previsualizador interactivo (`FileReader`) y botón para descartar.
  - Nombre, descripción en textarea, precio numérico con prefijo `$`, stock en unidades.
  - Switch interactivo para marcar `disponible` (on/off).
- **Tabla de Catálogo del Comercio:**
  - Miniaturas cuadradas fijas (`52x52px`).
  - Badges de stock (Normal, Bajo Stock, Agotado).
  - Acciones rápidas: "Editar" (`productos.edit`) y "Eliminar" (`productos.destroy`).

### 5.5 Edición de Producto (`resources/views/Productos/edit.blade.php`)
- Visualización de la imagen actual con opción para **"Eliminar imagen actual (usar imagen por defecto)"**.
- Selector para reemplazar la imagen por una nueva con previsualización en vivo.
- Modificación de precio, stock y switch de disponibilidad.

### 5.6 Módulo de Autenticación Unificado (`resources/views/auth/login.blade.php`)
- Acceso único tanto para clientes como para comercios.
- Redirección inteligente:
  - Clientes → `/dashboard` (Catálogo).
  - Empresas → `/empresa` (Panel de gestión).

---

## 6. Snippets de Componentes Listos para Adaptar en Stitch

### 6.1 Tarjeta de Producto Oficial (Product Card)
```html
<div class="card sf-card h-100 border-0 shadow-sm overflow-hidden d-flex flex-column" 
     style="background-color: #FFFFFF; border-radius: 16px; border: 1px solid #E2E8F0;">
    
    <!-- Contenedor Seguro de Imagen -->
    <div class="position-relative" style="height: 190px; width: 100%; overflow: hidden; background-color: #F8FAFC;">
        <img src="{{ $producto->imagen_url }}" 
             alt="{{ $producto->nombre }}" 
             style="width: 100%; height: 100%; object-fit: cover;">
        
        <!-- Badge Comercio -->
        <span class="badge position-absolute top-0 start-0 m-3 px-3 py-1 rounded-pill shadow-sm" 
              style="background-color: rgba(255, 255, 255, 0.95); color: #172554; font-size: 0.75rem; font-weight: 700; backdrop-filter: blur(4px);">
            <i class="bi bi-shop me-1" style="color: #FF6B35;"></i> {{ $producto->empresa->nombre }}
        </span>

        <!-- Badge Stock -->
        <span class="badge position-absolute top-0 end-0 m-3 px-3 py-1 rounded-pill shadow-sm" 
              style="background-color: #172554; color: #FFFFFF; font-size: 0.75rem;">
            {{ $producto->stock }} disp.
        </span>
    </div>

    <!-- Cuerpo -->
    <div class="card-body p-4 d-flex flex-column justify-content-between flex-grow-1">
        <div>
            <h5 class="card-title fw-bold mb-1 text-truncate" style="color: #172554;">{{ $producto->nombre }}</h5>
            <p class="card-text text-muted small mb-3" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 38px;">
                {{ $producto->descripcion }}
            </p>
        </div>

        <div>
            <div class="d-flex justify-content-between align-items-center pt-2 mb-3 border-top border-light">
                <span class="fw-bolder fs-5" style="color: #FF6B35;">${{ number_format($producto->precio, 2) }}</span>
                <span class="badge bg-success-subtle text-success border border-success-subtle small">En stock</span>
            </div>

            <button class="btn btn-sf-primary w-100 py-2 d-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-cart-plus"></i>
                <span>Agregar al carrito</span>
            </button>
        </div>
    </div>
</div>
```

### 6.2 Botones Oficiales
```html
<!-- Primario (Acción Principal / Compra) -->
<button class="btn btn-sf-primary">
    <i class="bi bi-bag-check me-1"></i> Confirmar Pedido
</button>

<!-- Secundario (Volver / Cancelar) -->
<a href="#" class="btn btn-sf-secondary">
    <i class="bi bi-arrow-left me-1"></i> Volver al Catálogo
</a>

<!-- Acento (Promocional / Destacado) -->
<button class="btn btn-sf-accent">
    <i class="bi bi-star-fill me-1"></i> Oferta Especial
</button>
```

---

## 7. Instrucciones para Integración y Nuevos Modelos en Stitch

Al generar o adaptar nuevos modelos visuales o vistas en Stitch para SuperFast:
1. **Mantener los Tokens:** Usa rigurosamente `#FF6B35` para llamadas a la acción primarias y `#172554` para estructuras institucionales.
2. **Reutilizar los Recursos Existentes:** No generes placeholders rotos. Utiliza las rutas `public/img/Logos/Logo principal.jpeg`, `public/img/Iconos/Version compacta.jpg` y las imágenes de comida en `public/img/Productos/` (`Burger.png`, `Pizza.png`, `Sushi.png`, etc.).
3. **Respetar la Relación de Aspecto:** Cualquier nueva sección con cards o galerías debe incluir reglas de proporción (`object-fit: cover` con contenedores acotados) para evitar que imágenes subidas por empresas deformen el diseño.
4. **Coherencia con Bootstrap 5 & Tailwind:** El proyecto combina Bootstrap 5.3 (para grid, tablas y modales) con utilidades y componentes personalizados de Tailwind y Vanilla CSS en `app.css`.
