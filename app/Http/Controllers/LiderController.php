<?php

namespace App\Http\Controllers;

use App\Mail\PedidoEnviadoAdmin;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
class LiderController extends Controller
{
    // 🔹 Mostrar todos los pedidos pendientes
    public function index()
    {
        // Obtiene los pedidos pendientes o enviados
        $pedidos = Pedido::with(['usuario', 'elementos.area'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.lider', compact('pedidos'));
    }



public function enviarPedido($id)
{
    $pedido = Pedido::with(['usuario', 'elementos.area'])->findOrFail($id);

    $correoAdmin = 'juancabreras529@gmail.com';
    Mail::to($correoAdmin)->send(new PedidoEnviadoAdmin($pedido)); // ← Tu mailable

    $pedido->estado = 'enviado';
    $pedido->save();

    // No redirige aquí (lo hace el llamador)
}


    // 🔹 Aprobar un pedido
    public function aprobar($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->estado = 'aprobado';
        $pedido->save();

        return redirect()->back()->with('success', '✅ Pedido aprobado correctamente.');
    }

    // 🔹 Rechazar un pedido
    public function rechazar($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->estado = 'rechazado';
        $pedido->save();

        return redirect()->back()->with('error', '❌ Pedido rechazado.');
    }

    // LiderController.php


public function enviarTodos()
{
    // Obtener solo pendientes
    $pedidos = Pedido::with(['usuario', 'elementos.area'])
                     ->where('estado', 'pendiente')
                     ->get();

    if ($pedidos->isEmpty()) {
        return redirect()->back()->with('error', 'No hay pedidos pendientes para enviar.');
    }

    // Recolectar todos los pedidos en una colección
    $todosLosPedidos = collect();

    foreach ($pedidos as $pedido) {
        // Reutilizamos tu lógica existente
        $this->enviarPedido($pedido->id); // ← ¡Reutiliza tu método!

        // Agregamos al correo grupal
        $todosLosPedidos->push($pedido);
    }

    // Opcional: Enviar un correo resumen
    // Mail::to('juancabreras529@gmail.com')->send(new PedidoEnviadoAdmin($todosLosPedidos));

    return redirect()->back()->with('success', "¡{$todosLosPedidos->count()} pedidos enviados al administrador!");
}
    
}