@extends('layouts.app')

@section('content')
    <pre>{{ print_r($pedido->elementos->first()->pivot->toArray(), true) }}</pre>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>📦 Detalle del Pedido #{{ $pedido->id }}</h2>
            <span
                class="badge p-2
            @if ($pedido->estado == 'Pendiente') bg-warning text-dark
            @elseif($pedido->estado == 'Aprobado') bg-success
            @else bg-secondary @endif">
                Estado: {{ $pedido->estado }}
            </span>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <p class="mb-1"><strong>Fecha de Solicitud:</strong>
                    {{ \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y H:i') }}</p>
                <p class="mb-0"><strong>Instructor:</strong> {{ $pedido->usuario->nombre_completo ?? 'No disponible' }}</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle border">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">Imagen</th>
                        <th>Nombre del Elemento (EPP)</th>
                        <th class="text-center">Cantidad Solicitada</th> <!-- 👈 NUEVA COLUMNA -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pedido->elementos as $epp)
                        <tr>
                            <td class="text-center">
                                <img src="{{ asset('img/' . $epp->img_url) }}" width="80" class="rounded border" loading="lazy">
                            </td>
                            <td>
                                <div class="fw-bold">{{ $epp->nombre }}</div>
                            </td>
                            <td class="text-center">
                                <!-- 🎯 USAMOS EL NOMBRE EXACTO DE LA COLUMNA QUE VISTE EN EL SELECT -->
                                <span class="fs-5 fw-bold text-primary">
                                    {{ $epp->pivot->cantidad }}
                                </span>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <a href="{{ route('pedidos.index') }}" class="btn btn-secondary px-4">
                <i class="bi bi-arrow-left"></i> Volver al listado
            </a>
        </div>
    </div>
@endsection
