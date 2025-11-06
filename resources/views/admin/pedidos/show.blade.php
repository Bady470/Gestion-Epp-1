@extends('layouts.dashboard')

@section('content')
<div class="container py-4">
    <h2>🧾 Detalle del Pedido N° {{ $pedido->id }}</h2>
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <p><strong>Instructor:</strong> {{ $pedido->usuario->nombre_completo }}</p>
            <p><strong>Fecha:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Estado:</strong>
                <span class="badge 
                    @if($pedido->estado == 'pendiente') bg-warning text-dark
                    @elseif($pedido->estado == 'enviado') bg-info text-dark
                    @elseif($pedido->estado == 'aprobado') bg-success
                    @else bg-secondary
                    @endif">
                    {{ ucfirst($pedido->estado) }}
                </span>
            </p>
        </div>
    </div>

    <h4>📦 Elementos Solicitados</h4>
    @if($pedido->elementos->count() > 0)
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Área</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedido->elementos as $item)
            <tr>
                <td>{{ $item->nombre }}</td>
                <td>{{ $item->cantidad }}</td>
                <td>{{ $item->area->nombre ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="alert alert-warning">Este pedido no contiene elementos.</div>
    @endif
</div>
@endsection