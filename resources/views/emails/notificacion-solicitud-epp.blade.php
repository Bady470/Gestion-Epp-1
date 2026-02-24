@component('mail::message')
# {{ $notificacion->titulo }}

Hola **{{ $usuario->name }}**,

{{ $notificacion->mensaje }}

## Detalles de la Solicitud

@if($solicitud)
| Campo | Valor |
|-------|-------|
| **Programa** | {{ $solicitud->programa->nombre ?? 'N/A' }} |
| **Ficha** | {{ $solicitud->ficha->codigo ?? 'N/A' }} |
| **Solicitante** | {{ $usuarioAccion->name ?? 'N/A' }} |
| **Cantidad de Elementos** | {{ $solicitud->elementos()->count() }} |
| **Fecha de Solicitud** | {{ $notificacion->created_at->format('d/m/Y H:i') }} |
@endif

## Elementos Solicitados

@if($solicitud && $solicitud->elementos()->count() > 0)
@foreach($solicitud->elementos() as $elemento)
- **{{ $elemento->nombre }}** - Cantidad: {{ $elemento->pivot->cantidad ?? 1 }}
@endforeach
@else
No hay elementos asociados a esta solicitud.
@endif

@component('mail::button', ['url' => route('notificaciones.index')])
Ver en el Sistema
@endcomponent

---

**Por favor, revisa esta solicitud en el sistema para tomar las acciones necesarias.**

Gracias,<br>
{{ config('app.name') }}
@endcomponent
