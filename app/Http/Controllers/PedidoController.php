<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    // Listar pedidos del usuario autenticado
    public function index()
    {
        $pedidos = Pedido::with('elementos')
            ->where('users_id', Auth::id())
            ->orderByDesc('fecha')
            ->get();

        return view('pedidos.index', compact('pedidos'));
    }

    // Ver detalles de un pedido específico
    public function show($id)
    {
        $pedido = Pedido::with('elementos')
            ->where('users_id', Auth::id())
            ->findOrFail($id);

        return view('pedidos.show', compact('pedido'));
    }
}