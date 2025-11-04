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
    Mail::to($correoAdmin)->send(new PedidoEnviadoAdmin($pedido)); // ← Nombre correcto

    $pedido->estado = 'enviado';
    $pedido->save();

    return redirect()->back()->with('success', 'Pedido enviado correctamente.');
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
}