@extends("layouts.dashboard")

@section("content")
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
        padding: 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .header-section h2 {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        margin: 0;
        font-size: 1.8rem;
    }

    .header-section p {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
    }

    /* Botón Volver */
    .btn-volver-top {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.4);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        margin-bottom: 1rem;
    }

    .btn-volver-top:hover {
        background: white;
        color: var(--sena-blue);
        transform: translateX(-5px);
    }

    /* Filtros de área */
    .filtros-area {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        border: 1px solid #eef0f2;
    }

    .filtros-area h5 {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        color: var(--sena-blue);
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .area-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .btn-area {
        padding: 0.6rem 1.2rem;
        border: 1px solid #dee2e6;
        background: white;
        color: var(--sena-blue);
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s ease;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-area:hover {
        border-color: var(--sena-green);
        background: #f8fdf5;
        color: var(--sena-green);
    }

    .btn-area.active {
        background: linear-gradient(135deg, var(--sena-blue), var(--sena-green));
        color: white;
        border-color: transparent;
        box-shadow: 0 4px 10px rgba(57, 169, 0, 0.2);
    }

    /* Tabla Responsiva */
    .table-container {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid #eef0f2;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead {
        background: #f1f4f6;
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
        border-color: #f1f4f6;
        color: #444;
    }

    .table tbody tr:hover {
        background-color: #fcfdfe;
    }

    /* Badges de Estado */
    .badge-status {
        padding: 0.5rem 1rem;
        font-size: 0.75rem;
        font-weight: 700;
        border-radius: 50px;
        text-transform: uppercase;
    }

    .bg-pendiente { background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
    .bg-enviado { background-color: #e1f5fe; color: #01579b; border: 1px solid #b3e5fc; }
    .bg-aprobado { background-color: #e8f5e9; color: #1b5e20; border: 1px solid #c8e6c9; }
    .bg-default { background-color: #f5f5f5; color: #616161; border: 1px solid #e0e0e0; }

    /* Botones de Acción */
    .btn-detalle {
        background: white;
        color: var(--sena-blue);
        border: 1px solid var(--sena-blue);
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.2s ease;
        font-size: 0.85rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-detalle:hover {
        background: var(--sena-blue);
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(64, 100, 121, 0.2);
    }

    /* Responsive Adjustments */
    @media (max-width: 767.98px) {
        .header-section {
            padding: 1.5rem;
            text-align: center;
        }

        .header-section h2 {
            font-size: 1.5rem;
        }

        .table-container {
            background: transparent;
            box-shadow: none;
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
            border-radius: 12px;
            padding: 1rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #eef0f2;
        }

        .table td {
            text-align: right;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f8f9fa;
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

        .btn-detalle {
            width: 100%;
            justify-content: center;
            padding: 0.75rem;
        }

        .area-buttons {
            justify-content: center;
        }

        .btn-area {
            flex: 1 1 calc(50% - 0.5rem);
            justify-content: center;
            font-size: 0.8rem;
            padding: 0.5rem;
        }
    }

    /* Empty State */
    .alerta-vacia {
        background: white;
        border-radius: 16px;
        padding: 4rem 2rem;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: 1px solid #eef0f2;
    }

    .alerta-vacia i {
        font-size: 4rem;
        color: #dee2e6;
        margin-bottom: 1.5rem;
        display: block;
    }

    .alerta-vacia h5 {
        font-weight: 700;
        color: var(--sena-blue);
        margin-bottom: 0.5rem;
    }

    .alerta-vacia p {
        color: #888;
    }
</style>

<div class="container py-4">
    <!-- Header -->
    <div class="header-section">
        <a href="javascript:history.back()" class="btn-volver-top">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
        <div class="d-flex align-items-center gap-3">
            <div class="bg-white bg-opacity-25 p-3 rounded-3 d-none d-md-block">
                <i class="bi bi-send-check fs-2"></i>
            </div>
            <div>
                <h2>📋 Pedidos Enviados</h2>
                <p>Gestiona y revisa los pedidos enviados por los instructores</p>
            </div>
        </div>
    </div>

    <!-- Filtros por área -->
    @php
        $areas = \App\Models\Area::all();
    @endphp

    @if($areas->count() > 0)
    <div class="filtros-area">
        <h5>
            <i class="bi bi-funnel-fill"></i> Filtrar pedidos por área
        </h5>
        <div class="area-buttons">
            <button type="button" class="btn-area active" onclick="filtrarArea(null)">
                <i class="bi bi-grid-fill"></i> Todos
            </button>
            @foreach($areas as $area)
            <button
                type="button"
                class="btn-area"
                onclick="filtrarArea({{ $area->id }})"
                data-area-id="{{ $area->id }}"
            >
                <i class="bi bi-tag-fill"></i> {{ $area->nombre }}
            </button>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Tabla de pedidos -->
    <div id="pedidosContainer">
        @if($pedidos->count() > 0)
        <div class="table-container">
            <div class="table-responsive">
                <table class="table align-middle" id="tablaPedidos">
                    <thead>
                        <tr>
                            <th>ID Pedido</th>
                            <th>Instructor Solicitante</th>
                            <th>Área</th>
                            <th>Fecha de Envío</th>
                            <th>Estado Actual</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pedidos as $pedido)
                        <tr class="pedido-row" data-area-id="{{ $pedido->usuario->areas_id ?? '0' }}">
                            <td data-label="ID Pedido">
                                <span class="fw-bold text-primary">#{{ $pedido->id }}</span>
                            </td>
                            <td data-label="Instructor">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-light rounded-circle p-2 d-none d-sm-block">
                                        <i class="bi bi-person text-muted"></i>
                                    </div>
                                    <span>{{ $pedido->usuario->nombre_completo ?? 'Desconocido' }}</span>
                                </div>
                            </td>
                            <td data-label="Área">
                                <span class="badge bg-light text-dark border">{{ $pedido->usuario->area->nombre ?? 'N/A' }}</span>
                            </td>
                            <td data-label="Fecha">
                                <div class="small">
                                    <i class="bi bi-calendar3 me-1 text-muted"></i> {{ $pedido->created_at->setTimezone(config('app.timezone'))->format('d/m/Y') }}<br>
                                    <i class="bi bi-clock me-1 text-muted"></i> {{ $pedido->created_at->setTimezone(config('app.timezone'))->format('H:i A') }}
                                </div>
                            </td>
                            <td data-label="Estado">
                                <span class="badge-status
                                    @if($pedido->estado == 'pendiente') bg-pendiente
                                    @elseif($pedido->estado == 'enviado') bg-enviado
                                    @elseif($pedido->estado == 'aprobado') bg-aprobado
                                    @else bg-default
                                    @endif">
                                    <i class="bi bi-dot fs-4 align-middle"></i> {{ ucfirst($pedido->estado) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.pedidos.show', $pedido->id) }}" class="btn-detalle">
                                    <i class="bi bi-eye-fill"></i> Ver Detalle
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="alerta-vacia">
            <i class="bi bi-inbox-fill"></i>
            <h5>No hay pedidos registrados</h5>
            <p>Los pedidos enviados por los instructores aparecerán aquí automáticamente.</p>
        </div>
        @endif
    </div>

    <!-- Mensaje cuando no hay resultados en el filtro -->
    <div id="noResultados" class="alerta-vacia d-none">
        <i class="bi bi-search"></i>
        <h5>No se encontraron pedidos</h5>
        <p>No hay pedidos registrados para el área seleccionada.</p>
    </div>
</div>

<script>
function filtrarArea(areaId) {
    console.log('Filtrando por Area ID:', areaId); // Debugging

    // Actualizar estado de los botones
    document.querySelectorAll('.btn-area').forEach(btn => {
        btn.classList.remove('active');
    });

    if (areaId === null) {
        document.querySelector('.btn-area[onclick="filtrarArea(null)"]').classList.add('active');
    } else {
        const activeBtn = document.querySelector(`.btn-area[data-area-id="${areaId}"]`);
        if(activeBtn) activeBtn.classList.add('active');
    }

    // Filtrar filas de la tabla
    const filas = document.querySelectorAll('.pedido-row');
    const tablaContainer = document.querySelector('.table-container');
    const noResultados = document.getElementById('noResultados');
    let visibles = 0;

    filas.forEach(fila => {
        const filaAreaId = fila.getAttribute('data-area-id');
        console.log('Fila ID:', fila.id, 'Area ID de la fila:', filaAreaId, 'Area ID a filtrar:', areaId); // Debugging

        // Convertir a número para una comparación estricta si es necesario, o usar == para comparación flexible
        if (areaId === null || parseInt(filaAreaId) === areaId) {
            fila.classList.remove('d-none');
            visibles++;
        } else {
            fila.classList.add('d-none');
        }
    });

    // Mostrar/ocultar tabla o mensaje de "sin resultados"
    if (visibles === 0) {
        if(tablaContainer) tablaContainer.classList.add('d-none');
        noResultados.classList.remove('d-none');
    } else {
        if(tablaContainer) tablaContainer.classList.remove('d-none');
        noResultados.classList.add('d-none');
    }
}

// Asegurarse de que el filtro inicial se aplique al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    // Activar el botón 'Todos' por defecto al cargar la página
    const allButton = document.querySelector('.btn-area[onclick="filtrarArea(null)"]');
    if (allButton) {
        allButton.classList.add('active');
    }
    filtrarArea(null);
});
</script>
@endsection
