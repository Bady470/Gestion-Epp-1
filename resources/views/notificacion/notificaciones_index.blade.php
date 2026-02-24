@extends('layouts.app')

@section('content')
<style>
    /* Estilos personalizados para asegurar el diseño moderno */
    .notification-card {
        border-radius: 15px;
        transition: all 0.3s ease;
        border-left: 5px solid #dee2e6;
        background: #fff;
    }
    .notification-card.unread {
        border-left-color: #0d6efd;
        background-color: #f8f9ff;
    }
    .notification-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }
    .icon-size {
        width: 20px;
        height: 20px;
    }
    .icon-large {
        width: 40px;
        height: 40px;
    }
    .badge-new {
        font-size: 0.7rem;
        padding: 0.35em 0.65em;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
</style>

<div class="container py-5">
    <!-- Encabezado -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h1 class="fw-bold text-dark mb-1">Centro de Notificaciones</h1>
            <p class="text-muted">Gestiona las alertas y pedidos recibidos.</p>
        </div>

        @if($noLeidas > 0)
            <button onclick="marcarTodasComoLeidas()" class="btn btn-primary shadow-sm px-4 py-2">
                <svg class="icon-size me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Marcar todas como leídas
            </button>
        @endif
    </div>

    @if($notificaciones->isEmpty( ))
        <!-- Estado Vacío -->
        <div class="text-center py-5 border rounded-3 bg-light">
            <svg class="icon-large text-muted mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
            </svg>
            <h4 class="text-secondary">No tienes notificaciones</h4>
            <p class="text-muted">Te avisaremos cuando haya novedades.</p>
        </div>
    @else
        <div class="row g-3">
            @foreach($notificaciones as $notificacion )
                <div class="col-12">
                    <div class="card notification-card shadow-sm {{ !$notificacion->leida ? 'unread' : '' }}">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">

                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <h5 class="card-title fw-bold mb-0">{{ $notificacion->titulo }}</h5>
                                        @if(!$notificacion->leida)
                                            <span class="badge bg-primary badge-new">Nueva</span>
                                        @endif
                                    </div>

                                    <p class="card-text text-secondary mb-3">{{ $notificacion->mensaje }}</p>

                                    @if($notificacion->datos_adicionales)
                                        <div class="bg-light p-3 rounded-3 border mb-3">
                                            <div class="row row-cols-1 row-cols-sm-2 g-2">
                                                @foreach($notificacion->datos_adicionales as $clave => $valor)
                                                    <div class="col">
                                                        <small class="text-uppercase text-muted fw-bold d-block" style="font-size: 0.65rem;">{{ str_replace('_', ' ', $clave) }}</small>
                                                        <span class="text-dark">{{ $valor }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <hr class="my-3">
                                            <a href="{{ route('admin.pedidos.index') }}" class="btn btn-sm btn-outline-primary fw-bold">
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
                                            <span class="text-success fw-medium">
                                                ✓ Correo enviado
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Botones de Acción -->
                                <div class="d-flex flex-row flex-md-column gap-2">
                                    @if(!$notificacion->leida)
                                        <button onclick="marcarComoLeida({{ $notificacion->id }})" class="btn btn-sm btn-light text-primary fw-bold border">
                                            Marcar leída
                                        </button>
                                    @else
                                        <button onclick="marcarComoNoLeida({{ $notificacion->id }})" class="btn btn-sm btn-light text-muted fw-bold border">
                                            Marcar no leída
                                        </button>
                                    @endif
                                    <button onclick="eliminarNotificacion({{ $notificacion->id }})" class="btn btn-sm btn-light text-danger fw-bold border">
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
// Mantengo tus funciones exactamente igual
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

function eliminarNotificacion(notificacionId) {
    if (confirm('¿Estás seguro?')) {
        fetch(`/admin/notificaciones/${notificacionId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            },
        }).then(() => location.reload());
    }
}
</script>
@endsection
