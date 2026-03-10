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

    /* Image Preview */
    .preview-container {
        margin-top: 1rem;
        border: 2px dashed #cbd5e0;
        border-radius: 12px;
        padding: 1rem;
        text-align: center;
        background: #f7fafc;
        min-height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #preview {
        max-width: 100%;
        max-height: 200px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    /* Buttons */
    .btn-custom {
        padding: 0.75rem 1.5rem;
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

    .btn-sena {
        background: linear-gradient(135deg, var(--sena-blue), var(--sena-green));
        color: white;
        box-shadow: 0 6px 15px rgba(57, 169, 0, 0.2);
    }

    .btn-sena:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(57, 169, 0, 0.3);
        filter: brightness(1.1);
        color: white;
    }

    .btn-excel {
        background: #1D6F42;
        color: white;
    }

    .btn-excel:hover {
        background: #155231;
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

        .d-flex-mobile-column {
            flex-direction: column;
            gap: 1rem;
        }
    }
</style>

<div class="container py-4">
    <!-- Header -->
    <a href="javascript:history.back()" class="btn-volver-top mb-3" title="Volver atrás">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
    <div class="header-section">
        <h1><i class="bi bi-shield-plus"></i> Crear Elemento PP</h1>
        <p>Registra un nuevo Elemento de Protección Personal en el inventario</p>
    </div>

    {{-- FORMULARIO 1: CREAR ELEMENTO INDIVIDUAL --}}
    <div class="card-custom">
        <div class="card-header-custom">
            <i class="bi bi-pencil-square"></i> Información del Elemento
        </div>
        <div class="card-body-custom">
            <form action="{{ route('elementos_pp.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Nombre <span class="required">*</span></label>
                            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" placeholder="Ej: Casco de Seguridad" required maxlength="45" value="{{ old('nombre') }}">
                            @error('nombre') <small class="text-danger fw-bold mt-1 d-block">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="4" placeholder="Detalles técnicos del elemento...">{{ old('descripcion') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Imagen del Producto</label>
                            <input type="file" name="imagen" class="form-control @error('imagen') is-invalid @enderror" accept="image/*">
                            <small class="text-muted mt-1 d-block"><i class="bi bi-info-circle me-1"></i> Formatos permitidos: JPG, PNG. Máx 2MB.</small>
                            @error('imagen') <small class="text-danger fw-bold mt-1 d-block">{{ $message }}</small> @enderror
                        </div>

                        <div class="preview-container mb-3">
                            <img id="preview" src="" style="display:none;" alt="Vista previa">
                            <div id="preview-placeholder" class="text-muted">
                                <i class="bi bi-image display-4 d-block mb-2"></i>
                                <span>Vista previa de imagen</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Cantidad Inicial <span class="required">*</span></label>
                                    <input type="number" name="cantidad" class="form-control" value="{{ old('cantidad', 0) }}" min="0" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Talla / Medida</label>
                                    <input type="text" name="talla" class="form-control" placeholder="M, 42, Única..." value="{{ old('talla') }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Área de Aplicación</label>
                            <select name="areas_id" class="form-select">
                                <option value="">-- Seleccionar Área --</option>
                                @foreach($areas as $area)
                                <option value="{{ $area->id }}" {{ old('areas_id') == $area->id ? 'selected' : '' }}>{{ $area->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tipo de Protección (Filtro)</label>
                            <select name="filtros_id" class="form-select">
                                <option value="">-- Seleccionar Filtro --</option>
                                @foreach($filtros as $filtro)
                                <option value="{{ $filtro->id }}" {{ old('filtros_id') == $filtro->id ? 'selected' : '' }}>{{ $filtro->parte_del_cuerpo }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="alert alert-info border-0 rounded-4 mt-4">
                            <div class="d-flex gap-3">
                                <i class="bi bi-lightbulb-fill fs-4 text-primary"></i>
                                <div class="small">
                                    <strong>Consejo:</strong> Asegúrate de que la imagen sea clara para que los instructores puedan identificar el elemento fácilmente al realizar sus pedidos.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-3 mt-4 d-flex-mobile-column">
                    <button type="submit" class="btn-custom btn-sena">
                        <i class="bi bi-cloud-arrow-up-fill"></i> Guardar Elemento
                    </button>
                    <a href="{{ route('elementos_pp.index') }}" class="btn-custom btn-cancel">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- FORMULARIO 2: SUBIR ARCHIVO EXCEL --}}
    <div class="card-custom">
        <div class="card-header-custom" style="background: #f0fdf4; color: #166534;">
            <i class="bi bi-file-earmark-excel-fill"></i> Carga Masiva desde Excel
        </div>
        <div class="card-body-custom">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h4 class="fw-bold text-dark mb-2">¿Tienes muchos elementos?</h4>
                    <p class="text-muted mb-4">Sube un archivo .xlsx con el formato establecido para cargar múltiples elementos de protección personal de una sola vez.</p>

                    <form action="{{ route('elementos_pp.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Seleccionar Archivo Excel</label>
                            <div class="input-group">
                                <input type="file" name="excel" class="form-control @error('excel') is-invalid @enderror" accept=".xlsx" required>
                                <button type="submit" class="btn btn-success px-4 fw-bold">
                                    <i class="bi bi-upload me-2"></i> Importar
                                </button>
                            </div>
                            @error('excel') <small class="text-danger fw-bold mt-1 d-block">{{ $message }}</small> @enderror
                        </div>
                    </form>
                </div>
                <div class="col-lg-5 d-none d-lg-block text-center">
                    <i class="bi bi-file-earmark-spreadsheet text-success opacity-25" style="font-size: 8rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelector('input[name="imagen"]')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('preview');
    const placeholder = document.getElementById('preview-placeholder');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            preview.src = event.target.result;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        }
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
        placeholder.style.display = 'block';
    }
});
</script>
@endsection
