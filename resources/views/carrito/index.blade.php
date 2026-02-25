@extends('layouts.instructores')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">🛒 Carrito de Pedido</h2>

    @if (count($carrito) > 0)
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr class="text-center">
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Cantidad a Pedir</th>
                    <th>Disponible Ahora</th>
                    <th>Quedará Después</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($carrito as $item)
                <tr>
                    <td class="text-center">
                        <img src="{{ asset($item['img_url']) }}" width="80" class="rounded">
                    </td>
                    <td>{{ $item['nombre'] }}</td>
                    <td class="text-center">
                        <span class="badge bg-primary">{{ $item['cantidad'] }}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-success">{{ $item['disponible'] ?? 'N/D' }}</span>
                    </td>
                    <td class="text-center">
                        @php
                            $quedara = ($item['disponible'] ?? 0) - $item['cantidad'];
                        @endphp
                        @if($quedara >= 0)
                            <span class="badge bg-info">{{ $quedara }}</span>
                        @else
                            <span class="badge bg-danger">⚠️ Stock insuficiente</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <form action="{{ route('carrito.eliminar', $item['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                ❌ Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- 🔹 Resumen del descuento --}}
    <div class="card mt-4 bg-light">
        <div class="card-body">
            <h5 class="card-title">📊 Resumen del Descuento de Inventario</h5>
            <table class="table table-sm mb-0">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th class="text-center">Disponible</th>
                        <th class="text-center">Se Descargará</th>
                        <th class="text-center">Quedará</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalDescuento = 0;
                    @endphp
                    @foreach($carrito as $item)
                    @php
                        $quedara = ($item['disponible'] ?? 0) - $item['cantidad'];
                        $totalDescuento += $item['cantidad'];
                    @endphp
                    <tr>
                        <td>{{ $item['nombre'] }}</td>
                        <td class="text-center">
                            <strong>{{ $item['disponible'] ?? 'N/D' }}</strong>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-warning text-dark">- {{ $item['cantidad'] }}</span>
                        </td>
                        <td class="text-center">
                            @if($quedara >= 0)
                                <strong class="text-success">{{ $quedara }}</strong>
                            @else
                                <strong class="text-danger">⚠️ Error</strong>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <hr>
            <p class="mb-0">
                <strong>Total de elementos a descargar:</strong>
                <span class="badge bg-danger">{{ $totalDescuento }}</span>
            </p>
        </div>
    </div>

    {{-- 🔹 Botón para confirmar y enviar el pedido al líder --}}
    <div class="d-flex justify-content-end mt-4 gap-2">
        <a href="{{ route('carrito.index') }}" class="btn btn-secondary btn-lg">
            ← Volver
        </a>
        <form action="{{ route('carrito.confirmar') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary btn-lg fw-bold">
                📦 Confirmar pedido y enviar al líder
            </button>
        </form>
    </div>

    @else
    <div class="alert alert-info text-center mt-4">
        <h5>Tu carrito está vacío</h5>
        <p>Agrega elementos para crear un pedido.</p>
    </div>
    @endif
</div>

<style>
    .table-responsive {
        border-radius: 0.5rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .card {
        border-radius: 0.5rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .badge {
        padding: 0.5rem 0.75rem;
        font-size: 0.9rem;
    }
</style>
@endsection
