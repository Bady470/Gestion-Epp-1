@component('mail::message')
# Nuevo Pedido Enviado

**ID:** #{{ $pedido->id }}
**Usuario:** {{ $pedido->usuario->name ?? 'Anónimo' }}
**Email:** {{ $pedido->usuario->email ?? 'N/A' }}
**Fecha:** {{ $pedido->created_at->format('d/m/Y H:i') }}

@component('mail::table')
| Elemento | Cantidad | Área |
|----------|----------|------|
@forelse ($pedido->elementos as $elemento)
| {{ $elemento->pivot->nombre ?? $elemento->nombre }} | {{ $elemento->pivot->cantidad }} |
{{ $elemento->area->nombre ?? 'Sin área' }} |
@empty
| *No hay elementos en este pedido* | 0 | — |
@endforelse
@endcomponent

@component('mail::button', ['url' => url('/admin/pedidos/' . $pedido->id)])
Ver Pedido
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent