@extends('layouts.dashboard')

@section('title', 'Panel Principal - SENA EPP')

@section('content')

<!-- SECCIÓN DE BIENVENIDA MEJORADA -->
<div class="welcome-section mb-5">
    <div class="row align-items-center">
        <div class="col-lg-8">
            <h1 class="display-4 fw-bold mb-2" style="color: #39A900;">
                <i class="bi bi-shield-check me-3"></i> Sistema de Gestión de EPP
            </h1>
            <p class="lead text-muted mb-0">Panel de administración centralizado para la gestión de equipos de protección personal</p>
        </div>
        <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
            <div class="badge bg-success p-3 rounded-3" style="font-size: 1rem;">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong>{{ auth()->user()->nombre_completo }}</strong>
            </div>
        </div>
    </div>
</div>

<!-- ALERTA DE BIENVENIDA MEJORADA -->
<div class="alert alert-success alert-dismissible fade show mb-5" role="alert" style="border-left: 5px solid #39A900; border-radius: 12px; background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); border: none;">
    <div class="d-flex align-items-center">
        <i class="bi bi-check-circle-fill me-3" style="font-size: 1.5rem; color: #39A900;"></i>
        <div>
            <strong style="color: #39A900; font-size: 1.1rem;">¡Bienvenido!</strong>
            <p class="mb-0 mt-1" style="color: #155724;">Has iniciado sesión correctamente como <strong>{{ auth()->user()->nombre_completo }}</strong></p>
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<!-- ESTADÍSTICAS RÁPIDAS -->
<div class="row g-3 mb-5">
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                <i class="bi bi-people-fill" style="color: #1976d2; font-size: 1.8rem;"></i>
            </div>
            <div class="stat-content">
                <p class="stat-label">Usuarios Registrados</p>
                <h4 class="stat-value">45</h4>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%);">
                <i class="bi bi-card-list" style="color: #7b1fa2; font-size: 1.8rem;"></i>
            </div>
            <div class="stat-content">
                <p class="stat-label">Fichas Activas</p>
                <h4 class="stat-value">128</h4>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);">
                <i class="bi bi-building" style="color: #388e3c; font-size: 1.8rem;"></i>
            </div>
            <div class="stat-content">
                <p class="stat-label">Programas</p>
                <h4 class="stat-value">24</h4>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);">
                <i class="bi bi-shield-check" style="color: #f57c00; font-size: 1.8rem;"></i>
            </div>
            <div class="stat-content">
                <p class="stat-label">EPP Disponibles</p>
                <h4 class="stat-value">356</h4>
            </div>
        </div>
    </div>
</div>

<!-- TARJETAS DE GESTIÓN MEJORADAS -->
<div class="mb-4">
    <h2 class="h4 fw-bold mb-4" style="color: #406479;">
        <i class="bi bi-sliders me-2"></i> Gestión del Sistema
    </h2>
</div>

<div class="row g-4 justify-content-center">
    <!-- USUARIOS -->
    <div class="col-md-6 col-lg-4">
        <div class="dashboard-card-improved">
            <div class="card-header-bar" style="background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);"></div>
            <div class="card-icon-container" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                <i class="bi bi-people-fill" style="color: #1976d2; font-size: 2.5rem;"></i>
            </div>
            <h5 class="card-title">Usuarios</h5>
            <p class="card-description">Gestionar usuarios del sistema y sus permisos</p>
            <div class="card-stats">
                <span class="badge bg-light text-dark">45 registros</span>
            </div>
            <a href="{{ route('usuarios.index') }}" class="btn btn-gradient-blue w-100 mt-3">
                <i class="bi bi-arrow-right-circle me-2"></i> Gestionar
            </a>
        </div>
    </div>

    <!-- FICHAS -->
    <div class="col-md-6 col-lg-4">
        <div class="dashboard-card-improved">
            <div class="card-header-bar" style="background: linear-gradient(135deg, #7b1fa2 0%, #6a1b9a 100%);"></div>
            <div class="card-icon-container" style="background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%);">
                <i class="bi bi-card-list" style="color: #7b1fa2; font-size: 2.5rem;"></i>
            </div>
            <h5 class="card-title">Fichas</h5>
            <p class="card-description">Administrar fichas de aprendices y registros</p>
            <div class="card-stats">
                <span class="badge bg-light text-dark">128 registros</span>
            </div>
            <a href="{{ route('fichas.index') }}" class="btn btn-gradient-purple w-100 mt-3">
                <i class="bi bi-arrow-right-circle me-2"></i> Gestionar
            </a>
        </div>
    </div>

    <!-- PROGRAMAS -->
    <div class="col-md-6 col-lg-4">
        <div class="dashboard-card-improved">
            <div class="card-header-bar" style="background: linear-gradient(135deg, #388e3c 0%, #2e7d32 100%);"></div>
            <div class="card-icon-container" style="background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);">
                <i class="bi bi-building" style="color: #388e3c; font-size: 2.5rem;"></i>
            </div>
            <h5 class="card-title">Programas</h5>
            <p class="card-description">Gestionar programas de formación y cursos</p>
            <div class="card-stats">
                <span class="badge bg-light text-dark">24 registros</span>
            </div>
            <a href="{{ route('programas.index') }}" class="btn btn-gradient-green w-100 mt-3">
                <i class="bi bi-arrow-right-circle me-2"></i> Gestionar
            </a>
        </div>
    </div>

    <!-- EPP -->
    <div class="col-md-6 col-lg-4">
        <div class="dashboard-card-improved">
            <div class="card-header-bar" style="background: linear-gradient(135deg, #f57c00 0%, #e65100 100%);"></div>
            <div class="card-icon-container" style="background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);">
                <i class="bi bi-shield-check" style="color: #f57c00; font-size: 2.5rem;"></i>
            </div>
            <h5 class="card-title">EPP</h5>
            <p class="card-description">Inventario y distribución de equipos de protección</p>
            <div class="card-stats">
                <span class="badge bg-light text-dark">356 registros</span>
            </div>
            <a href="{{ route('elementos_pp.index') }}" class="btn btn-gradient-orange w-100 mt-3">
                <i class="bi bi-arrow-right-circle me-2"></i> Gestionar
            </a>
        </div>
    </div>
</div>

<!-- ESTILOS MEJORADOS -->
<style>
    /* Sección de Bienvenida */
    .welcome-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 2rem;
        border-radius: 16px;
        border-left: 5px solid #39A900;
    }

    /* Tarjetas de Estadísticas */
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 1px solid #e0e0e0;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stat-content {
        flex: 1;
    }

    .stat-label {
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0;
        color: #333;
    }

    /* Tarjetas de Gestión Mejoradas */
    .dashboard-card-improved {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 1px solid #e0e0e0;
        padding: 1.8rem;
        text-align: center;
        position: relative;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .dashboard-card-improved:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
    }

    .card-header-bar {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }

    .card-icon-container {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 1rem auto;
    }

    .card-title {
        font-weight: 700;
        color: #333;
        margin-bottom: 0.5rem;
        font-size: 1.25rem;
    }

    .card-description {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 1rem;
        flex-grow: 1;
    }

    .card-stats {
        margin-bottom: 1rem;
    }

    .card-stats .badge {
        font-size: 0.85rem;
        padding: 0.5rem 0.75rem;
        border-radius: 20px;
    }

    /* Botones con Gradientes */
    .btn-gradient-blue {
        background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);
        border: none;
        color: white;
        font-weight: 600;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .btn-gradient-blue:hover {
        background: linear-gradient(135deg, #1565c0 0%, #0d47a1 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(25, 118, 210, 0.4);
    }

    .btn-gradient-purple {
        background: linear-gradient(135deg, #7b1fa2 0%, #6a1b9a 100%);
        border: none;
        color: white;
        font-weight: 600;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .btn-gradient-purple:hover {
        background: linear-gradient(135deg, #6a1b9a 0%, #4a148c 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(123, 31, 162, 0.4);
    }

    .btn-gradient-green {
        background: linear-gradient(135deg, #388e3c 0%, #2e7d32 100%);
        border: none;
        color: white;
        font-weight: 600;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .btn-gradient-green:hover {
        background: linear-gradient(135deg, #2e7d32 0%, #1b5e20 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(56, 142, 60, 0.4);
    }

    .btn-gradient-orange {
        background: linear-gradient(135deg, #f57c00 0%, #e65100 100%);
        border: none;
        color: white;
        font-weight: 600;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .btn-gradient-orange:hover {
        background: linear-gradient(135deg, #e65100 0%, #bf360c 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 124, 0, 0.4);
    }

    /* Alerta Mejorada */
    .alert-success {
        border-radius: 12px !important;
    }

    .alert-success strong {
        font-size: 1.1rem;
    }

    /* Responsivo */
    @media (max-width: 768px) {
        .welcome-section {
            padding: 1.5rem;
        }

        .card-icon-container {
            width: 70px;
            height: 70px;
        }

        .card-icon-container i {
            font-size: 2rem !important;
        }

        .stat-card {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

@endsection
