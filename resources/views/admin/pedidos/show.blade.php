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

    .badge-rechazado {
        background: linear-gradient(135deg, #F44336, #D32F2F);
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

    .tabla-elementos tbody tr {
        transition: all 0.2s ease;
    }

    .tabla-elementos tbody tr:hover {
        background: #f8f9fa;
    }

    .tabla-elementos tbody tr:last-child td {
        border-bottom: none;
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

    .sin-talla {
        background: #e0e0e0;
        color: #666;
    }

    /* Sección de acciones */
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

    /* Alerta sin elementos */
    .alerta-vacia {
        background: linear-gradient(135deg, #fff3cd, #ffe69c);
        border-left: 5px solid var(--sena-yellow);
        border-radius: 12px;
        padding: 1.5rem;
        color: #856404;
    }

    .alerta-vacia i {
        font-size: 1.5rem;
        margin-right: 0.5rem;
    }

    /* Resumen del pedido */
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

    /* Responsive */
    @media (max-width: 768px) {
        .header-pedido h2 {
            font-size: 1.3rem;
        }

        .info-pedido {
            grid-template-columns: 1fr;
        }

        .tabla-elementos {
            overflow-x: auto;
        }

        .acciones-pedido {
            flex-direction: column;
        }

        .btn-accion {
            width: 100%;
            justify-content: center;
        }
    }
</style>

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
    </div>
</div>

<!-- Elementos del pedido -->
<div class="container">
    <h4 class="mb-3">
        <i class="bi bi-box-seam"></i> Elementos Solicitados
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
                    <!-- Nombre del producto -->
                    <td>
                        <div class="nombre-producto">
                            <i class="bi bi-shield-check"></i> {{ $item->nombre }}
                        </div>
                    </td>

                    <!-- Cantidad -->
                    <td>
                        <span class="cantidad-badge">
                            <i class="bi bi-box"></i> {{ $item->pivot->cantidad }}
                        </span>
                    </td>

                    <!-- Talla -->
                    <td>
                        @if($item->pivot->talla)
                            <span class="talla-badge">
                                <i class="bi bi-rulers"></i> {{ $item->pivot->talla }}
                            </span>
                        @else
                            <span class="talla-badge sin-talla">
                                <i class="bi bi-question-circle"></i> Sin especificar
                            </span>
                        @endif
                    </td>

                    <!-- Área -->
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

    <!-- Resumen del pedido -->
    <div class="resumen-pedido">
        <h5 class="mb-3">
            <i class="bi bi-calculator"></i> Resumen del Pedido
        </h5>

        <div class="resumen-item">
            <label>Total de productos:</label>
            <span class="valor">{{ $pedido->elementos->count() }}</span>
        </div>

        <div class="resumen-item">
            <label>Total de unidades:</label>
            <span class="valor">{{ $pedido->elementos->sum('pivot.cantidad') }}</span>
        </div>

        <div class="resumen-item">
            <label>Variedad de tallas:</label>
            <span class="valor">
                {{ $pedido->elementos->pluck('pivot.talla')->unique()->filter()->count() }} talla(s)
            </span>
        </div>
    </div>

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
    // Optimizar impresión
    window.addEventListener('beforeprint', function() {
        document.body.style.backgroundColor = 'white';
    });
</script>
@endsection
