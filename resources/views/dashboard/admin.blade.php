@extends('layouts.dashboard')

@section('title', 'Panel Principal - SENA EPP')

@section('content')
<div class="text-center mb-5">
    <h1 class="display-5 fw-bold" style="color: #39A900;">
        <i class="bi bi-shield-check me-2"></i> Sistema de Gestión de EPP
    </h1>
    <p class="lead text-muted">Bienvenido al panel de administración</p>
</div>

<!-- ALERTA DE BIENVENIDA -->
<div class="welcome-alert mx-auto mb-5" style="max-width: 700px;">
    <i class="bi bi-check-circle-fill" style="color: #39A900;"></i>
    Has iniciado sesión correctamente como:
    <strong style="color: #39A900;">{{ auth()->user()->nombre_completo }}</strong>
</div>

<!-- TARJETAS DE ACCESO - TODOS EN AZUL SENA #406479 -->
<div class="row g-4 justify-content-center">
    <!-- USUARIOS -->
    <div class="col-md-6 col-lg-4">
        <div class="dashboard-card">
            <div class="icon" style="color: #406479;">
                <i class="bi bi-people-fill"></i>
            </div>
            <h5 class="mb-3">Usuarios</h5>
            <a href="{{ route('usuarios.index') }}" class="btn w-100 text-white"
                style="background-color: #406479; border-color: #406479; border-radius: 12px; padding: 0.75rem; font-weight: 600;">
                <i class="bi bi-arrow-right-circle me-1"></i> Gestionar
            </a>
        </div>
    </div>

    <!-- FICHAS -->
    <div class="col-md-6 col-lg-4">
        <div class="dashboard-card">
            <div class="icon" style="color: #406479;">
                <i class="bi bi-card-list"></i>
            </div>
            <h5 class="mb-3">Fichas</h5>
            <a href="{{ route('fichas.index') }}" class="btn w-100 text-white"
                style="background-color: #406479; border-color: #406479; border-radius: 12px; padding: 0.75rem; font-weight: 600;">
                <i class="bi bi-arrow-right-circle me-1"></i> Gestionar
            </a>
        </div>
    </div>

    <!-- PROGRAMAS -->
    <div class="col-md-6 col-lg-4">
        <div class="dashboard-card">
            <div class="icon" style="color: #406479;">
                <i class="bi bi-building"></i>
            </div>
            <h5 class="mb-3">Programas</h5>
            <a href="{{ route('programas.index') }}" class="btn w-100 text-white"
                style="background-color: #406479; border-color: #406479; border-radius: 12px; padding: 0.75rem; font-weight: 600;">
                <i class="bi bi-arrow-right-circle me-1"></i> Gestionar
            </a>
        </div>
    </div>

    <!-- EPP -->
    <div class="col-md-6 col-lg-4">
        <div class="dashboard-card">
            <div class="icon" style="color: #406479;">
                <i class="bi bi-shield-check"></i>
            </div>
            <h5 class="mb-3">EPP</h5>
            <a href="{{ route('elementos_pp.index') }}" class="btn w-100 text-white"
                style="background-color: #406479; border-color: #406479; border-radius: 12px; padding: 0.75rem; font-weight: 600;">
                <i class="bi bi-arrow-right-circle me-1"></i> Gestionar
            </a>
        </div>
    </div>
</div>
@endsection