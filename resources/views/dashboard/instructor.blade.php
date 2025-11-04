<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel - SENA EPP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5 text-center">
        <h1>Bienvenido al sistema de gestión de EPP</h1>
        <p class="mt-3">Has iniciado sesión correctamente como <strong>{{ auth()->user()->nombre_completo }}</strong>
        </p>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-danger mt-3">Cerrar sesión</button>
        </form>
    </div>
</body>

</html>