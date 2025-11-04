@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Solicitudes Pendientes</h2>

    @foreach ($solicitudes as $solicitud)
    <div class="card mb-3 p-3">
        <strong>Instructor:</strong> {{ $solicitud->usuario->name }} <br>
        <strong>Fecha:</strong> {{ $solicitud->created_at->format('d/m/Y') }} <br>
        <a href="{{ route('solicitudes.show', $solicitud->id) }}" class="btn btn-primary mt-2">Ver Detalles</a>
    </div>
    @endforeach
</div>
@endsection