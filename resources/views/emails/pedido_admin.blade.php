<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.5;">

    <p>Hola,</p>

    <p>
        Se ha generado un nuevo consolidado de pedidos del área
        <strong>{{ $area }}</strong>.
    </p>

    <p>
        <strong>Total de pedidos:</strong> {{ count($pedidos) }}
    </p>

    <p>
        <strong>Instructores involucrados:</strong><br>
        {{ implode(', ', $instructores->toArray()) }}
    </p>

    <hr style="margin: 20px 0;">

    <p>
        Para ver el detalle completo, ingrese al sistema:
    </p>

    <p>
        <a href="{{ url('/login?redirect=/admin/notificaciones') }}">
    Ver notificaciones
</a>
    </p>

    <p style="margin-top: 30px; font-size: 12px; color: #777;">
        Este es un mensaje automático. No responder.
    </p>

</body>
</html>
