<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Pedidos del área {{ $area }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        .container {
            background-color: white;
            border-radius: 8px;
            padding: 30px;
            max-width: 900px;
            margin: 0 auto;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #406479, #39A900);
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: center;
        }

        .header h2 {
            margin: 0;
            font-size: 1.8rem;
        }

        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
        }

        .area-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            margin-top: 10px;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .pedido-section {
            margin-bottom: 30px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
        }

        .pedido-header {
            background: #f8f9fa;
            padding: 15px;
            border-bottom: 2px solid #e0e0e0;
        }

        .pedido-header h3 {
            margin: 0 0 10px 0;
            color: #406479;
            font-size: 1.1rem;
        }

        .pedido-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            font-size: 0.9rem;
        }

        .info-item {
            display: flex;
            align-items: center;
        }

        .info-label {
            font-weight: 600;
            color: #333;
            min-width: 100px;
        }

        .info-value {
            color: #666;
        }

        /* 👈 NUEVO: Estilos para ficha */
        .ficha-box {
            background: linear-gradient(135deg, #39A900, #2d8a00);
            color: white;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .ficha-box h4 {
            margin: 0 0 8px 0;
            font-size: 0.95rem;
        }

        .ficha-numero {
            font-size: 1.3rem;
            font-weight: 700;
        }

        .ficha-programa {
            font-size: 0.85rem;
            opacity: 0.95;
        }

        .pedido-body {
            padding: 15px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #406479;
            color: white;
            font-weight: 600;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #f0f0f0;
        }

        .talla-badge {
            display: inline-block;
            background: #406479;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .cantidad-badge {
            display: inline-block;
            background: #39A900;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .footer {
            background: #f8f9fa;
            padding: 20px;
            border-top: 2px solid #e0e0e0;
            margin-top: 30px;
            border-radius: 8px;
            text-align: center;
            font-size: 0.9rem;
            color: #666;
        }

        .boton {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(135deg, #406479, #2d5a7a);
            color: white !important;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
            font-weight: 600;
        }

        .resumen {
            background: #e3f2fd;
            border-left: 4px solid #406479;
            padding: 15px;
            margin-top: 20px;
            border-radius: 4px;
        }

        .resumen strong {
            color: #406479;
        }

        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }

            .pedido-info {
                grid-template-columns: 1fr;
            }

            table {
                font-size: 0.85rem;
            }

            th,
            td {
                padding: 8px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h2>📦 Solicitudes de Equipos de Protección Personal</h2>
            <p>Se han recibido nuevas solicitudes del área</p>
            <div class="area-badge">
                <strong>{{ $area }}</strong>
            </div>
        </div>

        <!-- Contenido -->
        <p>Se han enviado los siguientes pedidos para revisión:</p>

        <!-- Pedidos -->
        @forelse($pedidos as $pedido)
        <div class="pedido-section">
            <!-- Header del pedido -->
            <div class="pedido-header">
                <h3>👤 Instructor: {{ $pedido->usuario->nombre_completo ?? 'Desconocido' }}</h3>
                <div class="pedido-info">
                    <div class="info-item">
                        <span class="info-label">Área:</span>
                        <span class="info-value">{{ $pedido->usuario->area->nombre ?? 'No asignada' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Fecha:</span>
                        <span class="info-value">{{ $pedido->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">ID Pedido:</span>
                        <span class="info-value">#{{ $pedido->id }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Estado:</span>
                        <span class="info-value">{{ ucfirst($pedido->estado) }}</span>
                    </div>
                </div>
            </div>

            <!-- Cuerpo del pedido -->
            <div class="pedido-body">
                <!-- 👈 NUEVO: Información de la ficha -->
                @if($pedido->ficha)
                <div class="ficha-box">
                    <h4>📋 Ficha Asignada</h4>
                    <div class="ficha-numero">{{ $pedido->ficha->numero }}</div>
                    <div class="ficha-programa">
                        📚 {{ $pedido->ficha->programa->nombre ?? 'Programa desconocido' }}
                    </div>
                </div>
                @else
                <div style="background: #fff3cd; color: #856404; padding: 12px; border-radius: 6px; margin-bottom: 15px; border-left: 4px solid #ffc107;">
                    <strong>⚠️ Sin ficha asignada</strong>
                </div>
                @endif

                <!-- Tabla de elementos -->
                <h4 style="margin-top: 15px; margin-bottom: 10px; color: #333;">📦 Elementos Solicitados</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Elemento</th>
                            <th>Talla</th>
                            <th>Cantidad</th>
                            <th>Área</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pedido->elementos as $elemento)
                        <tr>
                            <td>
                                <strong>{{ $elemento->nombre }}</strong>
                                @if($elemento->filtro)
                                <br><small style="color: #666;">🛡️ {{ $elemento->filtro->parte_del_cuerpo ?? '-' }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="talla-badge">
                                    {{ $elemento->pivot->talla ?? 'Sin talla' }}
                                </span>
                            </td>
                            <td>
                                <span class="cantidad-badge">
                                    {{ $elemento->pivot->cantidad ?? 1 }}
                                </span>
                            </td>
                            <td>
                                @if($elemento->area)
                                {{ $elemento->area->nombre }}
                                @else
                                <span style="color: #999;">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: #999;">
                                No hay elementos en este pedido
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @empty
        <div style="background: #e3f2fd; border-left: 4px solid #0d6efd; padding: 15px; border-radius: 6px;">
            <strong>ℹ️ No hay pedidos para mostrar</strong>
        </div>
        @endforelse

        <!-- Resumen -->
        @if(count($pedidos) > 0)
        <div class="resumen">
            <strong>📊 Resumen:</strong> Se han recibido <strong>{{ count($pedidos) }}</strong> pedido(s) del área
            <strong>{{ $area }}</strong>
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>Este es un correo automático. Por favor, no responda a este mensaje.</p>
            <p>Para revisar los pedidos, ingrese al sistema administrativo.</p>
            <a href="{{ url('/admin/pedidos') }}" class="boton">Ver Pedidos en el Sistema</a>
        </div>
    </div>
</body>

</html>
