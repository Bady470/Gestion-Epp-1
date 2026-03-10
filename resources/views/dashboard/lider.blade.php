@extends('layouts.lider')

@section('content')
<style>
    :root {
        --sena-green: #39A900;
        --sena-blue: #406479;
        --sena-yellow: #FFC107;
    }

    /* Header Section */
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

    .pedidos-count {
        background: var(--sena-yellow);
        color: #333;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 700;
        display: inline-block;
    }

    /* Pedido Card */
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

    /* Badges */
    .estado-badge {
        padding: 0.6rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-block;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .estado-pendiente {
        background: linear-gradient(135deg, #fff3cd, #ffe69c);
        color: #856404;
        border: 1px solid #ffc107;
    }

    .estado-enviado {
        background: linear-gradient(135deg, #cfe2ff, #9ec5fe);
        color: #084298;
        border: 1px solid #0d6efd;
    }

    .ficha-info-box {
        background: linear-gradient(135deg, var(--sena-green), #2d8a00);
        color: white;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }

    .ficha-numero {
        font-size: 1.3rem;
        font-weight: 700;
    }

    .ficha-programa {
        font-size: 0.9rem;
        opacity: 0.95;
    }

    /* Table Styles */
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

    .elemento-nombre {
        font-weight: 600;
        color: #333;
        word-wrap: break-word;
        overflow-wrap: break-word;
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
        padding: 0.4rem 0.7rem;
        border-radius: 6px;
        font-weight: 600;
    }

    .pedido-body {
        padding: 1.5rem;
    }

    .pedido-footer {
        background: #f8f9fa;
        padding: 1.25rem 1.5rem;
        border-top: 2px solid #e0e0e0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }

    /* Buttons */
    .btn-accion {
        border-radius: 8px;
        font-weight: 600;
        padding: 0.6rem 1.2rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-enviar {
        background: linear-gradient(135deg, var(--sena-green), #2d8a00);
        color: white;
        border: none;
    }

    .btn-enviar:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(57, 169, 0, 0.3);
        color: white;
    }

    .btn-resumen {
        background: linear-gradient(135deg, var(--sena-blue), #2d5a7a);
        color: white;
        border: none;
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
    }

    .btn-global:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(64, 100, 121, 0.3);
        color: white;
    }

    .btn-exportar {
        background: linear-gradient(135deg, var(--sena-green), #2d8a00);
        color: white;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        border: none;
    }

    /* Modal Styles */
    .modal-content {
        border-radius: 12px;
        border: none;
    }

    .modal-header {
        background: linear-gradient(135deg, var(--sena-blue), var(--sena-green));
        color: white;
        border-radius: 12px 12px 0 0;
    }

    .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }

    .tabla-consolidada {
        width: 100%;
        border-collapse: collapse;
    }

    .tabla-consolidada th {
        padding: 1rem;
        background: #f8f9fa;
        border-bottom: 2px solid #e0e0e0;
        font-weight: 600;
    }

    .tabla-consolidada td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e0e0e0;
    }

    .talla-consolidada {
        background: var(--sena-green);
        color: white;
        padding: 0.3rem 0.6rem;
        border-radius: 4px;
        font-size: 0.8rem;
    }

    .cantidad-consolidada {
        background: var(--sena-blue);
        color: white;
        padding: 0.3rem 0.6rem;
        border-radius: 4px;
        font-weight: 700;
    }

    .totales-modal {
        background: #f8f9fa;
        padding: 1.25rem;
        border-radius: 8px;
        margin-top: 1.5rem;
        border-left: 4px solid var(--sena-green);
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }

    .total-valor {
        font-weight: 700;
        color: var(--sena-green);
    }

    .export-info {
        background: #e8f5e9;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        color: #2e7d32;
        font-size: 0.9rem;
    }

    /* Responsive Adjustments */
    @media (max-width: 767.98px) {
        .header-section {
            padding: 1.5rem;
            text-align: center;
        }

        .header-section .d-flex {
            flex-direction: column;
            align-items: center !important;
            gap: 1rem;
        }

        .pedido-header {
            flex-direction: column;
            align-items: stretch;
        }

        .pedido-header .text-end {
            text-align: left !important;
            margin-top: 0.5rem;
        }

        .info-label {
            min-width: 80px;
        }

        /* Table to Cards on Mobile */
        .elementos-table thead {
            display: none;
        }

        .elementos-table, .elementos-table tbody, .elementos-table tr, .elementos-table td {
            display: block;
            width: 100%;
        }

        .elementos-table tr {
            margin-bottom: 1rem;
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 0.5rem;
            background: #fdfdfd;
        }

        .elementos-table td {
            text-align: right;
            padding: 0.75rem 1rem;
            position: relative;
            border-bottom: 1px solid #f1f1f1;
            min-height: 3rem;
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        .elementos-table td:last-child {
            border-bottom: none;
        }

        .elementos-table td::before {
            content: attr(data-label);
            position: absolute;
            left: 1rem;
            width: 40%;
            text-align: left;
            font-weight: 700;
            color: #666;
            font-size: 0.75rem;
            text-transform: uppercase;
            top: 50%;
            transform: translateY(-50%);
        }

        /* Special handling for the "Elemento" cell to avoid overlap */
        .elementos-table td[data-label="Elemento"] {
            flex-direction: column;
            align-items: flex-end;
            text-align: right;
            padding-left: 45%; /* Give more space to the label */
        }

        .elementos-table td[data-label="Elemento"]::before {
            top: 1rem;
            transform: none;
        }

        .pedido-footer {
            flex-direction: column;
            align-items: stretch;
        }

        .pedido-footer div:last-child {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .btn-accion, .btn-global {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="container py-4">
    <!-- Header -->
    <div class="header-section">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h2>📋 Pedidos Recibidos</h2>
                <p>Gestiona las solicitudes de equipos de protección personal</p>
                <div class="mt-3">
                    <span class="badge bg-white bg-opacity-25 border border-white border-opacity-50 px-3 py-2 rounded-pill">
                        <i class="bi bi-building me-1"></i> Área: <strong>{{ auth()->user()->area->nombre ?? 'No asignada' }}</strong>
                    </span>
                </div>
            </div>
            @if($pedidos->count() > 0)
            <div class="pedidos-count shadow-sm">
                <i class="bi bi-inbox-fill me-1"></i> {{ $pedidos->count() }} pedido(s)
            </div>
            @endif
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Contenido Principal -->
    @if($pedidos->count() > 0)

    <!-- Botón Global Superior -->
    <div class="text-center mb-4">
        <form action="{{ route('lider.enviar.todos') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-global shadow"
                onclick="return confirm('¿Enviar los {{ $pedidos->count() }} pedidos pendientes al administrador?')">
                <i class="bi bi-send-fill me-2"></i> Enviar Todos al Administrador
            </button>
        </form>
    </div>

    <!-- Lista de Pedidos -->
    @foreach($pedidos as $pedido)
    <div class="pedido-card">
        <div class="pedido-header">
            <div class="pedido-info">
                <h5>
                    <i class="bi bi-person-circle me-2 text-primary"></i> {{ $pedido->usuario->nombre_completo ?? 'Desconocido' }}
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
                    @else bg-secondary text-white @endif">
                    <i class="bi bi-circle-fill me-1" style="font-size: 0.6rem;"></i> {{ ucfirst($pedido->estado) }}
                </div>
            </div>
        </div>

        <div class="pedido-body">
            <!-- Información de la ficha -->
            @if($pedido->ficha)
            <div class="ficha-info-box shadow-sm">
                <h6 class="mb-2 fw-bold">
                    <i class="bi bi-file-earmark-text me-2"></i> Ficha Asignada
                </h6>
                <div class="ficha-numero">{{ $pedido->ficha->numero }}</div>
                <div class="ficha-programa">
                    <i class="bi bi-book me-1"></i> {{ $pedido->ficha->programa->nombre ?? 'Programa desconocido' }}
                </div>
            </div>
            @else
            <div class="alert alert-warning border-start border-4 py-2">
                <i class="bi bi-exclamation-triangle me-2"></i> <strong>Sin ficha asignada</strong>
            </div>
            @endif

            <!-- Tabla de elementos -->
            <h6 class="fw-bold mb-3 text-dark">
                <i class="bi bi-box-seam me-2 text-success"></i> Elementos Solicitados
            </h6>
            <div class="table-responsive">
                <table class="elementos-table">
                    <thead>
                        <tr>
                            <th>Elemento</th>
                            <th class="text-center">Talla</th>
                            <th class="text-center">Cantidad</th>
                            <th>Área</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pedido->elementos as $item)
                        <tr>
                            <td data-label="Elemento">
                                <div class="elemento-nombre">{{ $item->nombre }}</div>
                                @if($item->filtro)
                                <small class="text-muted">
                                    <i class="bi bi-shield-check me-1"></i> {{ $item->filtro->parte_del_cuerpo ?? '-' }}
                                </small>
                                @endif
                            </td>
                            <td data-label="Talla" class="text-md-center">
                                <span class="elemento-talla">{{ $item->pivot->talla ?? 'Sin talla' }}</span>
                            </td>
                            <td data-label="Cantidad" class="text-md-center">
                                <span class="cantidad-badge">{{ $item->pivot->cantidad ?? 1 }}</span>
                            </td>
                            <td data-label="Área">
                                <span class="text-muted small">{{ $item->area->nombre ?? '-' }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">No hay elementos en este pedido</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="pedido-footer">
            <div class="small text-muted">
                <i class="bi bi-hash"></i> ID Pedido: <strong>#{{ $pedido->id }}</strong>
            </div>
            <div class="d-flex gap-2">
                @if($pedido->estado == 'pendiente')
                <form action="{{ route('lider.enviar', $pedido->id) }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-accion btn-enviar shadow-sm">
                        <i class="bi bi-send-fill"></i> Enviar al Admin
                    </button>
                </form>
                @endif
                <button type="button" class="btn btn-accion btn-resumen shadow-sm" onclick="abrirResumenConsolidado()">
                    <i class="bi bi-receipt-cutoff"></i> Ver Resumen
                </button>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Botón Global Inferior -->
    <div class="text-center mt-4 mb-5">
        <form action="{{ route('lider.enviar.todos') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-global shadow"
                onclick="return confirm('¿Enviar los {{ $pedidos->count() }} pedidos pendientes al administrador?')">
                <i class="bi bi-send-fill me-2"></i> Enviar Todos al Administrador
            </button>
        </form>
    </div>

    @else
    <!-- Estado Vacío -->
    <div class="card border-0 shadow-sm py-5 text-center rounded-4">
        <div class="card-body">
            <i class="bi bi-inbox text-muted mb-3" style="font-size: 4rem; opacity: 0.3;"></i>
            <h4 class="fw-bold text-muted">No hay pedidos pendientes</h4>
            <p class="text-muted">No hay solicitudes de equipos de protección personal para tu área en este momento.</p>
        </div>
    </div>
    @endif
</div>

<!-- Modal para Resumen Consolidado -->
<div class="modal fade" id="modalResumenConsolidado" tabindex="-1" aria-labelledby="modalResumenLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="modalResumenLabel">
                    <i class="bi bi-receipt-cutoff me-2"></i> Resumen Consolidado del Área
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div id="resumenContainer">
                    <div class="text-center py-5">
                        <div class="spinner-border text-success" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <p class="mt-2 text-muted">Generando consolidado...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-0">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-exportar px-4 shadow-sm" id="btnExportarExcel" onclick="exportarExcel()" style="display: none;">
                    <i class="bi bi-file-earmark-excel-fill me-2"></i> Exportar a Excel GFPI-F-186
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function abrirResumenConsolidado() {
        const container = document.getElementById('resumenContainer');
        const btnExportar = document.getElementById('btnExportarExcel');

        // Reset container and show modal
        container.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-success" role="status"></div><p class="mt-2 text-muted">Generando consolidado...</p></div>';
        const modal = new bootstrap.Modal(document.getElementById('modalResumenConsolidado'));
        modal.show();

        fetch(`{{ route('lider.resumen-consolidado') }}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let html = `
                        <div class="export-info shadow-sm">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            Consolidación de <strong>${data.total_pedidos}</strong> pedido(s) del área
                        </div>
                        <div class="table-responsive">
                            <table class="tabla-consolidada">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th class="text-center">Talla</th>
                                        <th class="text-center">Cantidad Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;

                    data.consolidado.forEach(item => {
                        html += `
                            <tr>
                                <td><span class="fw-bold text-dark">${item.nombre}</span></td>
                                <td class="text-center"><span class="talla-consolidada">${item.talla}</span></td>
                                <td class="text-center"><span class="cantidad-consolidada shadow-sm">${item.cantidad_total}</span></td>
                            </tr>
                        `;
                    });

                    html += `
                                </tbody>
                            </table>
                        </div>
                        <div class="totales-modal shadow-sm">
                            <div class="total-row">
                                <span><i class="bi bi-box-seam me-2"></i> Productos diferentes:</span>
                                <span class="total-valor">${data.consolidado.length}</span>
                            </div>
                            <div class="total-row">
                                <span><i class="bi bi-plus-circle me-2"></i> Total unidades:</span>
                                <span class="total-valor">${data.total_unidades}</span>
                            </div>
                            <div class="total-row border-top pt-2 mt-2">
                                <span><i class="bi bi-inbox me-2"></i> Pedidos procesados:</span>
                                <span class="total-valor">${data.total_pedidos}</span>
                            </div>
                        </div>
                    `;
                    container.innerHTML = html;
                    btnExportar.style.display = 'inline-flex';
                } else {
                    container.innerHTML = '<div class="text-center py-5 text-muted"><i class="bi bi-inbox fs-1 opacity-25"></i><p class="mt-2">No hay datos disponibles</p></div>';
                    btnExportar.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                container.innerHTML = '<div class="alert alert-danger"><i class="bi bi-exclamation-triangle me-2"></i> Error al cargar el resumen</div>';
                btnExportar.style.display = 'none';
            });
    }

    function exportarExcel() {
        const btnExportar = document.getElementById('btnExportarExcel');
        const originalContent = btnExportar.innerHTML;
        btnExportar.disabled = true;
        btnExportar.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Generando...';

        fetch(`{{ route('lider.exportar-gfpi-f186') }}`)
            .then(response => {
                if (!response.ok) throw new Error('Error en la descarga');
                return response.blob();
            })
            .then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `GFPI-F-186_{{ auth()->user()->area->nombre ?? 'Area' }}_${new Date().toISOString().split('T')[0]}.xlsx`;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);
                btnExportar.disabled = false;
                btnExportar.innerHTML = originalContent;
            })
            .catch(error => {
                console.error('Error:', error);
                btnExportar.disabled = false;
                btnExportar.innerHTML = originalContent;
                alert('Error al descargar el archivo');
            });
    }
</script>
@endsection
