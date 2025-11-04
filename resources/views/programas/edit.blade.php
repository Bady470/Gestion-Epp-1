@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Editar Programa</h2>

    <form action="{{ route('programas.update', $programa) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nombre del Programa</label>
            <input type="text" name="nombre" class="form-control" value="{{ $programa->nombre }}" required
                maxlength="45">
            @error('nombre') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Área</label>
            <select name="areas_id" class="form-select">
                <option value="">-- Sin área --</option>
                @foreach($areas as $area)
                <option value="{{ $area->id }}" {{ $programa->areas_id == $area->id ? 'selected' : '' }}>
                    {{ $area->nombre }}
                </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('programas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection