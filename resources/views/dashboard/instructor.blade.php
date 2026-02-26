@extends('layouts.instructores')

@section('content')
<style>
    :root {
        --sena-green: #39A900;
        --sena-blue: #406479;
        --sena-yellow: #FFC107;
    }

    .header-section {
        background: linear-gradient(135deg, var(--sena-blue), var(--sena-green));
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .header-section h2 {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        margin-bottom: 0.5rem;
        font-size: 2rem;
    }

    .header-section p {
        font-size: 1rem;
        opacity: 0.95;
        margin: 0;
    }

    .area-badge {
        display: inline-block;
        background: rgba(255, 255, 255, 0.2);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        margin-top: 0.5rem;
        font-weight: 600;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    /* 👈 NUEVO: Selector de ficha */
    .ficha-selector-container {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
        border-left: 5px solid var(--sena-green);
    }

    .ficha-selector-container label {
        font-weight: 700;
        color: #333;
        margin-bottom: 0.75rem;
        display: block;
        font-size: 1rem;
    }

    .ficha-selector-container select {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 0.95rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .ficha-selector-container select:focus {
        outline: none;
        border-color: var(--sena-green);
        box-shadow: 0 0 0 3px rgba(57, 169, 0, 0.1);
    }

    .ficha-selector-container small {
        display: block;
        margin-top: 0.5rem;
        color: #666;
        font-style: italic;
    }

    /* 👈 NUEVO: Alerta de ficha no seleccionada */
    .alerta-ficha {
        background: #fff3cd;
        border: 2px solid #ffc107;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        display: none;
        align-items: center;
        gap: 1rem;
    }

    .alerta-ficha i {
        font-size: 1.5rem;
        color: #ff9800;
    }

    .alerta-ficha strong {
        color: #333;
    }

    /* Botones mejorados */
    .btn-action {
        border-radius: 12px;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-carrito {
        background: linear-gradient(135deg, var(--sena-green), #2d8a00);
        color: white;
    }

    .btn-carrito:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(57, 169, 0, 0.3);
        color: white;
    }

    /* Tarjetas de productos */
    .producto-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        border: 2px solid transparent;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .producto-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        border-color: var(--sena-green);
    }

    .producto-img {
        position: relative;
        height: 220px;
        overflow: hidden;
        background: linear-gradient(135deg, #f5f5f5, #e9ecef);
    }

    .producto-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .producto-card:hover .producto-img img {
        transform: scale(1.05);
    }

    .badge-disponible {
        position: absolute;
        top: 12px;
        right: 12px;
        background: linear-gradient(135deg, var(--sena-green), #2d8a00);
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .badge-talla {
        position: absolute;
        top: 12px;
        left: 12px;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .producto-body {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .producto-titulo {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1.1rem;
        color: #333;
        margin-bottom: 0.8rem;
        line-height: 1.3;
    }

    .producto-info {
        margin-bottom: 1rem;
    }

    .info-item {
        display: flex;
        align-items: center;
        margin-bottom: 0.6rem;
        font-size: 0.9rem;
        color: #666;
    }

    .info-item i {
        width: 20px;
        color: var(--sena-blue);
        margin-right: 0.5rem;
    }

    .info-label {
        font-weight: 600;
        color: #333;
        margin-right: 0.5rem;
    }

    /* Selector de talla MEJORADO */
    .talla-selector {
        margin-bottom: 1rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 10px;
        border: 2px solid #e0e0e0;
    }

    .talla-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        display: block;
    }

    /* Contenedor de opciones de talla */
    .talla-options {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
        flex-wrap: wrap;
    }

    /* Botones de talla predefinida */
    .talla-btn {
        padding: 0.5rem 0.75rem;
        border: 2px solid #ddd;
        background: white;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s ease;
    }

    .talla-btn:hover {
        border-color: var(--sena-blue);
        background: #f0f0f0;
    }

    .talla-btn.active {
        background: linear-gradient(135deg, var(--sena-blue), var(--sena-green));
        color: white;
        border-color: var(--sena-green);
    }

    /* Input personalizado para talla */
    .talla-custom-input {
        width: 100%;
        padding: 0.5rem;
        border: 2px solid #ddd;
        border-radius: 6px;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .talla-custom-input:focus {
        outline: none;
        border-color: var(--sena-green);
        box-shadow: 0 0 0 3px rgba(57, 169, 0, 0.1);
    }

    .talla-display {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem;
        background: linear-gradient(135deg, var(--sena-blue), var(--sena-green));
        color: white;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1.1rem;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }

    .talla-display i {
        font-size: 1.3rem;
    }

    .sin-talla {
        background: #e0e0e0;
        color: #666;
    }

    /* Selector de cantidad */
    .cantidad-selector {
        margin-bottom: 1rem;
    }

    .cantidad-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #666;
        margin-bottom: 0.5rem;
        display: block;
    }

    .input-group-cantidad {
        display: flex;
        align-items: center;
        gap: 0;
    }

    .input-group-cantidad button {
        background: #f0f0f0;
        border: 2px solid #e0e0e0;
        color: #333;
        padding: 0.5rem 0.75rem;
        cursor: pointer;
        transition: all 0.2s ease;
        font-weight: 600;
        font-size: 1rem;
    }

    .input-group-cantidad button:hover {
        background: var(--sena-green);
        color: white;
        border-color: var(--sena-green);
    }

    .input-group-cantidad input {
        border: 2px solid #e0e0e0;
        text-align: center;
        font-weight: 600;
        flex: 1;
        padding: 0.5rem;
        font-size: 1rem;
    }

    .input-group-cantidad input:focus {
        outline: none;
        border-color: var(--sena-green);
        box-shadow: 0 0 0 3px rgba(57, 169, 0, 0.1);
    }

    /* Botones de acción */
    .producto-acciones {
        margin-top: auto;
    }

    .btn-agregar {
        width: 100%;
        background: linear-gradient(135deg, var(--sena-blue), #2d5a7a);
        color: white;
        border: none;
        padding: 0.75rem;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .btn-agregar:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(64, 100, 121, 0.3);
    }

    .btn-agregar:active {
        transform: translateY(0);
    }

    /* Sección de botones superiores */
    .acciones-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .acciones-top .btn {
        flex: 1;
        min-width: 200px;
    }

    /* Alerta sin elementos */
    .alerta-vacia {
        background: linear-gradient(135deg, #e3f2fd, #bbdefb);
        border-left: 5px solid var(--sena-blue);
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        color: var(--sena-blue);
    }

    .alerta-vacia i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.7;
    }

    .alerta-vacia h4 {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    /* Paginación mejorada */
    .pagination {
        justify-content: center;
        margin-top: 2rem;
    }

    .pagination .page-link {
        border-radius: 8px;
        border: 2px solid #e0e0e0;
        color: var(--sena-blue);
        margin: 0 0.25rem;
        transition: all 0.2s ease;
    }

    .pagination .page-link:hover {
        background: var(--sena-green);
        border-color: var(--sena-green);
        color: white;
    }

    .pagination .page-item.active .page-link {
        background: var(--sena-green);
        border-color: var(--sena-green);
    }

    /* Toast mejorado */
    .toast {
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        border: none;
    }

    .toast-header {
        border-radius: 12px 12px 0 0;
        font-weight: 600;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .header-section h2 {
            font-size: 1.5rem;
        }

        .acciones-top {
            flex-direction: column;
        }

        .acciones-top .btn {
            width: 100%;
        }

        .producto-card {
            margin-bottom: 1rem;
        }

        .talla-options {
            gap: 0.3rem;
        }

        .talla-btn {
            padding: 0.4rem 0.6rem;
            font-size: 0.75rem;
        }
    }

    /* Animaciones */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .producto-card {
        animation: slideIn 0.3s ease forwards;
    }

    .producto-card:nth-child(1) { animation-delay: 0.05s; }
    .producto-card:nth-child(2) { animation-delay: 0.1s; }
    .producto-card:nth-child(3) { animation-delay: 0.15s; }
    .producto-card:nth-child(4) { animation-delay: 0.2s; }
    .producto-card:nth-child(5) { animation-delay: 0.25s; }
    .producto-card:nth-child(6) { animation-delay: 0.3s; }
</style>

<!-- Header mejorado -->
<div class="container mt-4">
    <div class="header-section">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h2>👋 Bienvenido, {{ $user->nombre_completo }}</h2>
                <p class="text-white-50">Selecciona los equipos de protección personal que necesitas</p>
                <div class="area-badge">
                    <i class="bi bi-tag"></i> Área: <strong>{{ $user->area->nombre ?? 'Sin área asignada' }}</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- 👈 NUEVO: Selector de ficha -->
    <div class="ficha-selector-container">
        <label for="ficha-selector">
            <i class="bi bi-file-earmark"></i> Seleccionar Ficha
        </label>
        <select id="ficha-selector" required>
            <option value="">-- Selecciona una ficha --</option>
            @foreach($fichas as $ficha)
            <option value="{{ $ficha->id }}">
                {{ $ficha->numero }} - {{ $ficha->programa->nombre }}
            </option>
            @endforeach
        </select>
        <small>
            <i class="bi bi-info-circle"></i> Selecciona la ficha para la cual solicitas los elementos
        </small>
    </div>

    <!-- 👈 NUEVO: Alerta si no hay ficha seleccionada -->
    <div id="alerta-ficha" class="alerta-ficha">
        <i class="bi bi-exclamation-triangle"></i>
        <div>
            <strong>Atención:</strong> Debes seleccionar una ficha antes de agregar elementos al carrito.
        </div>
    </div>

    <!-- Acciones superiores -->
    @if ($elementos->count() > 0)
    <div class="acciones-top">
        <button type="button" class="btn btn-carrito btn-action" id="agregarTodoBtn" onclick="agregarTodoAlCarrito()">
            <i class="bi bi-plus-circle"></i> Agregar Todo al Carrito
        </button>
        <a href="{{ route('carrito.index') }}" class="btn btn-outline-success btn-action">
            <i class="bi bi-cart-check"></i> Ver Carrito
        </a>
    </div>
    @endif

    <!-- Productos -->
    @if ($elementos->count() > 0)
    <div class="row g-4">
        @foreach ($elementos as $epp)
        <div class="col-lg-4 col-md-6">
            <div class="producto-card" id="card-{{ $epp->id }}">
                <!-- Imagen del producto -->
                <div class="producto-img">
                    <img src="{{ asset($epp->img_url) }}" alt="{{ $epp->nombre }}">

                    <!-- Badge de talla si existe -->
                    @if ($epp->talla)
                    <div class="badge-talla">
                        <i class="bi bi-rulers"></i> Talla: {{ $epp->talla }}
                    </div>
                    @endif

                    <div class="badge-disponible">
                        <i class="bi bi-check-circle"></i> {{ $epp->cantidad }} disponibles
                    </div>
                </div>

                <!-- Cuerpo de la tarjeta -->
                <div class="producto-body">
                    <!-- Título -->
                    <h5 class="producto-titulo">{{ $epp->nombre }}</h5>

                    <!-- Información del producto -->
                    <div class="producto-info">
                        @if ($epp->area)
                        <div class="info-item">
                            <i class="bi bi-building"></i>
                            <span class="info-label">Área:</span>
                            <span>{{ $epp->area->nombre }}</span>
                        </div>
                        @endif

                        @if ($epp->filtro)
                        <div class="info-item">
                            <i class="bi bi-shield-check"></i>
                            <span class="info-label">Protección:</span>
                            <span>{{ $epp->filtro->parte_del_cuerpo ?? '-' }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- Selector de talla MEJORADO -->
                    <div class="talla-selector">
                        <label class="talla-label">
                            <i class="bi bi-rulers"></i> Talla del producto:
                        </label>

                        <!-- Opciones predefinidas de talla -->
                        <div class="talla-options">
                            <button type="button" class="talla-btn" onclick="seleccionarTalla('{{ $epp->id }}', 'XS')">XS</button>
                            <button type="button" class="talla-btn" onclick="seleccionarTalla('{{ $epp->id }}', 'S')">S</button>
                            <button type="button" class="talla-btn" onclick="seleccionarTalla('{{ $epp->id }}', 'M')">M</button>
                            <button type="button" class="talla-btn" onclick="seleccionarTalla('{{ $epp->id }}', 'L')">L</button>
                            <button type="button" class="talla-btn" onclick="seleccionarTalla('{{ $epp->id }}', 'XL')">XL</button>
                            <button type="button" class="talla-btn" onclick="seleccionarTalla('{{ $epp->id }}', 'XXL')">XXL</button>
                        </div>

                        <!-- Input personalizado para talla -->
                        <input
                            type="text"
                            id="talla-{{ $epp->id }}"
                            class="talla-custom-input"
                            placeholder="O escribe una talla personalizada (ej: 34, 35, 36, UNICA)"
                            value="{{ $epp->talla ?? '' }}"
                        >

                        <!-- Mostrar talla seleccionada -->
                        <div class="talla-display" id="talla-display-{{ $epp->id }}">
                            <i class="bi bi-check2-circle"></i>
                            <span id="talla-text-{{ $epp->id }}">{{ $epp->talla ?? 'Sin seleccionar' }}</span>
                        </div>

                        <!-- Input hidden para enviar al servidor -->
                        <input type="hidden" id="talla-hidden-{{ $epp->id }}" value="{{ $epp->talla ?? '' }}">
                    </div>

                    <!-- Selector de cantidad -->
                    <div class="cantidad-selector">
                        <label class="cantidad-label">Cantidad a agregar:</label>
                        <div class="input-group-cantidad">
                            <button type="button" onclick="changeQuantity('{{ $epp->id }}', -1)">−</button>
                            <input type="number" id="qty-{{ $epp->id }}" class="form-control" value="0" min="0" max="{{ $epp->cantidad }}" readonly>
                            <button type="button" onclick="changeQuantity('{{ $epp->id }}', 1)">+</button>
                        </div>
                    </div>

                    <!-- Botón de acción -->
                    <div class="producto-acciones">
                        <button type="button" class="btn-agregar" onclick="agregarAlCarritoAjax('{{ $epp->id }}', '{{ $epp->nombre }}')">
                            <i class="bi bi-cart-plus"></i> Agregar al Carrito
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Paginación -->
    <div class="d-flex justify-content-center mt-4">
        {{ $elementos->links() }}
    </div>
    @else
    <!-- Sin elementos -->
    <div class="alerta-vacia">
        <i class="bi bi-inbox"></i>
        <h4>No hay elementos disponibles</h4>
        <p>No hay equipos de protección personal disponibles para tu área en este momento.</p>
    </div>
    @endif
</div>

<!-- Toast para notificaciones -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="toastNotificacion" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white">
            <i class="bi bi-check-circle me-2"></i>
            <strong class="me-auto">Notificación</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toastMensaje">
            Producto agregado al carrito
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- SCRIPT MEJORADO CON SELECTOR DE FICHA Y TALLA EDITABLE -->
<script>
// 👈 NUEVA VARIABLE GLOBAL: Ficha seleccionada
let fichaSeleccionada = null;

// 👈 NUEVO: Escuchar cambios en el selector de ficha
document.getElementById('ficha-selector').addEventListener('change', function() {
    fichaSeleccionada = this.value;

    if (fichaSeleccionada) {
        document.getElementById('alerta-ficha').style.display = 'none';
    } else {
        document.getElementById('alerta-ficha').style.display = 'flex';
    }
});

// Cambiar cantidad con botones + y -
function changeQuantity(id, delta) {
    const input = document.getElementById(`qty-${id}`);
    let value = parseInt(input.value) || 0;
    const max = parseInt(input.max);
    value += delta;
    if (value < 0) value = 0;
    if (value > max) value = max;
    input.value = value;
}

// Mostrar notificación Toast
function mostrarToast(mensaje) {
    const toastMensaje = document.getElementById('toastMensaje');
    toastMensaje.textContent = mensaje;

    const toastElement = document.getElementById('toastNotificacion');
    const toast = new bootstrap.Toast(toastElement);
    toast.show();
}

// 👈 FUNCIÓN: Seleccionar talla predefinida
function seleccionarTalla(id, talla) {
    // Actualizar input hidden
    document.getElementById(`talla-hidden-${id}`).value = talla;

    // Actualizar input visible
    document.getElementById(`talla-${id}`).value = talla;

    // Actualizar display
    document.getElementById(`talla-text-${id}`).textContent = talla;

    // Marcar botón como activo
    const botones = document.querySelectorAll(`#card-${id} .talla-btn`);
    botones.forEach(btn => {
        if (btn.textContent === talla) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });

    console.log(`Talla seleccionada para producto ${id}: ${talla}`);
}

// 👈 FUNCIÓN: Actualizar talla cuando se escribe en el input
document.addEventListener('DOMContentLoaded', function() {
    // Obtener todos los inputs de talla personalizada
    document.querySelectorAll('[id^="talla-"]').forEach(input => {
        if (input.id.includes('custom-input') || input.classList.contains('talla-custom-input')) {
            input.addEventListener('input', function() {
                const id = this.id.replace('talla-', '');
                const talla = this.value.trim();

                if (talla) {
                    // Actualizar hidden input
                    document.getElementById(`talla-hidden-${id}`).value = talla;

                    // Actualizar display
                    document.getElementById(`talla-text-${id}`).textContent = talla;

                    // Remover clase active de todos los botones
                    const botones = document.querySelectorAll(`#card-${id} .talla-btn`);
                    botones.forEach(btn => btn.classList.remove('active'));
                }
            });
        }
    });
});

// ✅ FUNCIÓN: Agregar producto individual
function agregarAlCarritoAjax(id, nombre) {
    // 👈 NUEVO: Validar que hay ficha seleccionada
    if (!fichaSeleccionada) {
        mostrarToast('⚠️ Debes seleccionar una ficha primero');
        document.getElementById('alerta-ficha').style.display = 'flex';
        return;
    }

    const cantidad = parseInt(document.getElementById(`qty-${id}`).value) || 0;

    // 👈 OBTENER TALLA DEL INPUT HIDDEN
    const talla = document.getElementById(`talla-hidden-${id}`)?.value ||
                  document.getElementById(`talla-${id}`)?.value ||
                  null;

    console.log('DEBUG:', { id, nombre, cantidad, talla, fichaSeleccionada });

    // Validar que la cantidad sea mayor a 0
    if (cantidad <= 0) {
        mostrarToast('⚠️ Debes seleccionar una cantidad');
        return;
    }

    // Validar que la talla exista y no esté vacía
    if (!talla || talla.trim() === '') {
        mostrarToast('⚠️ Debes seleccionar una talla');
        return;
    }

    // Obtener token CSRF
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                     document.querySelector('input[name="_token"]')?.value ||
                     '{{ csrf_token() }}';

    // Enviar solicitud AJAX
    fetch('{{ route("carrito.agregar") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            id: id,
            cantidad: cantidad,
            talla: talla.trim(),
            ficha_id: fichaSeleccionada  // 👈 ENVIAR FICHA
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarToast(`✅ ${nombre} (${talla}) agregado al carrito`);
            document.getElementById(`qty-${id}`).value = 0;
        } else {
            mostrarToast('❌ Error: ' + (data.message || 'No se pudo agregar'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarToast('❌ Error al agregar al carrito');
    });
}

// ✅ FUNCIÓN: Agregar todo al carrito
function agregarTodoAlCarrito() {
    // 👈 NUEVO: Validar que hay ficha seleccionada
    if (!fichaSeleccionada) {
        mostrarToast('⚠️ Debes seleccionar una ficha primero');
        document.getElementById('alerta-ficha').style.display = 'flex';
        return;
    }

    const items = [];

    // Recolectar todos los productos con cantidad > 0
    document.querySelectorAll('[id^="qty-"]').forEach(input => {
        const cantidad = parseInt(input.value) || 0;
        if (cantidad > 0) {
            const id = input.id.replace('qty-', '');

            // 👈 OBTENER TALLA DEL INPUT HIDDEN
            const talla = document.getElementById(`talla-hidden-${id}`)?.value ||
                          document.getElementById(`talla-${id}`)?.value ||
                          null;

            // Validar que la talla exista y no esté vacía
            if (!talla || talla.trim() === '') {
                mostrarToast(`⚠️ El producto ${id} no tiene talla especificada`);
                return;
            }

            items.push({
                id: id,
                cantidad: cantidad,
                talla: talla.trim(),
                ficha_id: fichaSeleccionada  // 👈 ENVIAR FICHA
            });
        }
    });

    // Validar que hay items
    if (items.length === 0) {
        mostrarToast('⚠️ Debes seleccionar al menos un producto');
        return;
    }

    // Obtener token CSRF
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                     document.querySelector('input[name="_token"]')?.value ||
                     '{{ csrf_token() }}';

    // Enviar solicitud AJAX
    fetch('{{ route("carrito.agregarMultiple") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            items: items
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarToast(`✅ ${items.length} producto(s) agregado(s) al carrito`);

            // Resetear todas las cantidades
            document.querySelectorAll('[id^="qty-"]').forEach(input => {
                input.value = 0;
            });
        } else {
            mostrarToast('❌ Error: ' + (data.message || 'No se pudieron agregar'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarToast('❌ Error al agregar productos');
    });
}
</script>

@endsection
