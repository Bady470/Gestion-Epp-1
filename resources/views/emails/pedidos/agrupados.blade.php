@component('mail::message')
# 📦 Pedidos Agrupados de EPP

El líder ha enviado todos los pedidos pendientes de los instructores.

---

@foreach($pedidos as $pedido)
### 🧾 Pedido #{{ $pedido->id }}
**Instructor:** {{ $pedido->usuario->nombre_completo ?? 'Desconocido' }}
**Fecha:** {{ $pedido->created_at->format('d/m/Y H:i') }}
**Estado actual:** {{ ucfirst($pedido->estado) }}

@if($pedido->elementos->count() > 0)
| Elemento | Cantidad | Área |
|:----------|:---------:|:-----|
@foreach($pedido->elementos as $item)
| {{ $item->nombre }} | {{ $item->pivot->cantidad ?? 1 }} | {{ $item->area->nombre ?? '-' }} |
@endforeach
@endif

---

@endforeach

@component('mail::button', ['url' => url('/admin/pedidos'), 'color' => 'success'])
🔍 Ver todos los pedidos en el sistema
@endcomponent

Gracias,
**{{ config('app.name') }}**
> Este es un correo automático, por favor no responder.
@endcomponent