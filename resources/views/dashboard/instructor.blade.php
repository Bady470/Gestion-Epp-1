@extends('layouts.instructores')

@section('content')
<div class="text-end mb-3">
    <a href="{{ route('carrito.index') }}" class="btn btn-success">
        Ver carrito 🛒
    </a>
</div>

<div class="container py-4">
    <h2 class="mb-3 text-center">👋 Bienvenido, {{ $user->nombre_completo }}</h2>
    <p class="text-center text-muted">Área asignada:
        <strong>{{ $user->area->nombre ?? 'Sin área' }}</strong>
    </p>

    @if ($elementos->count() > 0)

    <!-- Botón Agregar Todo al Carrito -->
    <div class="mb-4">
        <button type="button" class="btn btn-success btn-lg fw-bold" id="agregarTodoBtn" onclick="agregarTodoAlCarrito()">
            ✅ Agregar Todo al Carrito
        </button>
    </div>

    <div class="row mt-4">
        @foreach ($elementos as $epp)
        <div class="col-md-4 col-sm-6 mb-4">
            <div class="card shadow-sm h-100 border-0" id="card-{{ $epp->id }}">

                <img src="{{ asset($epp->img_url) }}" class="card-img-top" alt="{{ $epp->nombre }}"
                    style="height: 200px; object-fit: cover;">

                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title">{{ $epp->nombre }}</h5>
                        <p class="text-muted small mb-1">
                            Área: <strong>{{ $epp->area->nombre ?? '-' }}</strong>
                        </p>
                        <p class="text-muted small mb-1">
                            Filtro: <strong>{{ $epp->filtro->parte_del_cuerpo ?? '-' }}</strong>
                        </p>
                        <p class="text-muted small mb-2">
                            Cantidad disponible: <strong>{{ $epp->cantidad }}</strong>
                        </p>
                    </div>

                    <div class="mt-auto">
                        <div class="input-group mb-3">
                            <button class="btn btn-outline-secondary btn-sm" type="button"
                                onclick="changeQuantity('{{ $epp->id }}', -1)">−</button>
                            <input type="number" id="qty-{{ $epp->id }}" class="form-control text-center" value="0"
                                min="0" max="{{ $epp->cantidad }}">
                            <button class="btn btn-outline-secondary btn-sm" type="button"
                                onclick="changeQuantity('{{ $epp->id }}',1)">+</button>
                        </div>

                        <div class="d-grid gap-2">
                            <!-- Botón Agregar Individual sin redirección -->
                            <button type="button" class="btn btn-warning btn-sm text-dark fw-bold"
                                onclick="agregarAlCarritoAjax('{{ $epp->id }}', '{{ $epp->nombre }}')">
                                🛒 Agregar al carrito
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $elementos->links() }}
    </div>
    @else
    <div class="alert alert-info text-center mt-4">
        No hay elementos disponibles para tu área.
    </div>
    @endif
</div>

<!-- Toast para notificaciones -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="toastNotificacion" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white">
            <strong class="me-auto">✅ Éxito</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toastMensaje">
            Producto agregado al carrito
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Cambiar cantidad con botones + y -
function changeQuantity(id, delta) {
    const input = document.getElementById(`qty-${id}`);
    let value = parseInt(input.value) || 0;
    const max = parseInt(input.max);
    value += delta;
    if (value < 1) value = 0;
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

// Agregar producto individual sin redirección
function agregarAlCarritoAjax(id, nombre) {
    const cantidad = parseInt(document.getElementById(`qty-${id}`).value) || 0;

    // Validar que la cantidad sea mayor a 0
    if (cantidad <= 0) {
        mostrarToast('⚠️ Debes seleccionar una cantidad');
        return;
    }

    console.log('Agregando:', { id, cantidad, nombre });

    // Obtener token CSRF
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                     document.querySelector('input[name="_token"]')?.value ||
                     '{{ csrf_token() }}';

    console.log('CSRF Token:', csrfToken);

    // Enviar solicitud AJAX con headers correctos
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
            cantidad: cantidad
        })
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers.get('content-type'));
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            // Mostrar notificación
            mostrarToast(`✅ ${nombre} agregado al carrito`);

            // Resetear cantidad
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

// Agregar todo al carrito
function agregarTodoAlCarrito() {
    const items = [];

    // Recolectar todos los productos con cantidad > 0
    document.querySelectorAll('[id^="qty-"]').forEach(input => {
        const cantidad = parseInt(input.value) || 0;
        if (cantidad > 0) {
            const id = input.id.replace('qty-', '');
            items.push({
                id: id,
                cantidad: cantidad
            });
        }
    });

    // Validar que hay items
    if (items.length === 0) {
        mostrarToast('⚠️ Debes seleccionar al menos un producto');
        return;
    }

    console.log('Agregando múltiples:', items);

    // Obtener token CSRF
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                     document.querySelector('input[name="_token"]')?.value ||
                     '{{ csrf_token() }}';

    // Enviar solicitud AJAX para agregar múltiples
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
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
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
