@extends('layouts.app')

@section('content')
<style>
    /* Estilos base para la tarjeta de notificación */
    .notification-card {
        border-radius: 15px;
        transition: all 0.3s ease;
        border-left: 5px solid #dee2e6;
        background: #fff;
        position: relative;
        overflow: hidden;
    }

    /* ESTADO: NO LEÍDA (Azul) */
    .notification-card.unread {
        border-left-color: #0d6efd;
        background-color: #f8f9ff;
    }

    /* ESTADO: LEÍDA (Verde) */
    .notification-card.read {
        border-left-color: #198754;
        background-color: #f4faf7;
    }

    /* Color del título cuando está leída */
    .notification-card.read .card-title {
        color: #198754;
    }

    .notification-card:hover {
        transform: translateY(-3px);
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
        width: 45px;
        height: 45px;
    }

    .badge-new {
        font-size: 0.7rem;
        padding: 0.4em 0.8em;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-radius: 20px;
    }
</style>

<div class="container py-5">
    <!-- Encabezado -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 gap-3">
        <div>
            <h1 class="fw-bold text-dark mb-1">Centro de Notificaciones</h1>
            <p class="text-muted mb-0">Gestiona las alertas y pedidos recibidos en tiempo real.</p>
        </div>

        @if($noLeidas > 0)
            <button onclick="marcarTodasComoLeidas()" class="btn btn-primary shadow-sm px-4 py-2 rounded-pill">
                <svg class="icon-size me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Marcar todas como leídas
            </button>
        @endif
    </div>

    @if($notificaciones->isEmpty())
        <!-- Estado Vacío -->
        <div class="text-center py-5 border rounded-4 bg-light shadow-sm">
            <svg class="icon-large text-muted mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
            </svg>
            <h4 class="text-secondary fw-bold">No tienes notificaciones</h4>
            <p class="text-muted">Te avisaremos automáticamente cuando haya novedades.</p>
        </div>
    @else
        <div class="row g-4">
            @foreach($notificaciones as $notificacion)
                <div class="col-12">
                    <div id="notif-{{ $notificacion->id }}" class="card notification-card shadow-sm {{ !$notificacion->leida ? 'unread' : 'read' }}">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">

                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <h5 class="card-title fw-bold mb-0">{{ $notificacion->titulo }}</h5>
                                        @if(!$notificacion->leida)
                                            <span class="badge bg-primary badge-new">Nueva</span>
                                        @else
                                            <span class="badge bg-success badge-new">Leída</span>
                                        @endif
                                    </div>

                                    <p class="card-text text-secondary mb-3">{{ $notificacion->mensaje }}</p>

                                    @if($notificacion->datos_adicionales)
                                        <div class="bg-white bg-opacity-50 p-3 rounded-3 border mb-3">
                                            <div class="row row-cols-1 row-cols-sm-2 g-3">
                                                @foreach($notificacion->datos_adicionales as $clave => $valor)
                                                    <div class="col">
                                                        <small class="text-uppercase text-muted fw-bold d-block mb-1" style="font-size: 0.65rem;">{{ str_replace('_', ' ', $clave) }}</small>
                                                        <span class="text-dark fw-medium">{{ $valor }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <hr class="my-3 opacity-25">
                                            <a href="{{ route('admin.pedidos.index') }}" class="btn btn-sm btn-outline-primary fw-bold px-3">
                                                Ver Pedidos y EPP ➔
                                            </a>
                                        </div>
                                    @endif

                                    <div class="d-flex align-items-center gap-3 text-muted small">
                                        <span>
                                            <svg class="icon-size me-1" style="width:14px; height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $notificacion->created_at->diffForHumans() }}
                                        </span>
                                        @if($notificacion->correo_enviado)
                                            <span class="text-success fw-medium d-flex align-items-center">
                                                <svg class="icon-size me-1" style="width:14px; height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                </svg>
                                                Correo enviado
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Botones de Acción -->
                                <div class="d-flex flex-row flex-md-column gap-2 mt-2 mt-md-0">
                                    @if(!$notificacion->leida)
                                        <button onclick="marcarComoLeida({{ $notificacion->id }})" class="btn btn-sm btn-light text-primary fw-bold border px-3">
                                            Marcar leída
                                        </button>
                                    @else
                                        <button onclick="marcarComoNoLeida({{ $notificacion->id }})" class="btn btn-sm btn-light text-muted fw-bold border px-3">
                                            Marcar no leída
                                        </button>
                                    @endif
                                    <button onclick="eliminarNotificacion({{ $notificacion->id }}, event)" class="btn btn-sm btn-light text-danger fw-bold border px-3">
                                        Eliminar
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
function marcarComoLeida(notificacionId) {
    fetch(`/admin/notificaciones/${notificacionId}/marcar-leida`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        },
    }).then(() => location.reload());
}

function marcarComoNoLeida(notificacionId) {
    fetch(`/admin/notificaciones/${notificacionId}/marcar-no-leida`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        },
    }).then(() => location.reload());
}

function marcarTodasComoLeidas() {
    fetch('/admin/notificaciones/marcar-todas-leidas', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        },
    }).then(() => location.reload());
}

function eliminarNotificacion(notificacionId, event) {
    if (confirm('¿Estás seguro de que deseas eliminar esta notificación?')) {
        // Buscamos la tarjeta visualmente para aplicar el efecto de desvanecimiento
        const card = event.target.closest('.notification-card');
        if (card) {
            card.classList.add('fade-out');
        }

        // Esperamos a que la animación termine antes de enviar la petición y recargar
        setTimeout(() => {
            fetch(`/admin/notificaciones/${notificacionId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
            }).then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    alert('Error al eliminar la notificación');
                    if (card) card.classList.remove('fade-out');
                }
            });
        }, 400);
    }
}
</script>
@endsection
