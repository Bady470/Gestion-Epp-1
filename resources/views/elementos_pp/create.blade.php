{{-- resources/views/elementos_pp/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Crear Elemento PP</h2>

    {{-- FORMULARIO 1: CREAR ELEMENTO INDIVIDUAL --}}
    <form action="{{ route('elementos_pp.store') }}" method="POST" enctype="multipart/form-data" class="mb-5">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required maxlength="45">
                    @error('nombre') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="3"></textarea>
                </div>

                <!-- IMAGEN -->
                <div class="mb-3">
                    <label class="form-label">Imagen (desde tu PC)</label>
                    <input type="file" name="imagen" class="form-control" accept="image/*">
                    <small class="text-muted">Se guardará en <code>public/img/</code></small>
                    @error('imagen') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mt-3">
                    <img id="preview" src="" style="display:none; max-width:200px;" class="rounded">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Cantidad</label>
                    <input type="number" name="cantidad" class="form-control" value="0" min="0" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Talla</label>
                    <input type="text" name="talla" class="form-control" placeholder="M, 42, Única...">
                </div>

                <!-- ÁREA -->
                <div class="mb-3">
                    <label class="form-label">Área</label>
                    <select name="areas_id" class="form-select">
                        <option value="">-- Sin área --</option>
                        @foreach($areas as $area)
                        <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- FILTRO -->
                <div class="mb-3">
                    <label class="form-label">Filtro</label>
                    <select name="filtros_id" class="form-select">
                        <option value="">-- Sin filtro --</option>
                        @foreach($filtros as $filtro)
                        <option value="{{ $filtro->id }}">{{ $filtro->parte_del_cuerpo }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('elementos_pp.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>



    {{-- FORMULARIO 2: SUBIR ARCHIVO EXCEL --}}
    <div class="card">
        <div class="card-body">
            <h4>Cargar Elementos PP desde Excel</h4>
            <p class="text-muted">Sube un archivo .xlsx con todos los elementos que deseas cargar.</p>

            <form action="{{ route('elementos_pp.import') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Archivo Excel</label>
                    <input type="file" name="excel" class="form-control" accept=".xlsx" required>
                    @error('excel') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <button type="submit" class="btn btn-primary">Importar Excel</button>
            </form>
        </div>
    </div>
</div>

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
