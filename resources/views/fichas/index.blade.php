@extends('layouts.app')

@section('title', 'Gestión de Fichas - SENA')

@section('content')
<div class="container mt-5">
    <!-- TÍTULO + BOTÓN NUEVO -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title"
            style="color: #39A900; border-bottom: 3px solid #39A900; padding-bottom: 6px; font-size: 1.75rem;">
            Gestión de Fichas
        </h2>
        <a href="{{ route('fichas.create') }}"
           class="btn btn-success shadow-sm d-flex align-items-center gap-2 px-4">
            <i class="bi bi-plus-circle-fill"></i>
            <span class="d-none d-sm-inline">Nueva Ficha</span>
        </a>
    </div>

    <!-- MENSAJE DE ÉXITO -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- TARJETA PRINCIPAL -->
    <div class="card border-0 shadow" style="border-radius: 16px; overflow: hidden;">
        <div class="card-header text-white fw-bold" style="background: linear-gradient(135deg, #406479, #39A900);">
            <i class="bi bi-journal-text me-2"></i> Lista de Fichas
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.95rem;">
                    <thead style="background-color: #406479; color: white;">
                        <tr>
                            <th class="text-center px-3 py-3">ID</th>
                            <th class="px-3 py-3">Número</th>
                            <th class="px-3 py-3">Programa</th>
                            <th class="text-center px-3 py-3">Creada</th>
                            <th class="text-center px-3 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fichas as $ficha)
                        <tr class="table-row-hover" style="transition: all 0.2s;">
                            <td class="text-center fw-bold px-3 py-3">{{ $ficha->id }}</td>

                            <td class="fw-semibold px-3 py-3">{{ $ficha->numero }}</td>

                            <td class="px-3 py-3 text-muted">
                                {{ $ficha->programa?->nombre ?? '<em>Sin programa</em>' }}
                            </td>

                            <td class="text-center px-3 py-3">
                                <span class="badge rounded-pill px-3 py-1 text-white"
                                      style="background-color: #406479; font-size: 0.85rem;">
                                    {{ $ficha->created_at->format('d/m/Y') }}
                                </span>
                            </td>

                            <!-- ACCIONES -->
                            <td class="text-center px-3 py-3">
                                <div class="d-flex justify-content-center gap-2">
                                    <!-- EDITAR -->
                                    <a href="{{ route('fichas.edit', $ficha) }}"
                                       class="btn btn-primary d-flex align-items-center justify-content-center shadow-sm"
                                       style="background-color: #406479; border-color: #406479; width: 44px; height: 44px; border-radius: 12px;"
                                       title="Editar">
                                        <i class="bi bi-pencil-square text-white"></i>
                                    </a>

                                    <!-- ELIMINAR -->
                                    <form action="{{ route('fichas.destroy', $ficha) }}" method="POST"
                                          class="d-inline" onsubmit="return confirm('¿Eliminar esta ficha?')">
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
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox display-3 d-block mb-3"></i>
                                <h6>No hay fichas registradas</h6>
                                <a href="{{ route('fichas.create') }}" class="btn btn-success btn-sm mt-2">
                                    <i class="bi bi-plus"></i> Crear primera ficha
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- PAGINACIÓN -->
        <div class="card-footer bg-light border-0 py-3">
            <div class="d-flex justify-content-center">
                {{ $fichas->links('pagination::bootstrap-5') }}
            </div>
        </div>
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
</style>
@endsection