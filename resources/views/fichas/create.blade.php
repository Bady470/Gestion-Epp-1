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
        margin-bottom: 1.5rem;
    }

    .btn-volver-top:hover {
        transform: translateX(-5px);
        box-shadow: 0 6px 16px rgba(57, 169, 0, 0.3);
        color: white;
    }

    /* Form Container */
    .form-container {
        background: white;
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid #edf2f7;
    }

    /* Form Group */
    .form-group {
        margin-bottom: 2rem;
    }

    .form-group:last-of-type {
        margin-bottom: 2.5rem;
    }

    .form-label {
        display: block;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 0.75rem;
        font-size: 1rem;
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
        padding: 0.875rem 1rem;
        border: 2px solid #edf2f7;
        border-radius: 12px;
        font-size: 1rem;
        font-family: inherit;
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

    .form-control::placeholder {
        color: #a0aec0;
    }

    /* Error Styles */
    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: #e53e3e;
        background: #fff5f5;
    }

    .form-control.is-invalid:focus,
    .form-select.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(229, 62, 62, 0.1);
    }

    .error-message {
        display: block;
        color: #e53e3e;
        font-size: 0.875rem;
        font-weight: 600;
        margin-top: 0.5rem;
    }

    /* Info Box */
    .info-box {
        background: #e1f5fe;
        border-left: 4px solid #0288d1;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        display: flex;
        gap: 1rem;
    }

    .info-box i {
        font-size: 1.5rem;
        color: #0288d1;
        flex-shrink: 0;
    }

    .info-box-content {
        flex: 1;
    }

    .info-box-title {
        font-weight: 700;
        color: #01579b;
        margin-bottom: 0.25rem;
    }

    .info-box-text {
        color: #0277bd;
        font-size: 0.95rem;
    }

    /* Button Group */
    .button-group {
        display: flex;
        gap: 1rem;
        margin-top: 2.5rem;
        flex-wrap: wrap;
    }

    .btn-custom {
        padding: 0.875rem 2rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--sena-blue), var(--sena-green));
        color: white;
        box-shadow: 0 10px 20px rgba(57, 169, 0, 0.2);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(57, 169, 0, 0.3);
        filter: brightness(1.1);
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    .btn-secondary {
        background: #e2e8f0;
        color: #4a5568;
        border: 1px solid #cbd5e0;
    }

    .btn-secondary:hover {
        background: #cbd5e0;
        color: #2d3748;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .header-section {
            padding: 2rem 1.5rem;
            margin-bottom: 2rem;
        }

        .header-section h1 {
            font-size: 1.8rem;
        }

        .form-container {
            padding: 1.5rem;
        }

        .button-group {
            flex-direction: column;
        }

        .btn-custom {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .header-section {
            padding: 1.5rem 1rem;
        }

        .header-section h1 {
            font-size: 1.5rem;
        }

        .form-container {
            padding: 1.25rem;
            border-radius: 12px;
        }

        .form-label {
            font-size: 0.9rem;
        }

        .form-control,
        .form-select {
            font-size: 16px; /* Previene zoom en iOS */
        }
    }
</style>

<div class="container py-4">
    <!-- Botón de Volver -->
    <a href="javascript:history.back()" class="btn-volver-top" title="Volver atrás">
        <i class="bi bi-arrow-left"></i> Volver
    </a>

    <!-- Header -->
    <div class="header-section">
        <h1><i class="bi bi-journal-plus"></i> Crear Ficha</h1>
        <p>Registra una nueva ficha de formación en el sistema</p>
    </div>

    <!-- Info Box -->
    <div class="info-box">
        <i class="bi bi-info-circle-fill"></i>
        <div class="info-box-content">
            <div class="info-box-title">Información Importante</div>
            <div class="info-box-text">
                Completa los datos requeridos para crear una nueva ficha. El número de ficha debe ser único y fácil de identificar.
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <div class="form-container">
        <form action="{{ route('fichas.store') }}" method="POST" novalidate>
            @csrf

            <!-- Número de Ficha -->
            <div class="form-group">
                <label class="form-label" for="numero">
                    Número de Ficha
                    <span class="required">*</span>
                </label>
                <input
                    type="text"
                    id="numero"
                    name="numero"
                    class="form-control @error('numero') is-invalid @enderror"
                    placeholder="Ej: FICHA-2024-001"
                    value="{{ old('numero') }}"
                    maxlength="45"
                    required
                    autofocus
                >
                @error('numero')
                    <span class="error-message">
                        <i class="bi bi-exclamation-circle-fill me-1"></i> {{ $message }}
                    </span>
                @enderror
            </div>

            <!-- Programa -->
            <div class="form-group">
                <label class="form-label" for="programas_id">
                    Programa de Formación
                </label>
                <select
                    id="programas_id"
                    name="programas_id"
                    class="form-select @error('programas_id') is-invalid @enderror"
                >
                    <option value="">-- Selecciona un programa (Opcional) --</option>
                    @foreach($programas as $programa)
                        <option value="{{ $programa->id }}" {{ old('programas_id') == $programa->id ? 'selected' : '' }}>
                            {{ $programa->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('programas_id')
                    <span class="error-message">
                        <i class="bi bi-exclamation-circle-fill me-1"></i> {{ $message }}
                    </span>
                @enderror
            </div>

            <!-- Button Group -->
            <div class="button-group">
                <button type="submit" class="btn-custom btn-primary">
                    <i class="bi bi-cloud-arrow-up-fill"></i> Guardar Ficha
                </button>
                <a href="{{ route('fichas.index') }}" class="btn-custom btn-secondary">
                    <i class="bi bi-x-circle-fill"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
