@extends('layouts.dashboard')

@section('content')
<style>
    :root {
        --sena-green: #39A900;
        --sena-blue: #406479;
        --sena-yellow: #FFC107;
    }

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
        margin-bottom: 1rem;
        font-size: 1.8rem;
    }

    .info-pedido {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-top: 1rem;
    }

    .info-item {
        background: rgba(255, 255, 255, 0.1);
        padding: 1rem;
        border-radius: 10px;
        border-left: 4px solid white;
    }

    .info-item label {
        font-size: 0.85rem;
        opacity: 0.9;
        display: block;
        margin-bottom: 0.3rem;
    }

    .info-item strong {
        font-size: 1.1rem;
        display: block;
    }

    .badge-estado {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .badge-pendiente {
        background: linear-gradient(135deg, #FFC107, #FF9800);
        color: white;
    }

    .badge-enviado {
        background: linear-gradient(135deg, #2196F3, #1976D2);
        color: white;
    }

    .badge-aprobado {
        background: linear-gradient(135deg, var(--sena-green), #2d8a00);
        color: white;
    }

    /* Tabla mejorada */
    .tabla-elementos {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
    }

    .tabla-elementos table {
        margin-bottom: 0;
    }

    .tabla-elementos thead {
        background: linear-gradient(135deg, var(--sena-blue), var(--sena-green));
        color: white;
    }

    .tabla-elementos thead th {
        padding: 1rem;
        font-weight: 600;
        border: none;
        font-size: 0.95rem;
    }

    .tabla-elementos tbody td {
        padding: 1rem;
        border-color: #e0e0e0;
        vertical-align: middle;
    }

    .tabla-elementos tbody tr:hover {
        background: #f8f9fa;
    }

    .nombre-producto {
        font-weight: 600;
        color: #333;
        font-size: 0.95rem;
    }

    .cantidad-badge {
        display: inline-block;
        background: linear-gradient(135deg, var(--sena-blue), #2d5a7a);
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .talla-badge {
        display: inline-block;
        background: linear-gradient(135deg, var(--sena-green), #2d8a00);
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        margin-left: 0.5rem;
    }

    .area-badge {
        display: inline-block;
        background: #f0f0f0;
        color: #333;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-size: 0.85rem;
        border-left: 3px solid var(--sena-blue);
    }

    /* 👈 NUEVO: Sección de resumen consolidado */
    .resumen-consolidado {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
        border: 2px solid #e0e0e0;
    }

    .resumen-header {
        background: linear-gradient(135deg, var(--sena-blue), var(--sena-green));
        color: white;
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .resumen-header h5 {
        margin: 0;
        font-weight: 700;
        font-size: 1.2rem;
        font-family: 'Poppins', sans-serif;
    }

    .btn-expandir {
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid white;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-expandir:hover {
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

    /* Tabla consolidada */
    .tabla-consolidada {
        width: 100%;
        border-collapse: collapse;
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

    .producto-consolidado {
        font-weight: 600;
        color: #333;
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

    .totales-consolidado {
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
        font-size: 1rem;
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
        font-size: 1.2rem;
    }

    /* Resumen general */
    .resumen-pedido {
        background: linear-gradient(135deg, #f5f5f5, #e9ecef);
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 2rem;
    }

    .resumen-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #e0e0e0;
    }

    .resumen-item:last-child {
        border-bottom: none;
    }

    .resumen-item label {
        font-weight: 600;
        color: #333;
    }

    .resumen-item .valor {
        font-weight: 700;
        color: var(--sena-green);
        font-size: 1.1rem;
    }

    /* Acciones */
    .acciones-pedido {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }

    .btn-accion {
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-volver {
        background: #f0f0f0;
        color: #333;
    }

    .btn-volver:hover {
        background: #e0e0e0;
    }

    .btn-imprimir {
        background: linear-gradient(135deg, var(--sena-blue), #2d5a7a);
        color: white;
    }

    .btn-imprimir:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(64, 100, 121, 0.3);
    }

    .alerta-vacia {
        background: linear-gradient(135deg, #fff3cd, #ffe69c);
        border-left: 5px solid var(--sena-yellow);
        border-radius: 12px;
        padding: 1.5rem;
        color: #856404;
    }

    @media (max-width: 768px) {
        .header-pedido h2 {
            font-size: 1.3rem;
        }

        .info-pedido {
            grid-template-columns: 1fr;
        }

        .resumen-header {
            flex-direction: column;
            gap: 1rem;
        }

        .acciones-pedido {
            flex-direction: column;
        }

        .btn-accion {
            width: 100%;
            justify-content: center;
        }

        .tabla-consolidada {
            font-size: 0.85rem;
        }

        .tabla-consolidada thead th,
        .tabla-consolidada tbody td {
            padding: 0.5rem;
        }

        .total-row {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    @media print {
        .acciones-pedido {
            display: none;
        }

        .btn-expandir {
            display: none;
        }

        .resumen-body {
            display: block !important;
        }
    }
</style>

<div class="container py-4">
    <!-- Header del pedido -->
    <div class="header-pedido">
        <h2>
            <i class="bi bi-receipt"></i> Detalle del Pedido N° {{ $pedido->id }}
        </h2>

        <div class="info-pedido">
            <div class="info-item">
                <label>Instructor</label>
                <strong>{{ $pedido->usuario->nombre_completo }}</strong>
            </div>

            <div class="info-item">
                <label>Fecha del Pedido</label>
                <strong>{{ $pedido->created_at->format('d/m/Y H:i') }}</strong>
            </div>

            <div class="info-item">
                <label>Estado</label>
                <span class="badge-estado badge-{{ $pedido->estado }}">
                    @if($pedido->estado == 'pendiente')
                        <i class="bi bi-hourglass-split"></i> Pendiente
                    @elseif($pedido->estado == 'enviado')
                        <i class="bi bi-truck"></i> Enviado
                    @elseif($pedido->estado == 'aprobado')
                        <i class="bi bi-check-circle"></i> Aprobado
                    @else
                        <i class="bi bi-x-circle"></i> {{ ucfirst($pedido->estado) }}
                    @endif
                </span>
            </div>

            @if($pedido->ficha)
            <div class="info-item">
                <label>Ficha Asignada</label>
                <strong>{{ $pedido->ficha->numero }} - {{ $pedido->ficha->programa->nombre ?? 'Programa desconocido' }}</strong>
            </div>
            @endif
        </div>
    </div>

    <!-- Elementos del pedido actual -->
    <h4 class="mb-3">
        <i class="bi bi-box-seam"></i> Elementos de Este Pedido
    </h4>

    @if($pedido->elementos->count() > 0)
    <div class="tabla-elementos">
        <table class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Talla</th>
                    <th>Área</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedido->elementos as $item)
                <tr>
                    <td>
                        <div class="nombre-producto">
                            <i class="bi bi-shield-check"></i> {{ $item->nombre }}
                        </div>
                    </td>

                    <td>
                        <span class="cantidad-badge">
                            <i class="bi bi-box"></i> {{ $item->pivot->cantidad }}
                        </span>
                    </td>

                    <td>
                        @if($item->pivot->talla)
                            <span class="talla-badge">
                                <i class="bi bi-rulers"></i> {{ $item->pivot->talla }}
                            </span>
                        @else
                            <span class="talla-badge" style="background: #e0e0e0; color: #666;">
                                <i class="bi bi-question-circle"></i> Sin especificar
                            </span>
                        @endif
                    </td>

                    <td>
                        <span class="area-badge">
                            <i class="bi bi-building"></i> {{ $item->area->nombre ?? '-' }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- 👈 NUEVO: Resumen consolidado de todos los pedidos del área -->
    @if($pedidosDelArea && $pedidosDelArea->count() > 0 && $area)
    <div class="resumen-consolidado">
        <div class="resumen-header">
            <h5>
                <i class="bi bi-receipt-cutoff"></i> Resumen Consolidado del Área: {{ $area->nombre }}
            </h5>
            <button class="btn-expandir" onclick="toggleResumen()">
                <i class="bi bi-chevron-down" id="iconoResumen"></i> Expandir
            </button>
        </div>

        <div class="resumen-body" id="resumenBody">
            <p style="color: #666; margin-bottom: 1rem;">
                <i class="bi bi-info-circle"></i> Consolidación de todos los pedidos del área ({{ $pedidosDelArea->count() }} pedido(s))
            </p>

            @php
                // Consolidar productos por nombre y talla
                $consolidado = [];
                foreach ($pedidosDelArea as $pedidoArea) {
                    foreach ($pedidoArea->elementos as $elemento) {
                        $clave = $elemento->nombre . '|' . ($elemento->pivot->talla ?? 'Sin talla');

                        if (!isset($consolidado[$clave])) {
                            $consolidado[$clave] = [
                                'nombre' => $elemento->nombre,
                                'talla' => $elemento->pivot->talla ?? 'Sin talla especificada',
                                'cantidad_total' => 0,
                                'proteccion' => $elemento->filtro->parte_del_cuerpo ?? '-',
                            ];
                        }

                        $consolidado[$clave]['cantidad_total'] += $elemento->pivot->cantidad;
                    }
                }

                // Ordenar por nombre
                uasort($consolidado, function($a, $b) {
                    return strcmp($a['nombre'], $b['nombre']);
                });
            @endphp

            <table class="tabla-consolidada">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Protección</th>
                        <th>Talla</th>
                        <th class="text-center">Cantidad Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($consolidado as $item)
                    <tr>
                        <td>
                            <div class="producto-consolidado">
                                {{ $item['nombre'] }}
                            </div>
                        </td>
                        <td>
                            <small style="color: #666;">{{ $item['proteccion'] }}</small>
                        </td>
                        <td>
                            <span class="talla-consolidada">
                                {{ $item['talla'] }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="cantidad-consolidada">
                                {{ $item['cantidad_total'] }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Totales consolidados -->
            <div class="totales-consolidado">
                <div class="total-row">
                    <span class="total-label">
                        <i class="bi bi-box-seam"></i> Total de productos diferentes:
                    </span>
                    <span class="total-valor">{{ count($consolidado) }}</span>
                </div>

                <div class="total-row">
                    <span class="total-label">
                        <i class="bi bi-sum"></i> Total de unidades solicitadas:
                    </span>
                    <span class="total-valor">{{ array_sum(array_column($consolidado, 'cantidad_total')) }}</span>
                </div>

                <div class="total-row">
                    <span class="total-label">
                        <i class="bi bi-file-earmark"></i> Total de pedidos en el área:
                    </span>
                    <span class="total-valor">{{ $pedidosDelArea->count() }}</span>
                </div>
            </div>
        </div>
    </div>
    @endif

    @else
    <div class="alerta-vacia">
        <i class="bi bi-inbox"></i>
        <strong>Este pedido no contiene elementos.</strong>
    </div>
    @endif

    <!-- Acciones -->
    <div class="acciones-pedido">
        <button class="btn-accion btn-volver" onclick="history.back()">
            <i class="bi bi-arrow-left"></i> Volver
        </button>
        <button class="btn-accion btn-imprimir" onclick="window.print()">
            <i class="bi bi-printer"></i> Imprimir
        </button>
    </div>
</div>

<script>
    function toggleResumen() {
        const resumenBody = document.getElementById('resumenBody');
        const icono = document.getElementById('iconoResumen');

        resumenBody.classList.toggle('mostrar');

        if (resumenBody.classList.contains('mostrar')) {
            icono.classList.remove('bi-chevron-down');
            icono.classList.add('bi-chevron-up');
        } else {
            icono.classList.remove('bi-chevron-up');
            icono.classList.add('bi-chevron-down');
        }
    }

    window.addEventListener('beforeprint', function() {
        document.body.style.backgroundColor = 'white';
        document.getElementById('resumenBody').classList.add('mostrar');
    });
</script>
@endsection
