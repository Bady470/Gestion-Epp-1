@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Crear Programa</h2>

    <form action="{{ route('programas.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nombre del Programa</label>
            <input type="text" name="nombre" class="form-control" required maxlength="45">
            @error('nombre') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Área</label>
            <select name="areas_id" class="form-select">
                <option value="">-- Sin área --</option>
                @foreach($areas as $area)
                <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('programas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection