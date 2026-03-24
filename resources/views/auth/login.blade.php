<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Iniciar Sesión - SENA EPP</title>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
    :root {
        --sena-green: #39A900;
        --sena-blue: #406479;
        --sena-dark: #1F3B4D;
        --gold: #FFD700;
        --bg: linear-gradient(135deg, #1F3B4D 0%, #0c0c0c 100%);
        --card-bg: #ffffff;
        --muted: #f8f9fa;
        --shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        font-family: 'Poppins', "Segoe UI", Arial, sans-serif;
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0
    }

    html,
    body {
        height: 100%;
        overflow-x: hidden;
    }

    body {
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--bg);
        padding: 20px;
        -webkit-font-smoothing: antialiased;
    }

    /* Container */
    .container {
        width: 100%;
        max-width: 1000px;
        display: flex;
        border-radius: 24px;
        overflow: hidden;
        background: var(--card-bg);
        box-shadow: var(--shadow);
        min-height: 600px;
        animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Left illustration */
    .illustration-side {
        flex: 1;
        padding: 60px 40px;
        background: linear-gradient(135deg, var(--sena-blue) 0%, var(--sena-green) 100%);
        color: white;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: relative;
        text-align: center;
    }

    .logo-container {
        background: rgba(255, 255, 255, 0.15);
        padding: 30px;
        border-radius: 24px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        margin-bottom: 20px;
        transition: transform 0.3s ease;
    }

    .logo-container:hover {
        transform: scale(1.05);
    }

    .logo-img {
        width: 180px;
        height: auto;
        filter: brightness(0) invert(1);
    }

    .logo-text {
        font-weight: 800;
        font-size: 32px;
        letter-spacing: 1px;
        margin-top: 10px;
    }

    .logo-sub {
        opacity: 0.9;
        font-size: 16px;
        max-width: 250px;
        line-height: 1.4;
    }

    /* Form side */
    .form-side {
        flex: 1;
        padding: 60px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: white;
    }

    .form-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .form-title {
        font-size: 36px;
        color: var(--sena-dark);
        font-weight: 800;
        margin-bottom: 8px;
    }

    .form-sub {
        color: #718096;
        font-size: 16px;
    }

    /* Form */
    .form-group {
        margin-bottom: 24px;
        position: relative;
    }

    .label {
        display: block;
        margin-bottom: 10px;
        font-weight: 700;
        color: #4a5568;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon {
        position: absolute;
        left: 16px;
        color: #a0aec0;
        font-size: 18px;
    }

    .input {
        width: 100%;
        padding: 14px 16px 14px 48px;
        border-radius: 12px;
        border: 2px solid #edf2f7;
        font-size: 16px;
        outline: none;
        transition: all 0.3s ease;
        background: #f8fafc;
    }

    .input:focus {
        border-color: var(--sena-green);
        background: white;
        box-shadow: 0 0 0 4px rgba(57, 169, 0, 0.1);
    }

    /* Password Toggle */
    .password-toggle {
        position: absolute;
        right: 16px;
        cursor: pointer;
        color: #a0aec0;
        font-size: 20px;
        transition: color 0.3s;
        background: none;
        border: none;
        padding: 0;
        display: flex;
        align-items: center;
    }

    .password-toggle:hover {
        color: var(--sena-green);
    }

    .checkbox-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 24px;
        color: #4a5568;
        font-weight: 600;
        font-size: 14px;
    }

    .checkbox-row input {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: var(--sena-green);
    }

    .submit {
        width: 100%;
        padding: 16px;
        border-radius: 12px;
        border: none;
        background: linear-gradient(135deg, var(--sena-blue), var(--sena-green));
        color: white;
        font-weight: 800;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(57, 169, 0, 0.2);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(57, 169, 0, 0.3);
        filter: brightness(1.1);
    }

    .submit:active {
        transform: translateY(0);
    }

    /* Alerts */
    .alert {
        padding: 16px;
        border-radius: 12px;
        margin-bottom: 24px;
        font-size: 14px;
        font-weight: 600;
        border-left: 5px solid;
    }

    .alert-danger {
        background: #fff5f5;
        color: #c53030;
        border-left-color: #fc8181;
    }

    /* Responsive */
    @media(max-width: 900px) {
        .container {
            flex-direction: column;
            max-width: 500px;
            min-height: auto;
        }

        .illustration-side {
            padding: 40px 20px;
        }

        .logo-container {
            padding: 20px;
            margin-bottom: 10px;
        }

        .logo-img {
            width: 120px;
        }

        .logo-text {
            font-size: 24px;
        }

        .form-side {
            padding: 40px 30px;
        }

        .form-title {
            font-size: 28px;
        }
    }

    @media(max-width: 480px) {
        body {
            padding: 10px;
        }

        .container {
            border-radius: 16px;
        }

        .form-side {
            padding: 30px 20px;
        }
    }
    </style>
</head>

<body>
    <main class="container" role="main" aria-label="Iniciar sesión SENA EPP">
        <!-- Illustration -->
        <section class="illustration-side" aria-hidden="true">
            <div class="logo-container">
                <img src="{{ asset('img/logoblanco.png') }}" alt="SENA Logo" class="logo-img" loading="lazy">
            </div>
            <div class="logo-text">SENA EPP</div>
            <div class="logo-sub">Sistema de Gestión de Equipos de Protección Personal</div>
        </section>

        <!-- Form -->
        <section class="form-side" aria-label="Formulario iniciar sesión">
            <div class="form-header">
                <h1 class="form-title">Bienvenido</h1>
                <p class="form-sub">Ingresa tus credenciales para acceder</p>
            </div>

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul style="list-style: none;">
                    @foreach ($errors->all() as $error)
                        <li><i class="bi bi-exclamation-circle-fill me-2"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form class="form" id="loginForm" action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="label" for="email">Correo electrónico</label>
                    <div class="input-wrapper">
                        <i class="bi bi-envelope input-icon"></i>
                        <input id="email" name="email" class="input" type="email" placeholder="ejemplo@sena.edu.co" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label class="label" for="password">Contraseña</label>
                    <div class="input-wrapper">
                        <i class="bi bi-lock input-icon"></i>
                        <input id="password" name="password" class="input" type="password" placeholder="••••••••" required>
                        <button type="button" class="password-toggle" onclick="togglePassword()" aria-label="Mostrar contraseña">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="checkbox-row">
                    <input id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember">Recordarme en este equipo</label>
                </div>

                <button type="submit" class="submit">Acceder al Sistema</button>
            </form>
        </section>
    </main>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }
    </script>
</body>

</html>
