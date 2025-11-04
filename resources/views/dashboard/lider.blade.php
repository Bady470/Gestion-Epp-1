@extends('layouts.dashboard')

@section('content')
<div class="container py-4">
    <h2 class="mb-3 text-center">📋 Pedidos Recibidos</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($pedidos->count() > 0)
    @foreach($pedidos as $pedido)
    <div class="card mb-3 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <strong>Instructor:</strong> {{ $pedido->usuario->nombre_completo ?? 'Desconocido' }}<br>
                <small class="text-muted">Fecha: {{ $pedido->created_at->format('d/m/Y H:i') }}</small>
            </div>
            <span class="badge 
                        @if($pedido->estado == 'pendiente') bg-warning text-dark
                        @elseif($pedido->estado == 'enviado') bg-info text-dark
                        @elseif($pedido->estado == 'aprobado') bg-success
                        @else bg-secondary @endif">
                {{ ucfirst($pedido->estado) }}
            </span>
        </div>

        <div class="card-body">
            <h6>🧰 Elementos solicitados:</h6>
            <ul>
                @foreach($pedido->elementos as $item)
                <li>{{ $item->nombre }} ({{ $item->pivot->cantidad ?? 1 }})</li>
                @endforeach
            </ul>

            <form action="{{ route('lider.enviar', $pedido->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary btn-sm">📤 Enviar al administrador</button>
            </form>
        </div>
    </div>
    @endforeach
    @else
    <div class="alert alert-info text-center">No hay pedidos pendientes.</div>
    @endif
</div>
@endsection