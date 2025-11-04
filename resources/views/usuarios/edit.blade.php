@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Editar Usuario</h2>

    <form action="{{ route('usuarios.update', $usuario) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Nombre completo</label>
            <input type="text" name="nombre_completo" class="form-control" value="{{ $usuario->nombre_completo }}"
                required>
        </div>

        <div class="mb-3">
            <label>Correo electrónico</label>
            <input type="email" name="email" class="form-control" value="{{ $usuario->email }}" required>
        </div>

        <div class="mb-3">
            <label>Nueva contraseña (opcional)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label>Rol</label>
            <select name="rol_id" class="form-select">
                <option value="">-- Selecciona un rol --</option>
                @foreach($roles as $rol)
                <option value="{{ $rol->id }}" @if($usuario->rol_id == $rol->id) selected @endif>
                    {{ $rol->nombre }}
                </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">Actualizar</button>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection