@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detalles de la Solicitud</h2>

    <p><strong>Instructor:</strong> {{ $pedido->usuario->name }}</p>
    <p><strong>Fecha:</strong> {{ $pedido->created_at->format('d/m/Y') }}</p>

    <table class="table">
        <thead>
            <tr>
                <th>Elemento</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pedido->items as $item)
            <tr>
                <td>{{ $item->elemento->nombre }}</td>
                <td>{{ $item->cantidad }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <form action="{{ route('solicitudes.enviar', $pedido->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success">Enviar al Administrador</button>
    </form>
</div>
@endsection