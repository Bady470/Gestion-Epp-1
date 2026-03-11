@extends('layouts.app')

@section('content')
<style>
    :root {
        --sena-green: #39A900;
        --sena-blue: #406479;
        --sena-light: #f8f9fa;
    }

    /* Estilos base para la tarjeta de notificación */
    .notification-card {
        border-radius: 16px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid #edf2f7;
        border-left: 6px solid #dee2e6;
        background: #fff;
        position: relative;
        overflow: hidden;
        margin-bottom: 1rem;
    }

    /* ESTADO: NO LEÍDA (Azul) */
    .notification-card.unread {
        border-left-color: #0d6efd;
        background-color: #f8faff;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.05);
    }

    /* ESTADO: LEÍDA (Verde) */
    .notification-card.read {
        border-left-color: var(--sena-green);
        background-color: #fcfdfc;
        opacity: 0.9;
    }

    /* Color del título cuando está leída */
    .notification-card.read .card-title {
        color: #4a5568;
    }

    .notification-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.08);
    }

    /* Animación para eliminación (Fade Out) */
    .notification-card.fade-out {
        opacity: 0;
        transform: scale(0.95);
        transition: all 0.4s ease;
    }

    .icon-size {
        width: 20px;
        height: 20px;
    }

    .icon-large {
        width: 60px;
        height: 60px;
        opacity: 0.3;
    }

    .badge-new {
        font-size: 0.65rem;
        padding: 0.5em 1em;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-radius: 50px;
        font-weight: 800;
    }

    /* Datos adicionales */
    .data-box {
        background: white;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 1.25rem;
        margin: 1rem 0;
    }

    .data-label {
        font-size: 0.65rem;
        text-transform: uppercase;
        font-weight: 800;
        color: #718096;
        letter-spacing: 0.5px;
        display: block;
        margin-bottom: 0.25rem;
    }

    .data-value {
        font-weight: 600;
        color: #2d3748;
        font-size: 0.95rem;
    }

    /* Botones de Acción */
    .btn-action-group {
        display: flex;
        gap: 0.5rem;
    }

    .btn-notif {
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.8rem;
        transition: all 0.2s;
        border: 1px solid #e2e8f0;
        background: white;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .btn-notif:hover {
        background: #f7fafc;
        transform: translateY(-1px);
    }

    .btn-notif-primary { color: #0d6efd; }
    .btn-notif-danger { color: #e53e3e; }
    .btn-notif-muted { color: #718096; }

    /* Header Section */
    .header-notif {
        background: linear-gradient(135deg, var(--sena-blue), var(--sena-green));
        color: white;
        padding: 2.5rem 2rem;
        border-radius: 20px;
        margin-bottom: 3rem;
        box-shadow: 0 10px 25px rgba(57, 169, 0, 0.15);
    }

    /* Responsive */
    @media (max-width: 767.98px) {
        .header-notif {
            padding: 2rem 1.5rem;
            text-align: center;
        }

        .header-notif .d-flex {
            flex-direction: column;
            gap: 1.5rem;
        }

        .btn-action-group {
            width: 100%;
            flex-direction: column;
        }

        .btn-notif {
            width: 100%;
            justify-content: center;
            padding: 0.75rem;
        }

        .notification-card .d-flex {
            flex-direction: column;
        }

        .notification-card .card-body {
            padding: 1.5rem;
        }

        .badge-new {
            margin-top: 0.5rem;
            display: inline-block;
        }
    }
</style>

<div class="container py-4">
    <!-- Encabezado -->
    <div class="header-notif">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="fw-bold mb-1"><i class="bi bi-bell-fill me-2"></i> Centro de Notificaciones</h1>
                <p class="mb-0 opacity-90">Gestiona las alertas y pedidos recibidos en tiempo real.</p>
            </div>

            @if($noLeidas > 0)
                <button onclick="marcarTodasComoLeidas()" class="btn btn-light shadow-sm px-4 py-2 rounded-pill fw-bold text-primary">
                    <i class="bi bi-check-all me-2"></i> Marcar todas como leídas
                </button>
            @endif
        </div>
    </div>

    @if($notificaciones->isEmpty())
        <!-- Estado Vacío -->
        <div class="text-center py-5 border-0 rounded-4 bg-white shadow-sm">
            <i class="bi bi-mailbox2 icon-large text-muted mb-4 d-block"></i>
            <h4 class="text-dark fw-bold">No tienes notificaciones</h4>
            <p class="text-muted">Te avisaremos automáticamente cuando haya novedades en el sistema.</p>
        </div>
    @else
        <div class="row g-3">
            @foreach($notificaciones as $notificacion)
                <div class="col-12">
                    <div id="notif-{{ $notificacion->id }}" class="card notification-card shadow-sm {{ !$notificacion->leida ? 'unread' : 'read' }}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start gap-3">

                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
                                        <h5 class="card-title fw-bold mb-0 text-dark">{{ $notificacion->titulo }}</h5>
                                        @if(!$notificacion->leida)
                                            <span class="badge bg-primary badge-new">Nueva</span>
                                        @else
                                            <span class="badge bg-success badge-new">Leída</span>
                                        @endif
                                    </div>

                                    <p class="card-text text-secondary mb-3" style="font-size: 1.05rem;">{{ $notificacion->mensaje }}</p>

                                    @if($notificacion->datos_adicionales)
                                        <div class="data-box shadow-sm">
                                            <div class="row row-cols-1 row-cols-sm-2 g-3">
                                                @foreach($notificacion->datos_adicionales as $clave => $valor)
                                                    <div class="col">
                                                        <label class="data-label">{{ str_replace('_', ' ', $clave) }}</label>
                                                        <span class="data-value">{{ $valor }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <hr class="my-3 opacity-10">
                                            <a href="{{ route('admin.pedidos.index') }}" class="btn btn-sm btn-primary rounded-pill px-4 fw-bold">
                                                Ver Pedidos y EPP <i class="bi bi-arrow-right ms-1"></i>
                                            </a>
                                        </div>
                                    @endif

                                    <div class="d-flex align-items-center flex-wrap gap-3 text-muted small mt-3">
                                        <span class="d-flex align-items-center">
                                            <i class="bi bi-clock me-1"></i>
                                            {{ $notificacion->created_at->diffForHumans() }}
                                        </span>
                                        @if($notificacion->correo_enviado)
                                            <span class="text-success fw-bold d-flex align-items-center">
                                                <i class="bi bi-envelope-check-fill me-1"></i>
                                                Correo enviado
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Botones de Acción -->
                                <div class="btn-action-group mt-3 mt-md-0">
                                    @if(!$notificacion->leida)
                                        <button type="button" data-id="{{ $notificacion->id }}" onclick="marcarComoLeida(this)" class="btn-notif btn-notif-primary">
                                            <i class="bi bi-eye-fill"></i> Marcar leída
                                        </button>
                                    @else
                                        <button type="button" data-id="{{ $notificacion->id }}" onclick="marcarComoNoLeida(this)" class="btn-notif btn-notif-muted">
                                            <i class="bi bi-eye-slash"></i> Marcar no leída
                                        </button>
                                    @endif
                                    <button type="button" data-id="{{ $notificacion->id }}" onclick="eliminarNotificacion(this)" class="btn-notif btn-notif-danger">
                                        <i class="bi bi-trash3-fill"></i> Eliminar
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script>
    // Función para obtener el token CSRF
    function getCsrfToken() {
        const tokenElement = document.querySelector('meta[name="csrf-token"]');
        if (tokenElement) {
            return tokenElement.content;
        }
        console.error('CSRF token not found: Make sure you have <meta name="csrf-token" content="{{ csrf_token() }}"> in your head section.');
        return null;
    }

    // Función genérica para enviar solicitudes fetch
    async function sendNotificationRequest(url, method = 'POST', notificacionId = null) {
        const csrfToken = getCsrfToken();
        if (!csrfToken) {
            alert('Error de seguridad: CSRF token no encontrado.');
            return;
        }

        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || `Error en la solicitud: ${response.statusText}`);
            }

            // Si la respuesta es OK, recargar la página o actualizar la UI
            location.reload();

        } catch (error) {
            console.error('Error en la operación:', error);
            alert('Ocurrió un error: ' + error.message);
            // Si es una eliminación y falla, remover la clase fade-out si existe
            if (method === 'DELETE' && notificacionId) {
                const card = document.getElementById(`notif-${notificacionId}`);
                if (card) card.classList.remove('fade-out');
            }
        }
    }

    function marcarComoLeida(buttonElement) {
        const notificacionId = buttonElement.dataset.id;
        sendNotificationRequest(`/admin/notificaciones/${notificacionId}/marcar-leida`, 'POST');
    }

    function marcarComoNoLeida(buttonElement) {
        const notificacionId = buttonElement.dataset.id;
        sendNotificationRequest(`/admin/notificaciones/${notificacionId}/marcar-no-leida`, 'POST');
    }

    function marcarTodasComoLeidas() {
        sendNotificationRequest('/admin/notificaciones/marcar-todas-leidas', 'POST');
    }

    async function eliminarNotificacion(buttonElement) {
        const notificacionId = buttonElement.dataset.id;
        if (confirm('¿Estás seguro de que deseas eliminar esta notificación?')) {
            const card = document.getElementById(`notif-${notificacionId}`);
            if (card) {
                card.classList.add('fade-out');
            }

            // Esperar la animación antes de enviar la solicitud
            await new Promise(resolve => setTimeout(resolve, 400));

            sendNotificationRequest(`/admin/notificaciones/${notificacionId}`, 'DELETE', notificacionId);
        }
    }
</script>
@endsection
