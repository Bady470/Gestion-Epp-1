@extends('layouts.instructores')

@section('content')
<div class="container py-4">
    <h2 class="mb-3 text-center">Pedidos Recibidos - Área: {{ auth()->user()->area->nombre ?? 'No asignada' }}</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($pedidos->count() > 0)
    <!-- BOTÓN GLOBAL -->
    <div class="text-center mb-4">
        <form action="{{ route('lider.enviar.todos') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-success btn-lg"
                onclick="return confirm('¿Enviar los {{ $pedidos->count() }} pedidos pendientes?')">
                Enviar Todos ({{ $pedidos->count() }})
            </button>
        </form>
    </div>

    <!-- LISTA DE PEDIDOS (solo vista) -->
    @foreach($pedidos as $pedido)
    <div class="card mb-3 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <strong>Instructor:</strong> {{ $pedido->usuario->nombre_completo ?? 'Desconocido' }}<br>
                <small class="text-muted">Área: {{ $pedido->usuario->area->nombre ?? 'No asignada' }}</small><br>
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
            <h6>Elementos solicitados:</h6>
            <ul>
                @foreach($pedido->elementos as $item)
                <li>{{ $item->nombre }} ({{ $item->pivot->cantidad ?? 1 }})</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endforeach

    <div class="text-end mt-4">
        <form action="{{ route('lider.enviar.todos') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-primary">
                📤 Enviar todos los pedidos al administrador
            </button>
        </form>
    </div>
    @else
    <div class="alert alert-info text-center">No hay pedidos para tu área ({{ auth()->user()->area->nombre ?? 'No asignada' }}).</div>
    @endif

</div>
@endsection
