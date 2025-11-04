@extends('layouts.dashboard')

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
                    <th>Cantidad</th>
                    <th>Disponible</th>
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
                    <td class="text-center">{{ $item['cantidad'] }}</td>
                    <td class="text-center">{{ $item['disponible'] ?? 'N/D' }}</td>
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

    {{-- 🔹 Botón para confirmar y enviar el pedido al líder --}}
    <div class="d-flex justify-content-end mt-4">
        <form action="{{ route('carrito.confirmar') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary btn-lg fw-bold">
                📦 Confirmar pedido y enviar al líder
            </button>
        </form>
    </div>

    @else
    <div class="alert alert-info text-center mt-4">
        Tu carrito está vacío.
    </div>
    @endif
</div>
@endsection