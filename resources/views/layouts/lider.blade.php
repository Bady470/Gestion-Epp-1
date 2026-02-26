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

        /* 👈 CORREGIDO: HEADER SENA CON Z-INDEX CORRECTO */
        .sena-header {
            background: linear-gradient(135deg, var(--sena-blue), var(--sena-green));
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
            position: relative;
            z-index: 100;
        }

        .sena-header .navbar {
            padding: 0;
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

        /* 👈 NUEVO: Dropdown menu con z-index alto */
        .user-menu {
            position: relative;
            z-index: 1050;
        }

        .user-menu .dropdown-toggle {
            color: white;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .user-menu .dropdown-toggle::after {
            display: none;
        }

        .user-menu .dropdown-toggle:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .user-menu .dropdown-menu {
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border: none;
            min-width: 200px;
            z-index: 1050;
            margin-top: 0.5rem;
        }

        .user-menu .dropdown-item {
            padding: 0.6rem 1rem;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .user-menu .dropdown-item:hover {
            background-color: var(--sena-green);
            color: white;
        }

        .user-menu .dropdown-item i {
            width: 20px;
        }

        /* 👈 NUEVO: Botón logout sin formulario */
        .logout-btn {
            background: none;
            border: none;
            padding: 0.6rem 1rem;
            font-size: 0.95rem;
            color: #dc3545;
            cursor: pointer;
            width: 100%;
            text-align: left;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logout-btn:hover {
            background-color: var(--sena-green);
            color: white;
        }

        .logout-btn i {
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

        /* 👈 NUEVO: Asegurar que los modales estén por encima */
        .modal {
            z-index: 1060 !important;
        }

        .modal-backdrop {
            z-index: 1050 !important;
        }
        /* ===== FIX ICONO USUARIO ===== */

.sena-header .nav-link {
    color: white !important;
}

.sena-header .nav-link:hover {
    color: white !important;
}

.sena-header .nav-link i {
    color: white !important;
}

        @media (max-width: 768px) {
            .sena-header .navbar-brand {
                font-size: 1.2rem;
            }

            .user-menu .dropdown-menu {
                min-width: 180px;
            }
        }
    </style>
</head>

<body>

    <!-- HEADER SENA -->
    <header class="sena-header">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <!-- Logo + Título -->
                <a class="navbar-brand" href="{{ route('dashboard.lider') }}">
                    <img src="{{ asset('img/logoblanco.png') }}" alt="SENA">
                    SENA EPP
                </a>

                <!-- Menú de usuario -->
                <!-- Menú de usuario -->
<div class="ms-auto">
    <ul class="navbar-nav">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2"
               href="#"
               id="userMenuDropdown"
               role="button"
               data-bs-toggle="dropdown"
               aria-expanded="false">

                <i class="bi bi-person-circle fs-4"></i>
                <span>{{ auth()->user()->nombre_completo }}</span>
            </a>

            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item">
                        <i class="bi bi-person"></i>
                        Mi Perfil
                    </a>
                </li>

                <li><hr class="dropdown-divider"></li>

                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right"></i>
                            Cerrar sesión
                        </button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</div>
            </div>
        </nav>
    </header>

    <!-- CONTENIDO -->
    <main class="container py-5">
        @yield('content')
    </main>

    <!-- 👈 NUEVO: Formulario oculto para logout -->
    <form id="logoutForm" method="POST" action="{{ route('logout') }}" style="display: none;">
        @csrf
    </form>

    <!-- Bootstrap JS -->

    <!-- 👈 NUEVO: Script para manejar logout -->
    <script>
        function logout() {
            // Obtener el formulario oculto
            const form = document.getElementById('logoutForm');
            // Enviar el formulario
            form.submit();
        }
        document.addEventListener("DOMContentLoaded", function() {
            var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));

            dropdownElementList.map(function(dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl);
            });
        });
    </script>

</body>

</html>
