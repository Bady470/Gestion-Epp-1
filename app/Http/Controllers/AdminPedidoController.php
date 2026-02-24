<?php

namespace App\Http\Controllers;

use App\Models\Pedido;

class AdminPedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with(['usuario'])->latest()->get();
        return view('admin.pedidos.index', compact('pedidos'));
    }

    public function show($id)
    {
        $pedido = Pedido::with(['usuario', 'elementos.area'])->findOrFail($id);
        return view('admin.pedidos.show', compact('pedido'));
    }

    public function dashboard()
{
    // Contar notificaciones no leídas para el admin
    $notificacionesNoLeidas = \App\Models\Notificacion::where('leida', false)->count();

    return view('dashboard.admin', compact('notificacionesNoLeidas'));
}

}
