@extends('layouts.app')

@section('title', 'Gestión de Fichas - SENA')

@section('content')
<style>
    :root {
        --sena-green: #39A900;
        --sena-blue: #406479;
        --sena-light: #f8f9fa;
    }

    /* Fondo sutil */
    body {
        background: linear-gradient(135deg, #f9f9fb 0%, #eef0f3 100%);
        background-attachment: fixed;
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

    /* Header Section */
    .header-section {
        background: linear-gradient(135deg, var(--sena-blue), var(--sena-green));
        color: white;
        padding: 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 25px rgba(57, 169, 0, 0.15);
    }

    .header-section h2 {
        font-family: 'Poppins', sans-serif;
        font-weight: 800;
        margin: 0;
        font-size: 1.8rem;
    }

    /* Card Principal */
    .card-main {
        border: none;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        background: white;
    }

    .card-header-custom {
        background: #f8fafc;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #edf2f7;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-header-title {
        font-weight: 700;
        color: var(--sena-blue);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Tabla Responsiva */
    .table-container {
        padding: 0;
    }

    .table thead {
        background: #f1f5f9;
    }

    .table thead th {
        border: none;
        font-weight: 700;
        padding: 1.25rem 1rem;
        color: var(--sena-blue);
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }

    .table tbody td {
        padding: 1.25rem 1rem;
        vertical-align: middle;
        border-color: #f1f5f9;
        color: #4a5568;
    }

    .table-row-hover:hover {
        background-color: rgba(57, 169, 0, 0.04) !important;
    }

    /* Botones de Acción */
    .btn-action {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        border: none;
        color: white;
        text-decoration: none;
    }

    .btn-edit { background-color: var(--sena-blue); }
    .btn-delete { background-color: #e53e3e; }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        filter: brightness(1.1);
        color: white;
    }

    /* Paginación */
    .pagination-container {
        padding: 1.5rem;
        background: #f8fafc;
        border-top: 1px solid #edf2f7;
    }

    /* Responsive Adjustments */
    @media (max-width: 767.98px) {
        .header-section {
            padding: 1.5rem;
            text-align: center;
            flex-direction: column;
            gap: 1rem;
        }

        .header-section .d-flex {
            flex-direction: column;
            width: 100%;
        }

        .btn-nuevo {
            width: 100%;
            justify-content: center;
        }

        /* Table to Cards on Mobile */
        .table-responsive {
            border: none;
        }

        .table thead {
            display: none;
        }

        .table, .table tbody, .table tr, .table td {
            display: block;
            width: 100%;
        }

        .table tr {
            background: white;
            margin-bottom: 1rem;
            border-radius: 16px;
            padding: 1rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #edf2f7;
        }

        .table td {
            text-align: right;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table td:last-child {
            border-bottom: none;
            padding-top: 1rem;
            justify-content: center;
        }

        .table td::before {
            content: attr(data-label);
            font-weight: 700;
            color: var(--sena-blue);
            font-size: 0.75rem;
            text-transform: uppercase;
            text-align: left;
        }

        .btn-action-group {
            width: 100%;
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .btn-action {
            flex: 1;
            height: 48px;
            border-radius: 12px;
        }
    }
</style>

<div class="container py-4">
    <!-- Botón de Volver -->
    <a href="javascript:history.back()" class="btn-volver-top" title="Volver atrás">
        <i class="bi bi-arrow-left"></i> Volver
    </a>

    <!-- Header -->
    <div class="header-section d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="bi bi-journal-bookmark-fill me-2"></i> Gestión de Fichas</h2>
            <p class="mb-0 opacity-90">Administra las fichas de formación del centro</p>
        </div>
        <a href="{{ route('fichas.create') }}" class="btn btn-light btn-nuevo shadow-sm d-flex align-items-center gap-2 px-4 py-2 rounded-pill fw-bold text-success">
            <i class="bi bi-plus-circle-fill"></i>
            <span>Nueva Ficha</span>
        </a>
    </div>

    <!-- Mensaje de Éxito -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-4 border-0 mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="bi bi-check-circle-fill fs-4 me-3"></i>
            <div>{{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Card Principal -->
    <div class="card-main">
        <div class="card-header-custom">
            <h5 class="card-header-title">
                <i class="bi bi-list-ul"></i> Lista de Fichas
            </h5>
            <span class="badge bg-soft-primary text-primary rounded-pill px-3 py-2" style="background: rgba(64, 100, 121, 0.1);">
                {{ $fichas->total() }} Registradas
            </span>
        </div>

        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Número de Ficha</th>
                            <th>Programa de Formación</th>
                            <th class="text-center">Fecha Creación</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fichas as $ficha)
                        <tr class="table-row-hover">
                            <td data-label="ID" class="text-center fw-bold text-primary">#{{ $ficha->id }}</td>

                            <td data-label="Número" class="fw-bold text-dark">
                                {{ $ficha->numero }}
                            </td>

                            <td data-label="Programa">
                                @if($ficha->programa)
                                    <span class="text-secondary fw-semibold">
                                        <i class="bi bi-book me-1"></i> {{ $ficha->programa->nombre }}
                                    </span>
                                @else
                                    <span class="text-muted small italic">Sin programa asignado</span>
                                @endif
                            </td>

                            <td data-label="Creada" class="text-center">
                                <span class="badge rounded-pill px-3 py-2" style="background: rgba(64, 100, 121, 0.1); color: var(--sena-blue);">
                                    <i class="bi bi-calendar3 me-1"></i> {{ $ficha->created_at->format('d/m/Y') }}
                                </span>
                            </td>

                            <td class="text-center">
                                <div class="btn-action-group d-flex justify-content-center gap-2">
                                    <a href="{{ route('fichas.edit', $ficha) }}"
                                       class="btn-action btn-edit"
                                       title="Editar ficha">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>

                                    <form action="{{ route('fichas.destroy', $ficha) }}" method="POST"
                                          onsubmit="return confirm('¿Estás seguro de eliminar esta ficha?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete" title="Eliminar ficha">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-journal-x display-1 text-muted opacity-25"></i>
                                    <h5 class="mt-3 fw-bold text-muted">No hay fichas registradas</h5>
                                    <p class="text-muted">Comienza creando la primera ficha de formación.</p>
                                    <a href="{{ route('fichas.create') }}" class="btn btn-success rounded-pill px-4 mt-2">
                                        <i class="bi bi-plus-lg me-1"></i> Crear Ficha
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginación -->
        @if($fichas->hasPages())
        <div class="pagination-container d-flex justify-content-center">
            {{ $fichas->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>
@endsection
