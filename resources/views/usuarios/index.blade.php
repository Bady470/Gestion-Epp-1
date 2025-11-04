@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Gestión de Usuarios</h2>
    <a href="{{ route('usuarios.create') }}" class="btn btn-success mb-3">➕ Nuevo Usuario</a>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Área</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->id }}</td>
                <td>{{ $usuario->nombre_completo }}</td>
                <td>{{ $usuario->email }}</td>
                <td>{{ $usuario->rol->nombre ?? 'Sin rol' }}</td>

                <td>{{ $usuario->area->nombre ?? 'Sin área' }}</td>

                <td>
                    <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-warning btn-sm">✏️ Editar</a>
                    <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar usuario?')">🗑️
                            Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $usuarios->links() }}
</div>
@endsection