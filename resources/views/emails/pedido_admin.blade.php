<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Pedidos del área {{ $area }}</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        color: #333;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 15px;
    }

    th,
    td {
        border: 1px solid #aaa;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    h2,
    h3 {
        color: #2c3e50;
    }

    .boton {
        display: inline-block;
        padding: 10px 20px;
        background: #007bff;
        color: white !important;
        text-decoration: none;
        border-radius: 6px;
        margin-top: 20px;
    }
    </style>
</head>

<body>
    <h2>📦 Pedidos del área: {{ $area }}</h2>
    <p>Se han enviado los siguientes pedidos al administrador para revisión:</p>

    <table>
        <thead>
            <tr>
                <th>Instructor</th>
                <th>Elemento</th>
                <th>Talla</th>
                <th>Cantidad Solicitada</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pedidos as $pedido)
            @foreach ($pedido->elementos as $elemento)
            <tr>
                <td>{{ $pedido->usuario->nombre_completo ?? 'Desconocido' }}</td>
                <td>{{ $elemento->nombre }}</td>
                <td>{{ $elemento->talla ?? '-' }}</td>
                <td>{{ $elemento->cantidad }}</td>
                <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
            @endforeach
        </tbody>
    </table>

    <a href="{{ url('/admin/pedidos') }}" class="boton">Ver pedidos en el sistema</a>
</body>

</html>