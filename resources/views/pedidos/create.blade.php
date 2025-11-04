@extends('layouts.app')

@section('title', 'Hacer Pedido')

@section('content')
<div class="container mt-5">
    <div class="card border-0 shadow-lg" style="border-radius: 16px;">
        <div class="card-header text-white fw-bold" style="background: linear-gradient(135deg, #39A900, #007200);">
            <i class="bi bi-cart-plus-fill me-2"></i> Nuevo Pedido
        </div>
        <div class="card-body p-4">
            <form action="{{ route('pedidos.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Ficha</label>
                    <select name="fichas_id" class="form-select" required>
                        <option value="">Seleccionar ficha...</option>
                        @foreach(Auth::user()->fichas as $ficha)
                            <option value="{{ $ficha->id }}">{{ $ficha->numero }} - {{ $ficha->programa->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="elementos-container">
                    <div class="elemento-row mb-3 p-3 border rounded bg-light">
                        <div class="row">
                            <div class="col-md-7">
                                <label class="form-label">Elemento</label>
                                <select name="elementos[0][elemento_id]" class="form-select elemento-select" required>
                                    <option value="">Seleccionar...</option>
                                    @foreach($elementos as $epp)
                                        <option value="{{ $epp->id }}">{{ $epp->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Cantidad</label>
                                <input type="number" name="elementos[0][cantidad]" class="form-control" min="1" required>
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-sm remove-elemento">X</button>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-outline-success mb-3" id="add-elemento">
                    <i class="bi bi-plus-circle"></i> Agregar elemento
                </button>

                <div class="text-end">
                    <a href="{{ route('instructor.dashboard') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-success">Guardar como Borrador</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let index = 1;
document.getElementById('add-elemento').addEventListener('click', function() {
    const container = document.getElementById('elementos-container');
    const row = document.querySelector('.elemento-row').cloneNode(true);
    row.querySelectorAll('input, select').forEach(el => {
        el.name = el.name.replace('[0]', `[${index}]`);
        el.value = '';
    });
    row.querySelector('.remove-elemento').addEventListener('click', function() {
        row.remove();
    });
    container.appendChild(row);
    index++;
});

document.querySelectorAll('.remove-elemento').forEach(btn => {
    btn.addEventListener('click', function() {
        if (document.querySelectorAll('.elemento-row').length > 1) {
            this.closest('.elemento-row').remove();
        }
    });
});
</script>
@endsection