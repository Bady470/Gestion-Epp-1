@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Crear Ficha</h2>

    <form action="{{ route('fichas.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Número de Ficha</label>
            <input type="text" name="numero" class="form-control" required maxlength="45">
            @error('numero') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Programa</label>
            <select name="programas_id" class="form-select">
                <option value="">-- Sin programa --</option>
                @foreach($programas as $programa)
                <option value="{{ $programa->id }}">{{ $programa->nombre }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('fichas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection