@extends('layouts.instructores')

@section('content')
<div class="container py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
        <h2 class="mb-0 text-center text-md-start">🛒 Carrito de Pedido</h2>
        @if (count($carrito) > 0)
            <a href="{{ route('dashboard.instructor') }}" class="btn btn-outline-secondary d-none d-md-inline-flex align-items-center">
                <i class="bi bi-arrow-left me-2"></i> Volver
            </a>
        @endif
    </div>

    @if (count($carrito) > 0)
    <div class="row g-4">
        {{-- Columna Principal: Lista de Productos --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-header bg-white py-3 d-none d-md-block">
                    <h5 class="mb-0 text-primary fw-bold">Productos en el Carrito</h5>
                </div>

                {{-- Vista para Escritorio (Tabla) --}}
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th style="width: 100px;">Imagen</th>
                                <th>Producto</th>
                                <th>Talla</th>
                                <th>Cantidad</th>
                                <th>Stock</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($carrito as $key => $item)
                            <tr>
                                <td class="text-center">
                                    @if(isset($item['img_url']) && $item['img_url'])
                                        <img src="{{ asset($item['img_url']) }}" width="70" height="70" class="rounded object-fit-cover shadow-sm border">
                                    @else
                                        <div class="bg-light rounded border d-flex align-items-center justify-content-center mx-auto" style="width: 70px; height: 70px;">
                                            <i class="bi bi-image text-muted fs-3"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $item['nombre'] ?? 'Producto sin nombre' }}</div>
                                    <small class="text-muted">ID: #{{ $key }}</small>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary rounded-pill px-3">{{ $item['talla'] ?? 'N/A' }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="fw-bold fs-5 text-primary">{{ $item['cantidad'] }}</div>
                                </td>
                                <td class="text-center">
                                    @php
                                        $disponible = $item['disponible'] ?? 0;
                                        $quedara = $disponible - $item['cantidad'];
                                    @endphp
                                    <div class="small mb-1">Disponible: <span class="fw-bold">{{ $disponible }}</span></div>
                                    @if($quedara >= 0)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Quedarán: {{ $quedara }}</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill">⚠️ Stock insuficiente</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('carrito.eliminar', $key) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm rounded-circle p-2" title="Eliminar">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Vista para Móvil (Cards) --}}
                <div class="d-md-none">
                    @foreach($carrito as $key => $item)
                    <div class="p-3 border-bottom position-relative">
                        <div class="d-flex gap-3">
                            <div class="flex-shrink-0">
                                @if(isset($item['img_url']) && $item['img_url'])
                                    <img src="{{ asset($item['img_url']) }}" width="80" height="80" class="rounded object-fit-cover border shadow-sm">
                                @else
                                    <div class="bg-light rounded border d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                        <i class="bi bi-image text-muted fs-2"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h6 class="fw-bold mb-1 text-dark">{{ $item['nombre'] ?? 'Producto sin nombre' }}</h6>
                                    <form action="{{ route('carrito.eliminar', $key) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-link text-danger p-0 border-0">
                                            <i class="bi bi-x-circle-fill fs-5"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="mb-2">
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill me-1">Talla: {{ $item['talla'] ?? 'N/A' }}</span>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill">Cant: {{ $item['cantidad'] }}</span>
                                </div>

                                @php
                                    $disponible = $item['disponible'] ?? 0;
                                    $quedara = $disponible - $item['cantidad'];
                                @endphp

                                <div class="bg-light p-2 rounded small">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Disponible ahora:</span>
                                        <span class="fw-bold">{{ $disponible }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Quedará después:</span>
                                        @if($quedara >= 0)
                                            <span class="text-success fw-bold">{{ $quedara }}</span>
                                        @else
                                            <span class="text-danger fw-bold">⚠️ Insuficiente</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Columna Lateral: Resumen y Acciones --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 1.5rem; z-index: 10;">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-dark">Resumen del Pedido</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush mb-3">
                        @php $totalDescuento = 0; @endphp
                        @foreach($carrito as $item)
                            @php $totalDescuento += $item['cantidad']; @endphp
                            <div class="list-group-item px-0 py-2 border-0 d-flex justify-content-between align-items-center small">
                                <span class="text-muted text-truncate me-2" style="max-width: 180px;">{{ $item['nombre'] }} ({{ $item['talla'] }})</span>
                                <span class="fw-bold text-dark">- {{ $item['cantidad'] }}</span>
                            </div>
                        @endforeach
                    </div>

                    <hr class="my-3">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="h6 mb-0 fw-bold">Total a descargar:</span>
                        <span class="badge bg-danger fs-6 rounded-pill px-3">{{ $totalDescuento }} unidades</span>
                    </div>

                    <form action="{{ route('carrito.confirmar') }}" method="POST" class="d-grid gap-2">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-lg fw-bold py-3 shadow-sm">
                            <i class="bi bi-box-seam me-2"></i> Confirmar Pedido
                        </button>
                        <a href="{{ route('dashboard.instructor') }}" class="btn btn-light btn-lg border d-md-none">
                            <i class="bi bi-arrow-left me-2"></i> Volver
                        </a>
                    </form>

                    <div class="mt-3 text-center">
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i> El pedido será enviado a tu líder para aprobación.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @else
    <div class="card border-0 shadow-sm py-5 text-center">
        <div class="card-body">
            <div class="mb-4">
                <i class="bi bi-cart-x text-muted" style="font-size: 5rem;"></i>
            </div>
            <h4 class="fw-bold">Tu carrito está vacío</h4>
            <p class="text-muted mb-4">Parece que aún no has agregado elementos para crear un pedido.</p>
            <a href="{{ route('dashboard.instructor') }}" class="btn btn-primary btn-lg px-5 rounded-pill">
                <i class="bi bi-plus-circle me-2"></i> Explorar Elementos
            </a>
        </div>
    </div>
    @endif
</div>

<style>
    /* Mejoras estéticas generales */
    body {
        background-color: #f8f9fa;
    }

    .card {
        border-radius: 1rem;
    }

    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #6c757d;
    }

    .object-fit-cover {
        object-fit: cover;
    }

    .btn-primary {
        background: linear-gradient(45deg, #0d6efd, #0a58ca);
        border: none;
    }

    .btn-primary:hover {
        background: linear-gradient(45deg, #0a58ca, #084298);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(13, 110, 253, 0.2);
    }

    .badge {
        font-weight: 500;
    }

    /* Ajustes para dispositivos móviles */
    @media (max-width: 767.98px) {
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        h2 {
            font-size: 1.5rem;
        }

        .sticky-top {
            position: relative !important;
            top: 0 !important;
        }
    }
</style>

{{-- Asegúrate de tener Bootstrap Icons incluido en tu layout principal --}}
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"> --}}
@endsection
