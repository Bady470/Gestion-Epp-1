@extends('layouts.dashboard')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">📋 Pedidos Enviados</h2>

    @if($pedidos->count() > 0)
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Instructor</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedidos as $pedido)
            <tr>
                <td>{{ $pedido->id }}</td>
                <td>{{ $pedido->usuario->nombre_completo ?? 'Desconocido' }}</td>
                <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <span class="badge 
                        @if($pedido->estado == 'pendiente') bg-warning text-dark
                        @elseif($pedido->estado == 'enviado') bg-info text-dark
                        @elseif($pedido->estado == 'aprobado') bg-success
                        @else bg-secondary
                        @endif">
                        {{ ucfirst($pedido->estado) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.pedidos.show', $pedido->id) }}" class="btn btn-sm btn-primary">
                        👁️ Ver Detalle
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="alert alert-info">No hay pedidos registrados aún.</div>
    @endif
</div>
@endsection