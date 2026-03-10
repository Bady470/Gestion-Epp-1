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

    /* Form Row */
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }

    .form-row.full {
        grid-template-columns: 1fr;
    }

    /* Form Group */
    .form-group {
        margin-bottom: 0;
    }

    .form-group:last-of-type {
        margin-bottom: 0;
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

    /* Password Input Group */
    .password-input-group {
        position: relative;
    }

    .password-toggle-btn {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--sena-blue);
        cursor: pointer;
        font-size: 1.2rem;
        padding: 0.5rem;
        transition: all 0.2s ease;
    }

    .password-toggle-btn:hover {
        color: var(--sena-green);
        transform: translateY(-50%) scale(1.1);
    }

    .form-control.with-toggle {
        padding-right: 3rem;
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

        .form-row {
            grid-template-columns: 1fr;
            gap: 1.5rem;
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
        <h1><i class="bi bi-person-plus-circle"></i> Crear Usuario</h1>
        <p>Registra un nuevo usuario en el sistema</p>
    </div>

    <!-- Info Box -->
    <div class="info-box">
        <i class="bi bi-info-circle-fill"></i>
        <div class="info-box-content">
            <div class="info-box-title">Información Importante</div>
            <div class="info-box-text">
                Completa todos los campos requeridos. La contraseña debe tener al menos 8 caracteres. Asegúrate de confirmar la contraseña correctamente.
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <div class="form-container">
        <form method="POST" action="{{ route('usuarios.store') }}" novalidate>
            @csrf

            <!-- Nombre Completo -->
            <div class="form-row full">
                <div class="form-group">
                    <label class="form-label" for="nombre_completo">
                        Nombre Completo
                        <span class="required">*</span>
                    </label>
                    <input
                        type="text"
                        id="nombre_completo"
                        name="nombre_completo"
                        class="form-control @error('nombre_completo') is-invalid @enderror"
                        placeholder="Ej: Juan Pérez García"
                        value="{{ old('nombre_completo') }}"
                        required
                        autofocus
                    >
                    @error('nombre_completo')
                        <span class="error-message">
                            <i class="bi bi-exclamation-circle-fill me-1"></i> {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Correo Electrónico -->
            <div class="form-row full">
                <div class="form-group">
                    <label class="form-label" for="email">
                        Correo Electrónico
                        <span class="required">*</span>
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="usuario@ejemplo.com"
                        value="{{ old('email') }}"
                        required
                    >
                    @error('email')
                        <span class="error-message">
                            <i class="bi bi-exclamation-circle-fill me-1"></i> {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Contraseña y Confirmación -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="password">
                        Contraseña
                        <span class="required">*</span>
                    </label>
                    <div class="password-input-group">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control with-toggle @error('password') is-invalid @enderror"
                            placeholder="Mínimo 8 caracteres"
                            required
                        >
                        <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('password')" title="Mostrar/Ocultar contraseña">
                            <i class="bi bi-eye-fill"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="error-message">
                            <i class="bi bi-exclamation-circle-fill me-1"></i> {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">
                        Confirmar Contraseña
                        <span class="required">*</span>
                    </label>
                    <div class="password-input-group">
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-control with-toggle @error('password_confirmation') is-invalid @enderror"
                            placeholder="Repite la contraseña"
                            required
                        >
                        <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('password_confirmation')" title="Mostrar/Ocultar contraseña">
                            <i class="bi bi-eye-fill"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <span class="error-message">
                            <i class="bi bi-exclamation-circle-fill me-1"></i> {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Rol y Área -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="roles_id">
                        Rol del Usuario
                        <span class="required">*</span>
                    </label>
                    <select
                        id="roles_id"
                        name="roles_id"
                        class="form-select @error('roles_id') is-invalid @enderror"
                        required
                    >
                        <option value="">-- Selecciona un rol --</option>
                        @foreach($roles as $rol)
                            <option value="{{ $rol->id }}" {{ old('roles_id') == $rol->id ? 'selected' : '' }}>
                                {{ $rol->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('roles_id')
                        <span class="error-message">
                            <i class="bi bi-exclamation-circle-fill me-1"></i> {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="areas_id">
                        Área de Trabajo
                    </label>
                    <select
                        id="areas_id"
                        name="areas_id"
                        class="form-select @error('areas_id') is-invalid @enderror"
                    >
                        <option value="">-- Selecciona un área (Opcional) --</option>
                        @foreach($areas as $area)
                            <option value="{{ $area->id }}" {{ old('areas_id') == $area->id ? 'selected' : '' }}>
                                {{ $area->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('areas_id')
                        <span class="error-message">
                            <i class="bi bi-exclamation-circle-fill me-1"></i> {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Button Group -->
            <div class="button-group">
                <button type="submit" class="btn-custom btn-primary">
                    <i class="bi bi-cloud-arrow-up-fill"></i> Guardar Usuario
                </button>
                <a href="{{ route('usuarios.index') }}" class="btn-custom btn-secondary">
                    <i class="bi bi-x-circle-fill"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function togglePasswordVisibility(fieldId) {
    const field = document.getElementById(fieldId);
    const button = event.target.closest('.password-toggle-btn');
    const icon = button.querySelector('i');

    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('bi-eye-fill');
        icon.classList.add('bi-eye-slash-fill');
    } else {
        field.type = 'password';
        icon.classList.remove('bi-eye-slash-fill');
        icon.classList.add('bi-eye-fill');
    }
}
</script>
@endsection
