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
    <!-- Google Fonts: Poppins + Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --sena-green: #39A900;
            --sena-blue: #406479;
            --sena-yellow: #FFC107;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            background-attachment: fixed;
            min-height: 100vh;
        }

        /* ============================================
           HEADER SENA - MEJORADO
           ============================================ */
        .sena-header {
            background: linear-gradient(135deg, var(--sena-blue), var(--sena-green));
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
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
            margin-right: 2rem;
        }

        .sena-header .navbar-brand img {
            height: 42px;
            filter: brightness(0) invert(1);
        }

        /* Contenedor de acciones del header */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-left: auto;
        }

        /* ============================================
           NOTIFICACIONES - ESTILO MEJORADO
           ============================================ */
        .notification-bell {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .notification-bell:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: scale(1.1);
            border-color: rgba(255, 255, 255, 0.5);
        }

        .notification-bell i {
            font-size: 1.4rem;
        }

        /* Badge de notificaciones - ESTILO REFERENCIA */
        .notification-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: linear-gradient(135deg, #ff4444, #cc0000);
            color: white;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            font-weight: bold;
            border: 3px solid white;
            box-shadow: 0 2px 8px rgba(255, 68, 68, 0.4);
            animation: pulse 2s infinite;
        }

        /* Animación de pulso para el badge */
        @keyframes pulse {
            0%, 100% {
                box-shadow: 0 2px 8px rgba(255, 68, 68, 0.4);
            }
            50% {
                box-shadow: 0 2px 12px rgba(255, 68, 68, 0.7);
            }
        }

        /* Menú de usuario */
        .user-menu {
            position: relative;
        }

        .user-menu .dropdown-toggle {
            color: white;
            font-weight: 500;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .user-menu .dropdown-toggle:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .user-menu .dropdown-toggle::after {
            display: none;
        }

        .user-menu .dropdown-toggle i {
            font-size: 1.5rem;
        }

        .user-menu .dropdown-menu {
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border: none;
            min-width: 220px;
            margin-top: 0.5rem;
        }

        .user-menu .dropdown-item {
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            color: #333;
            transition: all 0.2s ease;
        }

        .user-menu .dropdown-item:hover {
            background-color: var(--sena-green);
            color: white;
        }

        .user-menu .dropdown-item i {
            width: 20px;
            margin-right: 8px;
        }

        .user-menu .dropdown-divider {
            margin: 0.5rem 0;
        }

        /* ============================================
           CONTENIDO PRINCIPAL
           ============================================ */
        main.container {
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        /* ============================================
           TARJETAS DE DASHBOARD
           ============================================ */
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
            border: 1px solid #e0e0e0;
        }

        .dashboard-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
            border-color: var(--sena-green);
        }

        .dashboard-card .icon {
            font-size: 2.8rem;
            margin-bottom: 1rem;
            color: var(--sena-blue);
        }

        .dashboard-card h5 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .dashboard-card p {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .dashboard-card .btn {
            font-weight: 600;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            background: linear-gradient(135deg, var(--sena-blue), var(--sena-green));
            border: none;
            color: white;
            transition: all 0.3s ease;
        }

        .dashboard-card .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(57, 169, 0, 0.3);
            color: white;
        }

        /* ============================================
           ALERTA DE BIENVENIDA
           ============================================ */
        .welcome-alert {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            border-left: 5px solid var(--sena-green);
            border-radius: 12px;
            padding: 1.2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: none;
            margin-bottom: 2rem;
        }

        .welcome-alert i {
            color: var(--sena-green);
            font-size: 1.3rem;
            margin-right: 0.5rem;
        }

        .welcome-alert strong {
            color: var(--sena-green);
        }

        /* ============================================
           RESPONSIVE
           ============================================ */
        @media (max-width: 768px) {
            .sena-header .navbar-brand {
                font-size: 1.3rem;
                gap: 8px;
            }

            .sena-header .navbar-brand img {
                height: 35px;
            }

            .header-actions {
                gap: 1rem;
            }

            .notification-bell {
                width: 40px;
                height: 40px;
            }

            .notification-bell i {
                font-size: 1.2rem;
            }

            .notification-badge {
                width: 28px;
                height: 28px;
                font-size: 0.75rem;
                top: -6px;
                right: -6px;
            }

            .user-menu .dropdown-toggle {
                padding: 0.5rem;
            }

            .user-menu .dropdown-toggle span {
                display: none;
            }

            main.container {
                padding: 1rem;
            }

            .dashboard-card {
                padding: 1.5rem;
            }

            .dashboard-card .icon {
                font-size: 2.2rem;
            }
        }

        /* ============================================
           ANIMACIONES
           ============================================ */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .sena-header {
            animation: slideDown 0.3s ease;
        }

        /* Animación de aparición del badge */
        @keyframes badgeAppear {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            50% {
                transform: scale(1.2);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .notification-badge {
            animation: badgeAppear 0.4s ease;
        }
    </style>
</head>

<body>

    <!-- HEADER SENA -->
    <header class="sena-header">
        <nav class="navbar navbar-expand">
            <div class="container-fluid px-4">
                <!-- Logo + Título -->
                <a class="navbar-brand" href="{{ route('dashboard.admin') }}">
                    <img src="{{ asset('img/logoblanco.png') }}" alt="SENA" loading="lazy">
                    <span>SENA EPP</span>
                </a>

                <!-- Acciones del Header -->
                <div class="header-actions">
                    <!-- Notificaciones -->
                    <a href="{{ route('notificaciones.index') }}" class="notification-bell" title="Notificaciones">
                        <i class="bi bi-bell-fill"></i>
                        @if (isset($noLeidas) && $noLeidas > 0)
                            <span class="notification-badge">
                                {{ $noLeidas > 99 ? '99+' : $noLeidas }}
                            </span>
                        @endif
                    </a>

                    <!-- Menú de usuario -->
                    <div class="dropdown user-menu">
                        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i>
                            <span class="d-none d-md-inline">{{ auth()->user()->nombre_completo }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-person"></i> Mi Perfil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-gear"></i> Configuración
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
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

    <!-- Script para animaciones y notificaciones optimizado -->
    <script>
        // Función para actualizar notificaciones
        function actualizarNotificaciones() {
            fetch('/admin/notificaciones/count')
                .then(response => response.json())
                .then(data => {
                    const badge = document.querySelector('.notification-badge');
                    if (data.count > 0) {
                        if (!badge) {
                            const bell = document.querySelector('.notification-bell');
                            const newBadge = document.createElement('span');
                            newBadge.className = 'notification-badge';
                            newBadge.textContent = data.count > 99 ? '99+' : data.count;
                            bell.appendChild(newBadge);
                        } else {
                            badge.textContent = data.count > 99 ? '99+' : data.count;
                        }
                    } else if (badge) {
                        badge.remove();
                    }
                })
                .catch(error => console.error('Error al actualizar notificaciones:', error));
        }

        // Animación suave al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            // Agregar animación a las tarjetas
            const cards = document.querySelectorAll('.dashboard-card');
            cards.forEach((card, index) => {
                card.style.animation = `slideDown 0.3s ease ${index * 0.1}s both`;
            });

            // ACTUALIZAR NOTIFICACIONES INMEDIATAMENTE AL CARGAR
            actualizarNotificaciones();

            // Luego actualizar cada 30 segundos
            setInterval(actualizarNotificaciones, 30000);
        });
    </script>
</body>

</html>
