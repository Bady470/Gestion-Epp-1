@extends('layouts.app')

@section('title', 'Elementos de Protección Personal - SENA')

@section('content')
<div class="container mt-5">
    <!-- TÍTULO + BOTÓN NUEVO -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title"
            style="color: #39A900; border-bottom: 3px solid #39A900; padding-bottom: 6px; font-size: 1.75rem;">
            Elementos de Protección Personal
        </h2>
        <a href="{{ route('elementos_pp.create') }}"
            class="btn btn-success shadow-sm d-flex align-items-center gap-2 px-4">
            <i class="bi bi-plus-circle-fill"></i>
            <span class="d-none d-sm-inline">Nuevo</span>
        </a>
    </div>

    <!-- MENSAJE DE ÉXITO -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- ERROR GENERAL -->
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- ERRORES DE VALIDACIÓN -->
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3" role="alert">
        <i class="bi bi-x-circle-fill me-2"></i>
        <strong>Errores de validación:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- ERRORES DE IMPORTACIÓN -->
    @if(session()->has('failures'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3" role="alert">
        <h6 class="fw-bold mb-3">
            <i class="bi bi-x-circle-fill me-2"></i>
            Errores encontrados en el archivo:
        </h6>
        <ul class="mb-0">
            @foreach(session('failures') as $failure)
                <li>
                    <strong>Fila {{ $failure->row() }}:</strong>
                    {{ implode(', ', $failure->errors()) }}
                </li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- TARJETA PRINCIPAL -->
    <div class="card border-0 shadow" style="border-radius: 16px; overflow: hidden;">
        <div class="card-header text-white fw-bold" style="background: linear-gradient(135deg, #406479, #39A900);">
            <i class="bi bi-shield-check me-2"></i> Lista de EPP
        </div>

        <div class="card-body p-0">
            @if($elementos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 0.95rem;">
                        <thead style="background-color: #406479; color: white;">
                            <tr>
                                <th class="text-center px-3 py-3">ID</th>
                                <th class="px-3 py-3">Imagen</th>
                                <th class="px-3 py-3">Nombre</th>
                                <th class="text-center px-3 py-3">Cant.</th>
                                <th class="text-center px-3 py-3">Talla</th>
                                <th class="px-3 py-3">Área</th>
                                <th class="px-3 py-3">Filtro</th>
                                <th class="text-center px-3 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($elementos as $elemento)
                            <tr class="table-row-hover" style="transition: all 0.2s;">
                                <td class="text-center fw-bold px-3 py-3">{{ $elemento->id }}</td>

                                <!-- IMAGEN SIN BORDES -->
                                <td class="px-3 py-3">
                                    @if($elemento->img_url)
                                    <img src="{{ $elemento->img_url }}" alt="{{ $elemento->nombre ?? 'Producto' }}" width="50"
                                        class="rounded shadow-sm" style="border: none;" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2250%22 height=%2250%22%3E%3Crect fill=%22%23e0e0e0%22 width=%2250%22 height=%2250%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-size=%2220%22 fill=%22%23999%22 text-anchor=%22middle%22 dy=%22.3em%22%3E?%3C/text%3E%3C/svg%3E'">
                                    @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                        style="width: 50px; height: 50px;">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                    @endif
                                </td>

                                <!-- NOMBRE CON VALIDACIÓN -->
                                <td class="fw-semibold px-3 py-3" style="max-width: 180px;">
                                    @if($elemento->nombre)
                                        {{ $elemento->nombre }}
                                    @else
                                        <span class="badge bg-warning text-dark">Sin nombre</span>
                                    @endif
                                </td>

                                <!-- CANTIDAD -->
                                <td class="text-center px-3 py-3">
                                    <span class="badge rounded-pill px-3 py-1 text-white"
                                        style="background-color: #39A900; font-size: 0.9rem;">
                                        {{ $elemento->cantidad ?? 0 }}
                                    </span>
                                </td>

                                <!-- TALLA -->
                                <td class="text-center px-3 py-3">
                                    {{ $elemento->talla ?? '-' }}
                                </td>

                                <!-- ÁREA -->
                                <td class="px-3 py-3 text-muted">
                                    @if($elemento->area)
                                        {{ $elemento->area->nombre }}
                                    @else
                                        <span class="badge bg-secondary">Sin área</span>
                                    @endif
                                </td>

                                <!-- FILTRO -->
                                <td class="px-3 py-3 text-muted">
                                    @if($elemento->filtro)
                                        {{ $elemento->filtro->parte_del_cuerpo }}
                                    @else
                                        <span class="badge bg-secondary">Sin filtro</span>
                                    @endif
                                </td>

                                <!-- ACCIONES -->
                                <td class="text-center px-3 py-3">
                                    <div class="d-flex justify-content-center gap-2">
                                        <!-- EDITAR -->
                                        <a href="{{ route('elementos_pp.edit', $elemento) }}"
                                            class="btn btn-primary d-flex align-items-center justify-content-center shadow-sm"
                                            style="background-color: #406479; border-color: #406479; width: 44px; height: 44px; border-radius: 12px;"
                                            title="Editar">
                                            <i class="bi bi-pencil-square text-white"></i>
                                        </a>

                                        <!-- ELIMINAR -->
                                        <form action="{{ route('elementos_pp.destroy', $elemento) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('¿Eliminar este EPP?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-danger d-flex align-items-center justify-content-center shadow-sm"
                                                style="width: 44px; height: 44px; border-radius: 12px;" title="Eliminar">
                                                <i class="bi bi-trash-fill text-white"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox display-3 d-block mb-3"></i>
                                    <h6>No hay elementos registrados</h6>
                                    <a href="{{ route('elementos_pp.create') }}" class="btn btn-success btn-sm mt-2">
                                        <i class="bi bi-plus"></i> Crear primero
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @else
                <!-- ESTADO VACÍO MEJORADO -->
                <div class="text-center py-5">
                    <i class="bi bi-inbox display-3 d-block mb-3" style="color: #ccc;"></i>
                    <h5 class="text-muted mb-3">No hay elementos registrados</h5>
                    <p class="text-muted mb-4">Comienza creando tu primer elemento de protección personal</p>
                    <a href="{{ route('elementos_pp.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle me-2"></i> Crear primer elemento
                    </a>
                </div>
            @endif
        </div>

        <!-- PAGINACIÓN -->
        @if($elementos->count() > 0)
        <div class="card-footer bg-light border-0 py-3">
            <div class="d-flex justify-content-center">
                {{ $elementos->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    /* FONDO SUTIL */
    body {
        background: linear-gradient(135deg, #f9f9fb 0%, #eef0f3 100%);
        background-attachment: fixed;
    }

    /* HOVER SUAVE */
    .table-row-hover:hover {
        background-color: rgba(57, 169, 0, 0.08) !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    /* PAGINACIÓN ELEGANTE */
    .pagination .page-link {
        color: #39A900;
        border: 1px solid #39A900;
        font-weight: 500;
        padding: 0.5rem 0.9rem;
        border-radius: 6px;
        margin: 0 2px;
    }

    .pagination .page-item.active .page-link {
        background-color: #39A900;
        border-color: #39A900;
        color: white;
    }

    .pagination .page-link:hover {
        background-color: #39A900;
        color: white;
        border-color: #39A900;
    }

    /* BOTONES COMPACTOS */
    .btn-action {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15) !important;
    }

    /* CARD LIMPIA */
    .card {
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08) !important;
        border-radius: 16px !important;
    }

    /* BADGES MEJORADOS */
    .badge {
        font-weight: 600;
        padding: 0.4rem 0.8rem;
    }

    /* ALERTAS MEJORADAS */
    .alert {
        border-left: 4px solid;
        animation: slideIn 0.3s ease-out;
    }

    .alert-success {
        border-left-color: #28a745;
    }

    .alert-danger {
        border-left-color: #dc3545;
    }

    .alert-warning {
        border-left-color: #ffc107;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endsection
