@extends('layouts.dashboard')

@section('content')
<style>
    :root {
        --sena-green: #39A900;
        --sena-blue: #406479;
        --sena-yellow: #FFC107;
    }

    /* Header del pedido */
    .header-pedido {
        background: linear-gradient(135deg, var(--sena-blue), var(--sena-green));
        color: white;
        padding: 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .header-pedido h2 {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        margin-bottom: 1.5rem;
        font-size: 1.8rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .info-pedido {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.25rem;
    }

    .info-item {
        background: rgba(255, 255, 255, 0.15);
        padding: 1.25rem;
        border-radius: 12px;
        border-left: 4px solid white;
        backdrop-filter: blur(5px);
    }

    .info-item label {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.9;
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    .info-item strong {
        font-size: 1.1rem;
        display: block;
        line-height: 1.4;
    }

    /* Estados */
    .badge-estado {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.2rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .badge-pendiente { background: white; color: #856404; }
    .badge-enviado { background: #e1f5fe; color: #01579b; }
    .badge-aprobado { background: #e8f5e9; color: #1b5e20; }

    /* Tablas Responsivas */
    .card-custom {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
        border: 1px solid #edf2f7;
    }

    .table-custom {
        width: 100%;
        margin-bottom: 0;
    }

    .table-custom thead {
        background: #f8fafc;
        border-bottom: 2px solid #edf2f7;
    }

    .table-custom th {
        padding: 1.25rem 1rem;
        font-weight: 700;
        color: var(--sena-blue);
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }

    .table-custom td {
        padding: 1.25rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #edf2f7;
    }

    /* Badges de Elementos */
    .badge-qty {
        background: #e1f5fe;
        color: #01579b;
        padding: 0.5rem 0.8rem;
        border-radius: 8px;
        font-weight: 700;
    }

    .badge-size {
        background: #f3e5f5;
        color: #7b1fa2;
        padding: 0.5rem 0.8rem;
        border-radius: 8px;
        font-weight: 700;
    }

    .badge-area {
        background: #f1f5f9;
        color: #475569;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-size: 0.85rem;
        border: 1px solid #e2e8f0;
    }

    /* Resumen Consolidado */
    .resumen-header {
        background: linear-gradient(135deg, var(--sena-blue), var(--sena-green));
        color: white;
        padding: 1.25rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 12px 12px 0 0;
    }

    .resumen-header h5 {
        margin: 0;
        font-weight: 700;
        font-family: 'Poppins', sans-serif;
    }

    .btn-toggle {
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid white;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s;
        cursor: pointer;
    }

    .btn-toggle:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.05);
    }

    .resumen-body {
        padding: 1.5rem;
        display: none;
    }

    .resumen-body.mostrar {
        display: block;
    }

    .totales-box {
        background: #f8fafc;
        padding: 1.5rem;
        border-radius: 12px;
        margin-top: 1.5rem;
        border: 1px solid #edf2f7;
        border-left: 4px solid var(--sena-green);
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px dashed #cbd5e1;
    }

    .total-row:last-child {
        border-bottom: none;
        padding-top: 1rem;
        margin-top: 0.5rem;
        border-top: 2px solid #e2e8f0;
    }

    .total-label { font-weight: 600; color: #64748b; }
    .total-value { font-weight: 800; color: var(--sena-green); font-size: 1.2rem; }

    /* Acciones */
    .acciones-footer {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        margin-bottom: 3rem;
    }

    .btn-sena {
        padding: 0.8rem 1.5rem;
        border-radius: 10px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        transition: all 0.2s;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .btn-sena-light { background: #f1f5f9; color: #475569; }
    .btn-sena-light:hover { background: #e2e8f0; }
    .btn-sena-blue { background: var(--sena-blue); color: white; }
    .btn-sena-blue:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(64, 100, 121, 0.3); color: white; }

    /* Responsive */
    @media (max-width: 767.98px) {
        .header-pedido { padding: 1.5rem; }
        .header-pedido h2 { font-size: 1.4rem; }

        /* Table to Cards */
        .table-custom thead { display: none; }
        .table-custom, .table-custom tbody, .table-custom tr, .table-custom td {
            display: block;
            width: 100%;
        }
        .table-custom tr {
            padding: 1rem;
            border-bottom: 8px solid #f8fafc;
        }
        .table-custom td {
            text-align: right;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .table-custom td::before {
            content: attr(data-label);
            font-weight: 700;
            color: var(--sena-blue);
            font-size: 0.7rem;
            text-transform: uppercase;
        }
        .table-custom td:last-child { border-bottom: none; }

        .acciones-footer { flex-direction: column; }
        .btn-sena { width: 100%; justify-content: center; }

        .resumen-header { flex-direction: column; gap: 1rem; text-align: center; }
    }

    @media print {
        .acciones-footer, .btn-toggle { display: none; }
        .resumen-body { display: block !important; }
        .header-pedido { background: white !important; color: black !important; border: 1px solid #ccc; }
        .info-item { border: 1px solid #eee !important; color: black !important; }
    }
</style>

<div class="container py-4">
    <!-- Header -->
    <div class="header-pedido">
        <h2><i class="bi bi-receipt-cutoff"></i> Detalle del Pedido #{{ $pedido->id }}</h2>

        <div class="info-pedido">
            <div class="info-item">
                <label>Instructor Solicitante</label>
                <strong>{{ $pedido->usuario->nombre_completo }}</strong>
            </div>
            <div class="info-item">
                <label>Fecha y Hora</label>
                <strong>{{ $pedido->created_at->setTimezone(config('app.timezone'))->format('d/m/Y - h:i A') }}</strong>
            </div>
            <div class="info-item">
                <label>Estado del Pedido</label>
                <div class="mt-1">
                    <span class="badge-estado badge-{{ $pedido->estado }}">
                        @if($pedido->estado == 'pendiente') <i class="bi bi-clock-history"></i> Pendiente
                        @elseif($pedido->estado == 'enviado') <i class="bi bi-send-check"></i> Enviado
                        @elseif($pedido->estado == 'aprobado') <i class="bi bi-check-all"></i> Aprobado
                        @else <i class="bi bi-info-circle"></i> {{ ucfirst($pedido->estado) }}
                        @endif
                    </span>
                </div>
            </div>
            @if($pedido->ficha)
            <div class="info-item">
                <label>Ficha y Programa</label>
                <strong>{{ $pedido->ficha->numero }}</strong>
                <small class="d-block opacity-75">{{ $pedido->ficha->programa->nombre ?? 'N/A' }}</small>
            </div>
            @endif
        </div>
    </div>

    <!-- Tabla de Elementos Actuales -->
    <h4 class="fw-bold mb-3 text-dark"><i class="bi bi-box-seam me-2 text-success"></i> Elementos de Este Pedido</h4>
    @if($pedido->elementos->count() > 0)
    <div class="card-custom">
        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>Producto / Elemento</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Talla</th>
                        <th>Área Destino</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pedido->elementos as $item)
                    <tr>
                        <td data-label="Producto">
                            <div class="fw-bold text-dark">{{ $item->nombre }}</div>
                            @if($item->filtro)
                            <small class="text-muted"><i class="bi bi-shield-check me-1"></i>{{ $item->filtro->parte_del_cuerpo }}</small>
                            @endif
                        </td>
                        <td data-label="Cantidad" class="text-md-center">
                            <span class="badge-qty">{{ $item->pivot->cantidad }}</span>
                        </td>
                        <td data-label="Talla" class="text-md-center">
                            <span class="badge-size">{{ $item->pivot->talla ?? 'ÚNICA' }}</span>
                        </td>
                        <td data-label="Área">
                            <span class="badge-area">{{ $item->area->nombre ?? 'N/A' }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="alert alert-warning border-0 shadow-sm rounded-4 p-4 mb-4">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> <strong>Este pedido no contiene elementos.</strong>
    </div>
    @endif

    <!-- Resumen Consolidado del Área -->
    @if(isset($pedidosDelArea) && $pedidosDelArea->count() > 0 && isset($area))
    <div class="card-custom">
        <div class="resumen-header">
            <h5><i class="bi bi-calculator me-2"></i> Resumen Consolidado del Área: {{ $area->nombre }}</h5>
            <button class="btn-toggle" onclick="toggleResumen()">
                <i class="bi bi-chevron-down" id="iconoResumen"></i> <span id="toggleText">Expandir Resumen</span>
            </button>
        </div>
        <div class="resumen-body" id="resumenBody">
            <div class="alert alert-info border-0 bg-light mb-4">
                <i class="bi bi-info-circle-fill me-2"></i> Consolidación de <strong>{{ $pedidosDelArea->count() }}</strong> pedido(s) del área.
            </div>

            @php
                $consolidado = [];
                foreach ($pedidosDelArea as $pedidoArea) {
                    foreach ($pedidoArea->elementos as $elemento) {
                        $clave = $elemento->nombre . '|' . ($elemento->pivot->talla ?? 'Sin talla');
                        if (!isset($consolidado[$clave])) {
                            $consolidado[$clave] = [
                                'nombre' => $elemento->nombre,
                                'talla' => $elemento->pivot->talla ?? 'ÚNICA',
                                'cantidad_total' => 0,
                                'proteccion' => $elemento->filtro->parte_del_cuerpo ?? 'N/A',
                            ];
                        }
                        $consolidado[$clave]['cantidad_total'] += $elemento->pivot->cantidad;
                    }
                }
                uasort($consolidado, function($a, $b) { return strcmp($a['nombre'], $b['nombre']); });
            @endphp

            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Protección</th>
                            <th class="text-center">Talla</th>
                            <th class="text-center">Total Unidades</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($consolidado as $item)
                        <tr>
                            <td data-label="Producto"><strong>{{ $item['nombre'] }}</strong></td>
                            <td data-label="Protección"><small class="text-muted">{{ $item['proteccion'] }}</small></td>
                            <td data-label="Talla" class="text-md-center"><span class="badge-size">{{ $item['talla'] }}</span></td>
                            <td data-label="Total" class="text-md-center"><span class="badge-qty">{{ $item['cantidad_total'] }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="totales-box">
                <div class="total-row">
                    <span class="total-label"><i class="bi bi-box-seam me-2"></i> Productos Diferentes:</span>
                    <span class="fw-bold text-dark">{{ count($consolidado) }}</span>
                </div>
                <div class="total-row">
                    <span class="total-label"><i class="bi bi-plus-circle me-2"></i> Total Unidades Solicitadas:</span>
                    <span class="total-value">{{ array_sum(array_column($consolidado, 'cantidad_total')) }}</span>
                </div>
                <div class="total-row">
                    <span class="total-label"><i class="bi bi-file-earmark-text me-2"></i> Total Pedidos en el Área:</span>
                    <span class="fw-bold text-dark">{{ $pedidosDelArea->count() }}</span>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Acciones -->
    <div class="acciones-footer">
        <button onclick="history.back()" class="btn-sena btn-sena-light">
            <i class="bi bi-arrow-left"></i> Volver
        </button>
        <button onclick="window.print()" class="btn-sena btn-sena-blue">
            <i class="bi bi-printer"></i> Imprimir Comprobante
        </button>
    </div>
</div>

<script>
    function toggleResumen() {
        const body = document.getElementById('resumenBody');
        const text = document.getElementById('toggleText');
        const icon = document.getElementById('iconoResumen');

        body.classList.toggle('mostrar');

        if (body.classList.contains('mostrar')) {
            text.innerText = 'Ocultar Resumen';
            icon.classList.replace('bi-chevron-down', 'bi-chevron-up');
        } else {
            text.innerText = 'Expandir Resumen';
            icon.classList.replace('bi-chevron-up', 'bi-chevron-down');
        }
    }

    window.addEventListener('beforeprint', function() {
        const body = document.getElementById('resumenBody');
        if(body) body.classList.add('mostrar');
    });
</script>
@endsection
