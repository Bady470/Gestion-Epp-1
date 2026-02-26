@extends('layouts.dashboard')

@section('content')
<style>
    :root {
        --sena-green: #39A900;
        --sena-blue: #406479;
    }

    .header-section {
        background: linear-gradient(135deg, var(--sena-blue), var(--sena-green));
        color: white;
        padding: 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
    }

    .header-section h2 {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        margin: 0;
    }

    .header-section p {
        margin: 0.5rem 0 0 0;
        opacity: 0.95;
    }

    /* Filtros de área */
    .filtros-area {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        border: 2px solid #e0e0e0;
    }

    .filtros-area h5 {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        color: var(--sena-blue);
        margin-bottom: 1rem;
    }

    .area-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .btn-area {
        padding: 0.6rem 1.2rem;
        border: 2px solid #e0e0e0;
        background: white;
        color: var(--sena-blue);
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s ease;
        font-size: 0.9rem;
    }

    .btn-area:hover {
        border-color: var(--sena-green);
        background: #f0f0f0;
    }

    .btn-area.active {
        background: linear-gradient(135deg, var(--sena-blue), var(--sena-green));
        color: white;
        border-color: var(--sena-green);
    }

    .btn-area.active:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(57, 169, 0, 0.3);
    }

    /* Tabla mejorada */
    .table-responsive {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .table {
        margin-bottom: 0;
    }

    .table thead {
        background: linear-gradient(135deg, var(--sena-blue), var(--sena-green));
        color: white;
    }

    .table thead th {
        border: none;
        font-weight: 600;
        padding: 1rem;
    }

    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-color: #e0e0e0;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .badge {
        padding: 0.5rem 0.75rem;
        font-size: 0.85rem;
        font-weight: 600;
        border-radius: 6px;
    }

    .btn-detalle {
        background: linear-gradient(135deg, var(--sena-blue), #2d5a7a);
        color: white;
        border: none;
        padding: 0.6rem 1rem;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s ease;
        font-size: 0.85rem;
        text-decoration: none;
        display: inline-block;
    }

    .btn-detalle:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(64, 100, 121, 0.3);
        color: white;
    }

    .btn-productos-area {
        background: linear-gradient(135deg, var(--sena-green), #2d8a00);
        color: white;
        border: none;
        padding: 0.6rem 1rem;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s ease;
        font-size: 0.85rem;
        text-decoration: none;
        display: inline-block;
    }

    .btn-productos-area:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(57, 169, 0, 0.3);
        color: white;
    }

    /* Modal para productos por área */
    .modal-content {
        border-radius: 12px;
        border: none;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .modal-header {
        background: linear-gradient(135deg, var(--sena-blue), var(--sena-green));
        color: white;
        border: none;
        border-radius: 12px 12px 0 0;
    }

    .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }

    .modal-body {
        padding: 1.5rem;
    }

    .productos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .producto-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        border: 2px solid #e0e0e0;
        transition: all 0.3s ease;
    }

    .producto-card:hover {
        transform: translateY(-4px);
        border-color: var(--sena-green);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .producto-img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        background: #f0f0f0;
    }

    .producto-info {
        padding: 1rem;
    }

    .producto-nombre {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        color: #333;
        margin-bottom: 0.5rem;
        font-size: 1rem;
    }

    .producto-detalle {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        color: #666;
    }

    .producto-detalle i {
        width: 20px;
        color: var(--sena-blue);
        margin-right: 0.5rem;
    }

    .producto-detalle strong {
        color: #333;
        margin-right: 0.5rem;
    }

    .badge-cantidad {
        background: linear-gradient(135deg, var(--sena-blue), #2d5a7a);
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-block;
        margin-top: 0.5rem;
    }

    .badge-talla {
        background: linear-gradient(135deg, var(--sena-green), #2d8a00);
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-block;
        margin-left: 0.5rem;
    }

    .sin-productos {
        text-align: center;
        padding: 2rem;
        color: #666;
    }

    .sin-productos i {
        font-size: 3rem;
        color: var(--sena-blue);
        opacity: 0.5;
        margin-bottom: 1rem;
    }

    .alerta-vacia {
        background: linear-gradient(135deg, #e3f2fd, #bbdefb);
        border-left: 5px solid var(--sena-blue);
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        color: var(--sena-blue);
    }

    .alerta-vacia i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.7;
    }

    .alerta-vacia h5 {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
    }

    @media (max-width: 768px) {
        .area-buttons {
            gap: 0.5rem;
        }

        .btn-area {
            padding: 0.5rem 0.8rem;
            font-size: 0.8rem;
        }

        .productos-grid {
            grid-template-columns: 1fr;
        }

        .table {
            font-size: 0.85rem;
        }

        .table thead th,
        .table tbody td {
            padding: 0.75rem;
        }
    }

    /* Animaciones */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .producto-card {
        animation: slideIn 0.3s ease forwards;
    }

    .producto-card:nth-child(1) { animation-delay: 0.05s; }
    .producto-card:nth-child(2) { animation-delay: 0.1s; }
    .producto-card:nth-child(3) { animation-delay: 0.15s; }
    .producto-card:nth-child(4) { animation-delay: 0.2s; }
    .producto-card:nth-child(5) { animation-delay: 0.25s; }
    .producto-card:nth-child(6) { animation-delay: 0.3s; }
</style>

<div class="container py-4">
    <!-- Header -->
    <div class="header-section">
        <h2>📋 Pedidos Enviados</h2>
        <p>Gestiona y revisa los pedidos enviados por los instructores</p>
    </div>

    <!-- Filtros por área -->
    @php
        $areas = \App\Models\Area::all();
    @endphp

    @if($areas->count() > 0)
    <div class="filtros-area">
        <h5>
            <i class="bi bi-funnel"></i> Filtrar productos por área:
        </h5>
        <div class="area-buttons">
            <button type="button" class="btn-area active" onclick="filtrarArea(null)">
                <i class="bi bi-grid"></i> Todos los productos
            </button>
            @foreach($areas as $area)
            <button
                type="button"
                class="btn-area"
                onclick="filtrarArea({{ $area->id }})"
                data-area-id="{{ $area->id }}"
            >
                <i class="bi bi-tag"></i> {{ $area->nombre }}
            </button>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Tabla de pedidos -->
    @if($pedidos->count() > 0)
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Instructor</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedidos as $pedido)
                <tr>
                    <td>
                        <strong>#{{ $pedido->id }}</strong>
                    </td>
                    <td>
                        <i class="bi bi-person"></i> {{ $pedido->usuario->nombre_completo ?? 'Desconocido' }}
                    </td>
                    <td>
                        <i class="bi bi-calendar"></i> {{ $pedido->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td>
                        <span class="badge
                            @if($pedido->estado == 'pendiente') bg-warning text-dark
                            @elseif($pedido->estado == 'enviado') bg-info text-dark
                            @elseif($pedido->estado == 'aprobado') bg-success
                            @else bg-secondary
                            @endif">
                            {{ ucfirst($pedido->estado) }}
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.pedidos.show', $pedido->id) }}" class="btn-detalle">
                            👁️ Ver Detalle
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <!-- Sin pedidos -->
    <div class="alerta-vacia">
        <i class="bi bi-inbox"></i>
        <h5>No hay pedidos registrados</h5>
        <p>Los pedidos enviados por los instructores aparecerán aquí.</p>
    </div>
    @endif
</div>

<!-- Modal para ver productos por área -->
<div class="modal fade" id="modalProductosArea" tabindex="-1" aria-labelledby="modalProductosAreaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalProductosAreaLabel">
                    <i class="bi bi-box-seam"></i> Productos del Área
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="productosContainer" class="productos-grid">
                    <!-- Los productos se cargarán aquí con AJAX -->
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Variable para almacenar el área seleccionada
let areaSeleccionada = null;

// Función para filtrar por área
function filtrarArea(areaId) {
    areaSeleccionada = areaId;

    // Actualizar botones activos
    document.querySelectorAll('.btn-area').forEach(btn => {
        btn.classList.remove('active');
    });

    if (areaId === null) {
        document.querySelector('.btn-area').classList.add('active');
        cargarProductos(null);
    } else {
        document.querySelector(`[data-area-id="${areaId}"]`).classList.add('active');
        cargarProductos(areaId);
    }
}

// Función para cargar productos por AJAX
function cargarProductos(areaId) {
    const container = document.getElementById('productosContainer');

    // Mostrar loading
    container.innerHTML = '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Cargando...</span></div></div>';

    // Obtener token CSRF
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

    // Construir URL
    let url = '{{ route("admin.productos.area") }}';
    if (areaId) {
        url += `?area_id=${areaId}`;
    }

    // Hacer solicitud AJAX
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
                html += `
                    <div class="producto-card">
                        <img src="${producto.img_url ? '{{ asset('') }}' + producto.img_url : 'https://via.placeholder.com/280x180?text=Sin+imagen'}" alt="${producto.nombre}" class="producto-img">
                        <div class="producto-info">
                            <div class="producto-nombre">${producto.nombre}</div>

                            <div class="producto-detalle">
                                <i class="bi bi-box"></i>
                                <strong>Cantidad:</strong>
                                <span>${producto.cantidad}</span>
                            </div>

                            <div class="producto-detalle">
                                <i class="bi bi-rulers"></i>
                                <strong>Talla:</strong>
                                <span>${producto.talla || 'N/A'}</span>
                            </div>

                            <div class="producto-detalle">
                                <i class="bi bi-shield-check"></i>
                                <strong>Área:</strong>
                                <span>${producto.area?.nombre || 'N/A'}</span>
                            </div>

                            <div class="producto-detalle">
                                <i class="bi bi-info-circle"></i>
                                <strong>Protección:</strong>
                                <span>${producto.filtro?.parte_del_cuerpo || 'N/A'}</span>
                            </div>

                            <div style="margin-top: 0.75rem;">
                                <span class="badge-cantidad">
                                    <i class="bi bi-box-seam"></i> ${producto.cantidad} unidades
                                </span>
                                <span class="badge-talla">
                                    <i class="bi bi-rulers"></i> ${producto.talla || 'UNICA'}
                                </span>
                            </div>
                        </div>
                    </div>
                `;
            });

            container.innerHTML = html;
        } else {
            container.innerHTML = `
                <div class="sin-productos" style="grid-column: 1 / -1;">
                    <i class="bi bi-inbox"></i>
                    <h5>No hay productos en esta área</h5>
                    <p>No se encontraron equipos de protección personal para esta área.</p>
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        container.innerHTML = `
            <div class="sin-productos" style="grid-column: 1 / -1;">
                <i class="bi bi-exclamation-triangle"></i>
                <h5>Error al cargar productos</h5>
                <p>Hubo un error al cargar los productos. Intenta de nuevo.</p>
            </div>
        `;
    });

    // Abrir modal
    const modal = new bootstrap.Modal(document.getElementById('modalProductosArea'));
    modal.show();
}
</script>

@endsection
