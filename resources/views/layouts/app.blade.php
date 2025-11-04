<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema EPP - SENA')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts: Roboto (oficial SENA) -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
    :root {
        --sena-green: #39A900;
        --sena-green-light: #007200;
        --sena-yellow: #214083ff;
    }

    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f5f5f5;
        margin: 0;
        padding: 0;
    }

    /* HEADER VERDE SENA */
    .sena-header {
        background: linear-gradient(135deg, var(--sena-green), var(--sena-green-light));
        color: white;
        padding: 1rem 0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .sena-header .navbar-brand {
        font-weight: 700;
        font-size: 1.5rem;
        color: white !important;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .sena-header .navbar-brand img {
        height: 40px;
        filter: brightness(0) invert(1);
    }

    .sena-header .nav-link {
        color: rgba(255, 255, 255, 0.9) !important;
        font-weight: 500;
        padding: 0.5rem 1rem !important;
        border-radius: 6px;
        transition: all 0.3s;
    }

    .sena-header .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.2);
        color: white !important;
    }

    .sena-header .btn-logout {
        background-color: var(--sena-yellow);
        color: #000;
        font-weight: 600;
        border: none;
        padding: 0.5rem 1.2rem;
        border-radius: 6px;
        transition: all 0.3s;
    }

    .sena-header .btn-logout:hover {
        background-color: #586786ff;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Contenido principal */
    .main-content {
        min-height: calc(100vh - 80px);
        padding-top: 2rem;
        padding-bottom: 2rem;
    }

    .page-title {
        color: var(--sena-green);
        font-weight: 700;
        margin-bottom: 1.5rem;
        border-bottom: 3px solid var(--sena-green);
        padding-bottom: 0.5rem;
        display: inline-block;
    }
    </style>
</head>

<body>

    <!-- HEADER VERDE SENA -->
    <header class="sena-header">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <!-- Logo + Nombre -->
                <a class="navbar-brand" href="{{ route('dashboard.admin') }}">
                    <img src="img/logoblanco.png" alt="SENA">
                    SENA EPP
                </a>

                <!-- Botón móvil -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Menú -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item">
                            <a href="{{ route('usuarios.index') }}" class="nav-link">
                                <i class="bi bi-people"></i> Usuarios
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('fichas.index') }}" class="nav-link">
                                <i class="bi bi-card-list"></i> Fichas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('programas.index') }}" class="nav-link">
                                <i class="bi bi-book"></i> Programas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('elementos_pp.index') }}" class="nav-link">
                                <i class="bi bi-shield-check"></i> EPP
                            </a>
                        </li>
                        <li class="nav-item ms-3">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-logout">
                                    <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="main-content">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>