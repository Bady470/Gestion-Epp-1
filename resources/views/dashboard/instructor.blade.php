@extends('layouts.dashboard')


@section('content')
<div class="text-end mb-3">
    <a href="{{ route('carrito.index') }}" class="btn btn-success">
        Ver carrito 🛒
    </a>
</div>

<div class="container py-4">
    <h2 class="mb-3 text-center">👋 Bienvenido, {{ $user->nombre_completo }}</h2>
    <p class="text-center text-muted">Área asignada:
        <strong>{{ $user->area->nombre ?? 'Sin área' }}</strong>
    </p>

    @if ($elementos->count() > 0)
    <div class="row mt-4">
        @foreach ($elementos as $epp)
        <div class="col-md-4 col-sm-6 mb-4">
            <div class="card shadow-sm h-100 border-0">

                <img src="{{ asset($epp->img_url) }}" class="card-img-top" alt="{{ $epp->nombre }}"
                    style="height: 200px; object-fit: cover;">

                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title">{{ $epp->nombre }}</h5>
                        <p class="text-muted small mb-1">
                            Área: <strong>{{ $epp->area->nombre ?? '-' }}</strong>
                        </p>
                        <p class="text-muted small mb-1">
                            Filtro: <strong>{{ $epp->filtro->parte_del_cuerpo ?? '-' }}</strong>
                        </p>
                        <p class="text-muted small mb-2">
                            Cantidad disponible: <strong>{{ $epp->cantidad }}</strong>
                        </p>
                    </div>

                    <div class="mt-auto">
                        <div class="input-group mb-3">
                            <button class="btn btn-outline-secondary btn-sm" type="button"
                                onclick="changeQuantity('{{ $epp->id }}', -1)">−</button>
                            <input type="number" id="qty-{{ $epp->id }}" class="form-control text-center" value="0"
                                min="0" max="{{ $epp->cantidad }}">
                            <button class="btn btn-outline-secondary btn-sm" type="button"
                                onclick="changeQuantity('{{ $epp->id }}',1)">+</button>
                        </div>

                        <div class="d-grid gap-2">
                            <form action="{{ route('carrito.agregar') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $epp->id }}">
                                <input type="hidden" id="cantidad-{{ $epp->id }}" name="cantidad" value="0">
                                <button type="submit" class="btn btn-warning btn-sm text-dark fw-bold"
                                    onclick="document.getElementById('cantidad-{{ $epp->id }}').value = document.getElementById('qty-{{ $epp->id }}').value;">
                                    🛒 Agregar al carrito
                                </button>
                            </form>



                        </div>

                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $elementos->links() }}
    </div>
    @else
    <div class="alert alert-info text-center mt-4">
        No hay elementos disponibles para tu área.
    </div>
    @endif
</div>

<script>
function changeQuantity(id, delta) {
    const input = document.getElementById(`qty-${id}`);
    let value = parseInt(input.value) || 0;
    const max = parseInt(input.max);
    value += delta;
    if (value < 1) value = 0;
    if (value > max) value = max;
    input.value = value;
}
</script>
@endsection