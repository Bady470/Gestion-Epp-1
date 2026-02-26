@extends('layouts.lider')

@section('content')
<style>
    :root {
        --sena-green: #39A900;
        --sena-blue: #406479;
        --sena-yellow: #FFC107;
    }

    .header-section {
        background: linear-gradient(135deg, var(--sena-blue), var(--sena-green));
        color: white;
        padding: 2rem;
        margin-bottom: 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .header-section h2 {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        margin-bottom: 0.5rem;
        font-size: 2rem;
    }

    .header-section p {
        font-size: 1rem;
        opacity: 0.95;
        margin: 0;
    }

    .pedido-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
        border-left: 5px solid var(--sena-green);
        transition: all 0.3s ease;
    }

    .pedido-card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }

    .pedido-header {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        padding: 1.5rem;
        border-bottom: 2px solid #e0e0e0;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
    }

    .pedido-info {
        flex: 1;
    }

    .pedido-info h5 {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        color: #333;
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }

    .info-row {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
        color: #666;
    }

    .info-row i {
        width: 24px;
        color: var(--sena-blue);
        margin-right: 0.75rem;
    }

    .info-label {
        font-weight: 600;
        color: #333;
        min-width: 100px;
    }

    .estado-badge {
        padding: 0.75rem 1.25rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-block;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .estado-pendiente {
        background: linear-gradient(135deg, #fff3cd, #ffe69c);
        color: #856404;
        border: 2px solid #ffc107;
    }

    .estado-enviado {
        background: linear-gradient(135deg, #cfe2ff, #9ec5fe);
        color: #084298;
        border: 2px solid #0d6efd;
    }

    .ficha-info-box {
        background: linear-gradient(135deg, var(--sena-green), #2d8a00);
        color: white;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .ficha-numero {
        font-size: 1.3rem;
        font-weight: 700;
    }

    .ficha-programa {
        font-size: 0.9rem;
        opacity: 0.95;
    }

    .elementos-table {
        width: 100%;
        border-collapse: collapse;
    }

    .elementos-table thead {
        background: #f8f9fa;
        border-bottom: 2px solid #e0e0e0;
    }

    .elementos-table th {
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        color: #333;
        font-size: 0.9rem;
    }

    .elementos-table td {
        padding: 1rem;
        border-bottom: 1px solid #e0e0e0;
    }

    .elementos-table tbody tr:hover {
        background: #f8f9fa;
    }

    .elemento-nombre {
        font-weight: 600;
        color: #333;
    }

    .elemento-talla {
        display: inline-block;
        background: var(--sena-blue);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .cantidad-badge {
        display: inline-block;
        background: var(--sena-green);
        color: white;
        padding: 0.5rem 0.75rem;
        border-radius: 6px;
        font-weight: 600;
    }

    .pedido-body {
        padding: 1.5rem;
    }

    .pedido-footer {
        background: #f8f9fa;
        padding: 1.5rem;
        border-top: 2px solid #e0e0e0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }

    .btn-accion {
        border-radius: 8px;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-enviar {
        background: linear-gradient(135deg, var(--sena-green), #2d8a00);
        color: white;
    }

    .btn-enviar:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(57, 169, 0, 0.3);
        color: white;
    }

    .btn-resumen {
        background: linear-gradient(135deg, var(--sena-blue), #2d5a7a);
        color: white;
    }

    .btn-resumen:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(64, 100, 121, 0.3);
        color: white;
    }

    .btn-global {
        background: linear-gradient(135deg, var(--sena-blue), #2d5a7a);
        color: white;
        border-radius: 12px;
        padding: 1rem 2rem;
        font-weight: 700;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-global:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(64, 100, 121, 0.3);
        color: white;
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

    .alerta-vacia h4 {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .pedidos-count {
        background: var(--sena-yellow);
        color: #333;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 700;
        display: inline-block;
    }

    /* Modal mejorado */
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

    /* Tabla consolidada en modal */
    .tabla-consolidada {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }

    .tabla-consolidada thead {
        background: #f8f9fa;
        border-bottom: 2px solid #e0e0e0;
    }

    .tabla-consolidada thead th {
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        color: #333;
        font-size: 0.9rem;
    }

    .tabla-consolidada tbody td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e0e0e0;
    }

    .tabla-consolidada tbody tr:hover {
        background: #f8f9fa;
    }

    .tabla-consolidada tbody tr:last-child td {
        border-bottom: none;
    }

    .talla-consolidada {
        background: var(--sena-green);
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-block;
    }

    .cantidad-consolidada {
        background: var(--sena-blue);
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-block;
    }

    .totales-modal {
        background: linear-gradient(135deg, #f0f0f0, #e9ecef);
        padding: 1.5rem;
        border-radius: 8px;
        margin-top: 1.5rem;
        border-left: 4px solid var(--sena-green);
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .total-row:last-child {
        margin-bottom: 0;
        border-top: 2px solid #e0e0e0;
        padding-top: 0.75rem;
        margin-top: 0.75rem;
    }

    .total-label {
        font-weight: 600;
        color: #333;
    }

    .total-valor {
        font-weight: 700;
        color: var(--sena-green);
        font-size: 1.1rem;
    }

    .spinner-container {
        text-align: center;
        padding: 2rem;
    }

    .spinner-border {
        color: var(--sena-green);
    }

    @media (max-width: 768px) {
        .header-section h2 {
            font-size: 1.5rem;
        }

        .pedido-header {
            flex-direction: column;
        }

        .pedido-footer {
            flex-direction: column;
        }

        .elementos-table {
            font-size: 0.85rem;
        }

        .elementos-table th,
        .elementos-table td {
            padding: 0.75rem 0.5rem;
        }
    }
</style>

<div class="container py-4">
    <!-- Header mejorado -->
    <div class="header-section">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h2>📋 Pedidos Recibidos</h2>
                <p class="text-white-50">Gestiona las solicitudes de equipos de protección personal</p>
                <div style="margin-top: 1rem;">
                    <span style="display: inline-block; background: rgba(255, 255, 255, 0.2); padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600; border: 2px solid rgba(255, 255, 255, 0.3);">
                        <i class="bi bi-building"></i> Área: <strong>{{ auth()->user()->area->nombre ?? 'No asignada' }}</strong>
                    </span>
                </div>
            </div>
            @if($pedidos->count() > 0)
            <div class="pedidos-count">
                <i class="bi bi-inbox"></i> {{ $pedidos->count() }} pedido(s)
            </div>
            @endif
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
    <div class="alert alert-success">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">
        <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
    </div>
    @endif

    <!-- Contenido principal -->
    @if($pedidos->count() > 0)

    <!-- Botón global superior -->
    <div class="text-center mb-4">
        <form action="{{ route('lider.enviar.todos') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-global"
                onclick="return confirm('¿Enviar los {{ $pedidos->count() }} pedidos pendientes al administrador?')">
                <i class="bi bi-send"></i> Enviar Todos ({{ $pedidos->count() }})
            </button>
        </form>
    </div>

    <!-- Lista de pedidos -->
    @foreach($pedidos as $pedido)
    <div class="pedido-card">
        <!-- Header del pedido -->
        <div class="pedido-header">
            <div class="pedido-info">
                <h5>
                    <i class="bi bi-person-circle"></i> {{ $pedido->usuario->nombre_completo ?? 'Desconocido' }}
                </h5>
                <div class="info-row">
                    <i class="bi bi-building"></i>
                    <span class="info-label">Área:</span>
                    <span>{{ $pedido->usuario->area->nombre ?? 'No asignada' }}</span>
                </div>
                <div class="info-row">
                    <i class="bi bi-calendar-event"></i>
                    <span class="info-label">Fecha:</span>
                    <span>{{ $pedido->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
            <div class="text-end">
                <div class="estado-badge
                    @if($pedido->estado == 'pendiente') estado-pendiente
                    @elseif($pedido->estado == 'enviado') estado-enviado
                    @else bg-secondary @endif">
                    <i class="bi bi-circle-fill"></i> {{ ucfirst($pedido->estado) }}
                </div>
            </div>
        </div>

        <!-- Cuerpo del pedido -->
        <div class="pedido-body">
            <!-- Información de la ficha -->
            @if($pedido->ficha)
            <div class="ficha-info-box">
                <h6>
                    <i class="bi bi-file-earmark"></i> Ficha Asignada
                </h6>
                <div class="ficha-numero">{{ $pedido->ficha->numero }}</div>
                <div class="ficha-programa">
                    <i class="bi bi-book"></i> {{ $pedido->ficha->programa->nombre ?? 'Programa desconocido' }}
                </div>
            </div>
            @else
            <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; border-left: 4px solid #f5c6cb;">
                <i class="bi bi-exclamation-triangle"></i> <strong>Sin ficha asignada</strong>
            </div>
            @endif

            <!-- Tabla de elementos -->
            <h6 style="font-weight: 700; margin-bottom: 1rem; color: #333;">
                <i class="bi bi-box-seam"></i> Elementos Solicitados
            </h6>
            <div style="overflow-x: auto;">
                <table class="elementos-table">
                    <thead>
                        <tr>
                            <th>Elemento</th>
                            <th>Talla</th>
                            <th>Cantidad</th>
                            <th>Área</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pedido->elementos as $item)
                        <tr>
                            <td>
                                <div class="elemento-nombre">{{ $item->nombre }}</div>
                                @if($item->filtro)
                                <small style="color: #666;">
                                    <i class="bi bi-shield-check"></i> {{ $item->filtro->parte_del_cuerpo ?? '-' }}
                                </small>
                                @endif
                            </td>
                            <td>
                                <span class="elemento-talla">
                                    {{ $item->pivot->talla ?? 'Sin talla' }}
                                </span>
                            </td>
                            <td>
                                <span class="cantidad-badge">
                                    {{ $item->pivot->cantidad ?? 1 }}
                                </span>
                            </td>
                            <td>
                                @if($item->area)
                                <span style="color: #666;">{{ $item->area->nombre }}</span>
                                @else
                                <span style="color: #999;">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                No hay elementos en este pedido
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer del pedido -->
        <div class="pedido-footer">
            <div>
                <small style="color: #666;">
                    <i class="bi bi-hash"></i> ID Pedido: <strong>#{{ $pedido->id }}</strong>
                </small>
            </div>
            <div style="display: flex; gap: 1rem;">
                @if($pedido->estado == 'pendiente')
                <form action="{{ route('lider.enviar', $pedido->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-accion btn-enviar">
                        <i class="bi bi-send"></i> Enviar al Admin
                    </button>
                </form>
                @endif

                <!-- 👈 NUEVO: Botón para ver resumen consolidado -->
                <button type="button" class="btn btn-accion btn-resumen" onclick="abrirResumenConsolidado()">
                    <i class="bi bi-receipt-cutoff"></i> Ver Resumen
                </button>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Botón global inferior -->
    <div class="text-center mt-4">
        <form action="{{ route('lider.enviar.todos') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-global"
                onclick="return confirm('¿Enviar los {{ $pedidos->count() }} pedidos pendientes al administrador?')">
                <i class="bi bi-send"></i> Enviar Todos al Administrador
            </button>
        </form>
    </div>

    @else
    <!-- Sin pedidos -->
    <div class="alerta-vacia">
        <i class="bi bi-inbox"></i>
        <h4>No hay pedidos</h4>
        <p>No hay solicitudes de equipos de protección personal para tu área en este momento.</p>
    </div>
    @endif
</div>

<!-- 👈 NUEVO: Modal para resumen consolidado -->
<div class="modal fade" id="modalResumenConsolidado" tabindex="-1" aria-labelledby="modalResumenLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalResumenLabel">
                    <i class="bi bi-receipt-cutoff"></i> Resumen Consolidado del Área
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="resumenContainer">
                    <div class="spinner-container">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // 👈 NUEVA: Función para abrir modal con resumen consolidado
    function abrirResumenConsolidado() {
        const areaId = {{ auth()->user()->areas_id }};
        const container = document.getElementById('resumenContainer');

        // Mostrar modal
        const modal = new bootstrap.Modal(document.getElementById('modalResumenConsolidado'));
        modal.show();

        // Cargar datos
        fetch(`/lider/resumen-consolidado`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let html = `
                        <p style="color: #666; margin-bottom: 1rem;">
                            <i class="bi bi-info-circle"></i>
                            Consolidación de <strong>${data.total_pedidos}</strong> pedido(s) del área
                        </p>

                        <table class="tabla-consolidada">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Talla</th>
                                    <th class="text-center">Cantidad Total</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;

                    data.consolidado.forEach(item => {
                        html += `
                            <tr>
                                <td><strong>${item.nombre}</strong></td>
                                <td>
                                    <span class="talla-consolidada">${item.talla}</span>
                                </td>
                                <td class="text-center">
                                    <span class="cantidad-consolidada">${item.cantidad_total}</span>
                                </td>
                            </tr>
                        `;
                    });

                    html += `
                            </tbody>
                        </table>

                        <div class="totales-modal">
                            <div class="total-row">
                                <span class="total-label">
                                    <i class="bi bi-box-seam"></i> Total de productos diferentes:
                                </span>
                                <span class="total-valor">${data.consolidado.length}</span>
                            </div>

                            <div class="total-row">
                                <span class="total-label">
                                    <i class="bi bi-sum"></i> Total de unidades:
                                </span>
                                <span class="total-valor">${data.total_unidades}</span>
                            </div>

                            <div class="total-row">
                                <span class="total-label">
                                    <i class="bi bi-file-earmark"></i> Total de pedidos:
                                </span>
                                <span class="total-valor">${data.total_pedidos}</span>
                            </div>
                        </div>
                    `;

                    container.innerHTML = html;
                } else {
                    container.innerHTML = `
                        <div style="text-align: center; padding: 2rem; color: #666;">
                            <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.5;"></i>
                            <h5 style="margin-top: 1rem;">No hay datos disponibles</h5>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                container.innerHTML = `
                    <div style="text-align: center; padding: 2rem; color: #d32f2f;">
                        <i class="bi bi-exclamation-triangle" style="font-size: 3rem;"></i>
                        <h5 style="margin-top: 1rem;">Error al cargar el resumen</h5>
                    </div>
                `;
            });
    }
</script>

@endsection
