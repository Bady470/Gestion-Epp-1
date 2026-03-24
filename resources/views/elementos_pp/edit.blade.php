@extends('layouts.app')

@section('content')
<style>
    :root {
        --sena-green: #39A900;
        --sena-blue: #406479;
        --sena-light: #f8f9fa;
    }

    /* Header Section */
    .header-section {
        background: linear-gradient(135deg, var(--sena-blue), var(--sena-green));
        color: white;
        padding: 2.5rem 2rem;
        border-radius: 16px;
        margin-bottom: 2.5rem;
        box-shadow: 0 10px 25px rgba(57, 169, 0, 0.15);
    }

    .header-section h1 {
        font-family: 'Poppins', sans-serif;
        font-weight: 800;
        margin: 0;
        font-size: 2.2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .header-section p {
        margin: 0.5rem 0 0 0;
        opacity: 0.95;
        font-size: 1.05rem;
    }

    /* Card Styles */
    .card-custom {
        background: white;
        border-radius: 16px;
        border: 1px solid #edf2f7;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        margin-bottom: 2.5rem;
        overflow: hidden;
    }

    .card-header-custom {
        background: #f8fafc;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #edf2f7;
        font-weight: 700;
        color: var(--sena-blue);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-body-custom {
        padding: 2rem;
    }

    /* Form Group */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-label .required {
        color: #e53e3e;
        margin-left: 0.25rem;
    }

    /* Input Styles */
    .form-control,
    .form-select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #edf2f7;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f8fafc;
    }

    .form-control:focus,
    .form-select:focus {
        outline: none;
        border-color: var(--sena-green);
        background: white;
        box-shadow: 0 0 0 4px rgba(57, 169, 0, 0.1);
    }

    /* Image Display */
    .image-comparison {
        display: flex;
        gap: 1.5rem;
        margin-top: 1rem;
        flex-wrap: wrap;
    }

    .image-box {
        flex: 1;
        min-width: 200px;
        border: 2px solid #edf2f7;
        border-radius: 12px;
        padding: 1rem;
        text-align: center;
        background: #f8fafc;
    }

    .image-box.new-preview {
        border-style: dashed;
        border-color: var(--sena-green);
        background: #f0fdf4;
    }

    .image-box img {
        max-width: 100%;
        max-height: 150px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .image-box-label {
        display: block;
        font-size: 0.75rem;
        font-weight: 800;
        color: #718096;
        text-transform: uppercase;
        margin-bottom: 0.75rem;
    }

    /* Buttons */
    .btn-custom {
        padding: 0.875rem 2rem;
        border-radius: 12px;
        font-weight: 700;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-update {
        background: linear-gradient(135deg, var(--sena-blue), var(--sena-green));
        color: white;
        box-shadow: 0 6px 15px rgba(57, 169, 0, 0.2);
    }

    .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(57, 169, 0, 0.3);
        filter: brightness(1.1);
        color: white;
    }

    .btn-cancel {
        background: #edf2f7;
        color: #4a5568;
    }

    .btn-cancel:hover {
        background: #e2e8f0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .header-section {
            padding: 2rem 1.5rem;
            text-align: center;
        }

        .header-section h1 {
            font-size: 1.8rem;
            justify-content: center;
        }

        .card-body-custom {
            padding: 1.5rem;
        }

        .btn-custom {
            width: 100%;
            justify-content: center;
        }

        .image-comparison {
            flex-direction: column;
        }
    }
        /* Botón Volver */
    .btn-volver-top {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, var(--sena-blue), var(--sena-green));
        color: white;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(57, 169, 0, 0.2);
    }

    .btn-volver-top:hover {
        transform: translateX(-5px);
        box-shadow: 0 6px 16px rgba(57, 169, 0, 0.3);
        color: white;
    }
</style>

<div class="container py-4">
    <!-- Header -->
    <a href="javascript:history.back()" class="btn-volver-top mb-3" title="Volver atrás">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
    <div class="header-section">
        <h1><i class="bi bi-pencil-square"></i> Editar Elemento PP</h1>
        <p>Actualiza la información técnica y el stock del elemento seleccionado</p>
    </div>

    <div class="card-custom">
        <div class="card-header-custom">
            <i class="bi bi-info-circle-fill"></i> Detalles del Elemento: {{ $elementos_pp->nombre }}
        </div>
        <div class="card-body-custom">
            <form action="{{ route('elementos_pp.update', $elementos_pp) }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- COLUMNA IZQUIERDA -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Nombre del Elemento <span class="required">*</span></label>
                            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                                value="{{ old('nombre', $elementos_pp->nombre) }}" required maxlength="45">
                            @error('nombre') <small class="text-danger fw-bold mt-1 d-block">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Descripción Técnica</label>
                            <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror"
                                rows="4" placeholder="Especificaciones, materiales, etc...">{{ old('descripcion', $elementos_pp->descripcion) }}</textarea>
                            @error('descripcion') <small class="text-danger fw-bold mt-1 d-block">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Gestión de Imagen</label>
                            <input type="file" name="imagen" class="form-control @error('imagen') is-invalid @enderror" accept="image/*">
                            <small class="text-muted mt-1 d-block"><i class="bi bi-info-circle me-1"></i> Deja vacío para mantener la imagen actual.</small>
                            @error('imagen') <small class="text-danger fw-bold mt-1 d-block">{{ $message }}</small> @enderror
                        </div>

                        <div class="image-comparison">
                            <div class="image-box">
                                <span class="image-box-label">Imagen Actual</span>
                                @if($elementos_pp->img_url)
                                    <img src="{{ $elementos_pp->img_url }}" alt="Actual" loading="lazy">
                                @else
                                    <div class="py-4 text-muted small italic">Sin imagen previa</div>
                                @endif
                            </div>
                            <div class="image-box new-preview" id="preview-box" style="display: none;">
                                <span class="image-box-label">Nueva Imagen</span>
                                <img id="preview" src="" alt="Nueva" loading="lazy">
                            </div>
                        </div>
                    </div>

                    <!-- COLUMNA DERECHA -->
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Stock Disponible <span class="required">*</span></label>
                                    <input type="number" name="cantidad" class="form-control @error('cantidad') is-invalid @enderror"
                                        value="{{ old('cantidad', $elementos_pp->cantidad) }}" min="0" required>
                                    @error('cantidad') <small class="text-danger fw-bold mt-1 d-block">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Talla / Medida</label>
                                    <input type="text" name="talla" class="form-control @error('talla') is-invalid @enderror"
                                        value="{{ old('talla', $elementos_pp->talla) }}" placeholder="M, 42, Única...">
                                    @error('talla') <small class="text-danger fw-bold mt-1 d-block">{{ $message }}</small> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Área Asignada</label>
                            <select name="areas_id" class="form-select @error('areas_id') is-invalid @enderror">
                                <option value="">-- Sin área --</option>
                                @foreach($areas as $area)
                                <option value="{{ $area->id }}"
                                    {{ old('areas_id', $elementos_pp->areas_id) == $area->id ? 'selected' : '' }}>
                                    {{ $area->nombre }}
                                </option>
                                @endforeach
                            </select>
                            @error('areas_id') <small class="text-danger fw-bold mt-1 d-block">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tipo de Protección (Filtro)</label>
                            <select name="filtros_id" class="form-select @error('filtros_id') is-invalid @enderror">
                                <option value="">-- Sin filtro --</option>
                                @foreach($filtros as $filtro)
                                <option value="{{ $filtro->id }}"
                                    {{ old('filtros_id', $elementos_pp->filtros_id) == $filtro->id ? 'selected' : '' }}>
                                    {{ $filtro->parte_del_cuerpo }}
                                </option>
                                @endforeach
                            </select>
                            @error('filtros_id') <small class="text-danger fw-bold mt-1 d-block">{{ $message }}</small> @enderror
                        </div>

                        <div class="alert alert-warning border-0 rounded-4 mt-4">
                            <div class="d-flex gap-3">
                                <i class="bi bi-exclamation-triangle-fill fs-4 text-warning"></i>
                                <div class="small">
                                    <strong>Atención:</strong> Al actualizar la cantidad o el área, asegúrate de que la información sea verídica para no afectar los pedidos de los instructores.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-3 mt-4 flex-wrap">
                    <button type="submit" class="btn-custom btn-update">
                        <i class="bi bi-arrow-repeat"></i> Actualizar Elemento
                    </button>
                    <a href="{{ route('elementos_pp.index') }}" class="btn-custom btn-cancel">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.querySelector('input[name="imagen"]')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('preview');
    const previewBox = document.getElementById('preview-box');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            preview.src = event.target.result;
            previewBox.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        previewBox.style.display = 'none';
    }
});
</script>
@endsection
