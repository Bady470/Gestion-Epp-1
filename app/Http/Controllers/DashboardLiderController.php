<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class DashboardLiderController extends Controller
{
    public function index()
    {
        // Obtener todos los pedidos pendientes o enviados
        $pedidos = Pedido::with('usuario')
            ->orderBy('created_at', 'desc')
            ->get();

        // Enviar variable a la vista
        return view('dashboard.lider', compact('pedidos'));
    }
}