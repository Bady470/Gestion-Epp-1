{{-- resources/views/elementos_pp/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Editar Elemento PP</h2>

    <form action="{{ route('elementos_pp.update', $elementos_pp) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- COLUMNA IZQUIERDA -->
            <div class="col-md-6">
                <!-- NOMBRE -->
                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                        value="{{ old('nombre', $elementos_pp->nombre) }}" required maxlength="45">
                    @error('nombres') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <!-- DESCRIPCIÓN -->
                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror"
                        rows="3">{{ old('descripcion', $elementos_pp->descripcion) }}</textarea>
                    @error('descripcion') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <!-- IMAGEN ACTUAL -->
                <div class="mb-3">
                    <label class="form-label">Imagen Actual</label><br>
                    @if($elementos_pp->img_url)
                    <img src="{{ $elementos_pp->img_url }}" alt="Imagen actual" width="120"
                        class="rounded mb-2 shadow-sm">
                    @else
                    <p class="text-muted fst-italic">Sin imagen</p>
                    @endif
                </div>

                <!-- CAMBIAR IM

AGEN -->
                <div class="mb-3">
                    <label class="form-label">Cambiar Imagen (desde tu PC)</label>
                    <input type="file" name="imagen" class="form-control @error('imagen') is-invalid @enderror"
                        accept="image/*">
                    <small class="text-muted">Deja vacío para mantener la actual. Se guardará en
                        <code>public/img/</code></small>
                    @error('imagen') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <!-- VISTA PREVIA -->
                <div class="mt-3">
                    <img id="preview" src="" style="display:none; max-width:200px; border-radius:8px;"
                        class="shadow-sm">
                </div>
            </div>

            <!-- COLUMNA DERECHA -->
            <div class="col-md-6">
                <!-- CANTIDAD -->
                <div class="mb-3">
                    <label class="form-label">Cantidad</label>
                    <input type="number" name="cantidad" class="form-control @error('cantidad') is-invalid @enderror"
                        value="{{ old('cantidad', $elementos_pp->cantidad) }}" min="0" required>
                    @error('cantidad') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <!-- TALLA -->
                <div class="mb-3">
                    <label class="form-label">Talla</label>
                    <input type="text" name="talla" class="form-control @error('talla') is-invalid @enderror"
                        value="{{ old('talla', $elementos_pp->talla) }}" placeholder="M, 42, Única...">
                    @error('talla') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <!-- ÁREA: areas_id -->
                <div class="mb-3">
                    <label class="form-label">Área</label>
                    <select name="areas_id" class="form-select @error('areas_id') is-invalid @enderror">
                        <option value="">-- Sin área --</option>
                        @foreach($areas as $area)
                        <option value="{{ $area->id }}"
                            {{ old('areas_id', $elementos_pp->areas_id) == $area->id ? 'selected' : '' }}>
                            {{ $area->nombre }}
                        </option>
                        @endforeach
                    </select>
                    @error('areas_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <!-- FILTRO: filtros_id -->
                <div class="mb-3">
                    <label class="form-label">Filtro</label>
                    <select name="filtros_id" class="form-select @error('filtros_id') is-invalid @enderror">
                        <option value="">-- Sin filtro --</option>
                        @foreach($filtros as $filtro)
                        <option value="{{ $filtro->id }}"
                            {{ old('filtros_id', $elementos_pp->filtros_id) == $filtro->id ? 'selected' : '' }}>
                            {{ $filtro->parte_del_cuerpo }}
                        </option>
                        @endforeach
                    </select>
                    @error('filtros_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
        </div>

        <!-- BOTONES -->
        <div class="mt-4">
            <button type="submit" class="btn btn-warning btn-lg">Actualizar</button>
            <a href="{{ route('elementos_pp.index') }}" class="btn btn-secondary btn-lg">Cancelar</a>
        </div>
    </form>
</div>

<!-- VISTA PREVIA DE IMAGEN -->
<script>
document.querySelector('input[name="imagen"]')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('preview');
    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }
});
</script>
@endsection