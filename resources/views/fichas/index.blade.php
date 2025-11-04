@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Gestión de Fichas</h2>
    <a href="{{ route('fichas.create') }}" class="btn btn-success mb-3">Nueva Ficha</a>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Número</th>
                <th>Programa</th>
                <th>Creada</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($fichas as $ficha)
            <tr>
                <td>{{ $ficha->id }}</td>
                <td>{{ $ficha->numero }}</td>
                <td>{{ $ficha->programa?->nombre ?? 'Sin programa' }}</td>
                <td>{{ $ficha->created_at->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('fichas.edit', $ficha) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('fichas.destroy', $ficha) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('¿Eliminar esta ficha?')">
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $fichas->links() }}
</div>
@endsection