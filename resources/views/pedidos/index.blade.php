@extends('layouts.app')

@section('content')
<div class="container">
    <h2>📦 Mis Pedidos</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($pedidos->isEmpty())
    <p>No has realizado ningún pedido todavía.</p>
    @else
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Elementos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedidos as $pedido)
            <tr>
                <td>{{ $pedido->id }}</td>
                <td>{{ \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y') }}</td>
                <td>
                    <span class="badge 
                                @if($pedido->estado == 'Pendiente') bg-warning 
                                @elseif($pedido->estado == 'Aprobado') bg-success 
                                @else bg-secondary 
                                @endif">
                        {{ $pedido->estado }}
                    </span>
                </td>
                <td>{{ $pedido->elementos->count() }}</td>
                <td>
                    <a href="{{ route('pedidos.show', $pedido->id) }}" class="btn btn-primary btn-sm">Ver Detalle</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection