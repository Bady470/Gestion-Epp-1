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
    <!-- Google Fonts: Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
    :root {
        --sena-green: #39A900;
        --sena-green-light: #007200;
        --sena-blue: #406479;
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
        padding: 1.2rem 0;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.18);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .sena-header .navbar-brand {
        font-weight: 700;
        font-size: 1.7rem;
        color: white !important;
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
    }

    .sena-header .navbar-brand img {
        height: 52px; /* Más grande */
        filter: brightness(0) invert(1);
        transition: transform 0.3s ease;
    }

    .sena-header .navbar-brand:hover img {
        transform: scale(1.08);
    }

    .sena-header .nav-link {
        color: rgba(255, 255, 255, 0.95) !important;
        font-weight: 600;
        padding: 0.6rem 1.3rem !important;
        border-radius: 10px;
        transition: all 0.3s ease;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .sena-header .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.25);
        color: white !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .sena-header .nav-link i {
        font-size: 1.1rem;
    }

    /* DROPDOWN DEL USUARIO */
    .user-dropdown .dropdown-toggle {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        font-weight: 500;
        padding: 0.6rem 1.2rem;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s;
        font-size: 0.95rem;
    }

    .user-dropdown .dropdown-toggle:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-1px);
    }

    .user-dropdown .dropdown-toggle::after {
        color: white;
        font-size: 0.8rem;
    }

    .user-dropdown .dropdown-menu {
        border-radius: 14px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.18);
        border: none;
        min-width: 240px;
        padding: 0.8rem 0;
        margin-top: 8px;
    }

    .user-dropdown .dropdown-item {
        padding: 0.7rem 1.3rem;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 12px;
        border-radius: 8px;
        margin: 0 0.5rem;
    }

    .user-dropdown .dropdown-item:hover {
        background-color: #e9f7e6;
        color: var(--sena-green);
    }

    .user-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #fff;
        color: var(--sena-green);
        font-weight: 700;
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .main-content {
        min-height: calc(100vh - 90px);
        padding-top: 2.5rem;
        padding-bottom: 2.5rem;
    }

    .page-title {
        color: var(--sena-green);
        font-weight: 700;
        margin-bottom: 1.8rem;
        border-bottom: 4px solid var(--sena-green);
        padding-bottom: 0.6rem;
        display: inline-block;
        font-size: 1.9rem;
    }

    /* RESPONSIVE */
    @media (max-width: 992px) {
        .sena-header .navbar-brand {
            font-size: 1.4rem;
        }
        .sena-header .navbar-brand img {
            height: 44px;
        }
        .sena-header .nav-link {
            padding: 0.5rem 1rem !important;
            font-size: 0.95rem;
        }
    }
    </style>
</head>

<body>

    <!-- HEADER VERDE SENA -->
    <header class="sena-header">
        <nav class="navbar navbar-expand-lg">
            <div class="container position-relative">
                
                <!-- LOGO A LA IZQUIERDA -->
                <a class="navbar-brand" href="{{ route('dashboard.admin') }}">
                    <img src="{{ asset('img/logoblanco.png') }}" alt="SENA">
                    SENA EPP
                </a>

                <!-- BOTÓN MÓVIL -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- MENÚ CENTRADO + USUARIO A LA DERECHA -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <!-- MENÚ CENTRADO -->
                    <ul class="navbar-nav mx-auto">
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
                    </ul>

                    <!-- USUARIO A LA DERECHA -->
                    <div class="user-dropdown">
                        <div class="dropdown">
                            <a class="dropdown-toggle d-flex align-items-center text-white text-decoration-none" 
                               href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="user-avatar">
                                    {{ strtoupper(substr(Auth::user()->nombre_completo, 0, 2)) }}
                                </div>
                                <div class="d-none d-lg-block text-start ms-2">
                                    <div class="fw-semibold" style="font-size: 0.95rem;">
                                        {{ Auth::user()->nombre_completo }}
                                    </div>
                                    <div class="text-white-50" style="font-size: 0.78rem;">
                                        {{ Auth::user()->rol?->nombre ?? 'Usuario' }}
                                    </div>
                                </div>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="bi bi-person-circle text-primary"></i>
                                        {{ Auth::user()->nombre_completo }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="bi bi-shield-check text-success"></i>
                                        {{ Auth::user()->rol?->nombre ?? 'Sin rol' }}
                                    </a>
                                </li>
                                @if(Auth::user()->area)
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="bi bi-building text-info"></i>
                                        {{ Auth::user()->area->nombre }}
                                    </a>
                                </li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
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