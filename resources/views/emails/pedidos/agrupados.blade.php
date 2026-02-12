<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pedidos del Área {{ $area }}</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        h2, h3 { color: #2c3e50; }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #aaa;
            padding: 8px;
            text-align: left;
        }

        th { background-color: #f2f2f2; }

        .instructor-box {
            background: #eef3ff;
            border-left: 4px solid #3f51b5;
            padding: 8px;
            margin-top: 25px;
        }
    </style>
</head>

<body>

    <h2>📦 Pedidos del Área: {{ $area }}</h2>
    <p>A continuación se muestran los pedidos enviados por los instructores:</p>

    @php
        // Agrupar pedidos por instructor
        $agrupados = $pedidos->groupBy('users_id');
    @endphp

    @foreach ($agrupados as $usuarioId => $pedidosInstructor)

        @php
            $instructor = $pedidosInstructor->first()->usuario;
        @endphp

        <div class="instructor-box">
            <h3>👨‍🏫 Instructor: {{ $instructor->nombre_completo ?? 'Sin nombre' }}</h3>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Elemento</th>
                    <th>Talla</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($pedidosInstructor as $pedido)
                    @foreach ($pedido->elementos as $elemento)
                    <tr>
                        <td>{{ $elemento->nombre }}</td>
                        <td>{{ $elemento->talla ?? '-' }}</td>
                        <td>{{ $elemento->pivot->cantidad }}</td>
                        <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>

    @endforeach

</body>
</html>
