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

    /* Modal y Grid de Productos */
    .modal-content {
        border-radius: 16px;
        border: none;
    }

    .modal-header {
        background: linear-gradient(135deg, var(--sena-blue), var(--sena-green));
        color: white;
        padding: 1.5rem;
        border-radius: 16px 16px 0 0;
    }

    .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }

    .productos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
        padding: 0.5rem;
    }

    .producto-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #eef0f2;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .producto-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        border-color: var(--sena-green);
    }

    .producto-img-wrapper {
        position: relative;
        width: 100%;
        height: 180px;
        background: #f8f9fa;
        overflow: hidden;
    }

    .producto-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .producto-card:hover .producto-img {
        transform: scale(1.05);
    }

    .producto-info {
        padding: 1.25rem;
        flex-grow: 1;
    }

    .producto-nombre {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        color: #333;
        margin-bottom: 1rem;
        font-size: 1.05rem;
        line-height: 1.4;
    }

    .producto-detalle {
        display: flex;
        align-items: center;
        margin-bottom: 0.6rem;
        font-size: 0.9rem;
        color: #666;
    }

    .producto-detalle i {
        width: 24px;
        color: var(--sena-blue);
        font-size: 1rem;
    }

    .producto-detalle strong {
        color: #444;
        margin-right: 0.5rem;
        font-weight: 600;
    }

    .badge-group {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
        flex-wrap: wrap;
    }

    .badge-custom {
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .badge-qty { background-color: #e1f5fe; color: #01579b; }
    .badge-size { background-color: #f3e5f5; color: #7b1fa2; }

    /* Responsive Adjustments */
    @media (max-width: 767.98px) {
        .header-section {
            padding: 1.5rem;
            text-align: center;
        }

        .header-section h2 {
            font-size: 1.5rem;
        }

        /* Table to Cards on Mobile */
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
            <i class="bi bi-funnel-fill"></i> Filtrar productos por área
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
    @if($pedidos->count() > 0)
    <div class="table-container">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>ID Pedido</th>
                        <th>Instructor Solicitante</th>
                        <th>Fecha de Envío</th>
                        <th>Estado Actual</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pedidos as $pedido)
                    <tr>
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
    <!-- Sin pedidos -->
    <div class="alerta-vacia">
        <i class="bi bi-inbox-fill"></i>
        <h5>No hay pedidos registrados</h5>
        <p>Los pedidos enviados por los instructores aparecerán aquí automáticamente.</p>
    </div>
    @endif
</div>

<!-- Modal para ver productos por área -->
<div class="modal fade" id="modalProductosArea" tabindex="-1" aria-labelledby="modalProductosAreaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalProductosAreaLabel">
                    <i class="bi bi-box-seam-fill me-2"></i> Equipos de Protección por Área
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light">
                <div id="productosContainer" class="productos-grid">
                    <!-- Los productos se cargarán aquí con AJAX -->
                </div>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-secondary px-4 rounded-pill" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
let areaSeleccionada = null;

function filtrarArea(areaId) {
    areaSeleccionada = areaId;

    document.querySelectorAll('.btn-area').forEach(btn => {
        btn.classList.remove('active');
    });

    if (areaId === null) {
        document.querySelector('.btn-area').classList.add('active');
        cargarProductos(null);
    } else {
        const activeBtn = document.querySelector(`[data-area-id="${areaId}"]`);
        if(activeBtn) activeBtn.classList.add('active');
        cargarProductos(areaId);
    }
}

function cargarProductos(areaId) {
    const container = document.getElementById('productosContainer');
    container.innerHTML = `
        <div class="text-center py-5 w-100" style="grid-column: 1/-1">
            <div class="spinner-border text-success" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="mt-2 text-muted">Buscando productos...</p>
        </div>
    `;

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
    let url = '{{ route("admin.productos.area") }}';
    if (areaId) {
        url += `?area_id=${areaId}`;
    }

    fetch(url, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.productos.length > 0) {
            let html = '';
            data.productos.forEach(producto => {
                const imgUrl = producto.img_url ? '{{ asset('') }}' + producto.img_url : 'https://via.placeholder.com/280x180?text=Sin+Imagen';
                html += `
                    <div class="producto-card shadow-sm">
                        <div class="producto-img-wrapper">
                            <img src="${imgUrl}" alt="${producto.nombre}" class="producto-img">
                        </div>
                        <div class="producto-info">
                            <div class="producto-nombre">${producto.nombre}</div>

                            <div class="producto-detalle">
                                <i class="bi bi-shield-check"></i>
                                <strong>Protección:</strong>
                                <span>${producto.filtro?.parte_del_cuerpo || 'N/A'}</span>
                            </div>

                            <div class="producto-detalle">
                                <i class="bi bi-building"></i>
                                <strong>Área:</strong>
                                <span>${producto.area?.nombre || 'N/A'}</span>
                            </div>

                            <div class="badge-group">
                                <span class="badge-custom badge-qty">
                                    <i class="bi bi-box-seam"></i> ${producto.cantidad} unidades
                                </span>
                                <span class="badge-custom badge-size">
                                    <i class="bi bi-rulers"></i> Talla: ${producto.talla || 'UNICA'}
                                </span>
                            </div>
                        </div>
                    </div>
                `;
            });
            container.innerHTML = html;
        } else {
            container.innerHTML = `
                <div class="text-center py-5 w-100" style="grid-column: 1 / -1;">
                    <i class="bi bi-search fs-1 text-muted opacity-25"></i>
                    <h5 class="mt-3 fw-bold text-muted">No hay productos</h5>
                    <p class="text-muted">No se encontraron equipos registrados para esta área.</p>
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        container.innerHTML = `
            <div class="alert alert-danger w-100" style="grid-column: 1 / -1;">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> Error al cargar los productos.
            </div>
        `;
    });

    const modal = new bootstrap.Modal(document.getElementById('modalProductosArea'));
    modal.show();
}
</script>
@endsection
