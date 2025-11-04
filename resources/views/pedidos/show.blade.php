@extends('layouts.app')

@section('content')
<div class="container">
    <h2>📦 Detalle del Pedido #{{ $pedido->id }}</h2>
    <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y H:i') }}</p>
    <p><strong>Estado:</strong> {{ $pedido->estado }}</p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Nombre</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedido->elementos as $epp)
            <tr>
                <td><img src="{{ asset('img/' . $epp->img_url) }}" width="100" alt="{{ $epp->nombre }}"></td>
                <td>{{ $epp->nombre }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection