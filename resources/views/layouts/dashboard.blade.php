<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel - SENA EPP')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts: Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
    :root {
        --sena-green: #39A900;
        --sena-blue: #406479;
        --sena-yellow: #FFC107;
    }

    body {
        font-family: 'Roboto', sans-serif;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        background-attachment: fixed;
        min-height: 100vh;
    }

    /* HEADER SENA */
    .sena-header {
        background: linear-gradient(135deg, var(--sena-blue), var(--sena-green));
        color: white;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        padding: 1rem 0;
    }

    .sena-header .navbar-brand {
        font-weight: 700;
        font-size: 1.6rem;
        color: white;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .sena-header .navbar-brand img {
        height: 42px;
        filter: brightness(0) invert(1);
    }

    .user-menu .dropdown-toggle {
        color: white;
        font-weight: 500;
        text-decoration: none;
    }

    .user-menu .dropdown-toggle::after {
        display: none;
    }

    .user-menu .dropdown-menu {
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        border: none;
        min-width: 200px;
    }

    .user-menu .dropdown-item {
        padding: 0.6rem 1rem;
        font-size: 0.95rem;
    }

    .user-menu .dropdown-item:hover {
        background-color: var(--sena-green);
        color: white;
    }

    .user-menu .dropdown-item i {
        width: 20px;
    }

    /* CARD DE ENLACES */
    .dashboard-card {
        background: white;
        border-radius: 16px;
        padding: 1.8rem;
        text-align: center;
        transition: all 0.3s ease;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .dashboard-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
    }

    .dashboard-card .icon {
        font-size: 2.8rem;
        margin-bottom: 1rem;
    }

    .dashboard-card .btn {
        font-weight: 600;
        border-radius: 12px;
        padding: 0.75rem 1rem;
    }

    /* ALERTA BIENVENIDA */
    .welcome-alert {
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        border-left: 5px solid var(--sena-green);
        border-radius: 12px;
        padding: 1.2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }
    </style>
</head>

<body>

    <!-- HEADER SENA -->
    <header class="sena-header">
        <nav class="navbar navbar-expand">
            <div class="container">
                <!-- Logo + Título -->
                <a class="navbar-brand" href="{{ route('dashboard.admin') }}">
                    <img src="img/logoblanco.png" alt="SENA">
                    SENA EPP
                </a>

                <!-- Menú de usuario -->
                <div class="ms-auto">
                    <div class="dropdown user-menu">
                        <a class="dropdown-toggle d-flex align-items-center gap-2" href="#" role="button"
                            data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle fs-4"></i>
                            <span class="d-none d-md-inline">{{ auth()->user()->nombre_completo }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-person me-2"></i> Mi Perfil
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- CONTENIDO -->
    <main class="container py-5">
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>