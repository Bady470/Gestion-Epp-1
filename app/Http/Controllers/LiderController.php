<?php

namespace App\Http\Controllers;

use App\Mail\PedidoEnviadoAdmin;
use App\Models\Pedido;
use App\Models\User;
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

    // Obtener área del primer elemento
    $area = $pedido->elementos->first()->area ?? null;

    if (!$area) {
        return back()->with('error', 'No se pudo identificar el área del pedido.');
    }

    // Encontrar líder del área
    $lider = User::where('roles_id', 2)
        ->where('areas_id', $area->id)
        ->first();

    if (!$lider) {
        return back()->with('error', 'No existe un líder asignado al área del pedido.');
    }

    // Enviar correo solo al líder del área
    Mail::to($lider->email)->send(new PedidoEnviadoAdmin($pedido, $area->nombre));

    // Cambiar estado
    $pedido->estado = 'enviado';
    $pedido->save();

    return back()->with('success', 'Pedido enviado correctamente al líder del área.');
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
    $pedidosPorArea = Pedido::with(['usuario', 'elementos.area'])
        ->where('estado', 'pendiente')
        ->get()
        ->groupBy(fn($pedido) => optional($pedido->elementos->first()->area)->nombre);

    if ($pedidosPorArea->isEmpty()) {
        return redirect()->back()->with('error', 'No hay pedidos pendientes para enviar.');
    }

    foreach ($pedidosPorArea as $area => $pedidos) {

        // Enviar correo agrupado por área
        Mail::to('juancabreras529@gmail.com')->send(new PedidoEnviadoAdmin($pedidos, $area));

        // Actualizar pedidos
        foreach ($pedidos as $pedido) {
            foreach ($pedido->elementos as $elemento) {
                $cantidadSolicitada = $elemento->cantidad;
                $elemento->cantidad = max(0, $elemento->cantidad - $cantidadSolicitada);
                $elemento->save();
            }

            $pedido->estado = 'enviado';
            $pedido->save();
        }
    }

    return redirect()->back()->with('success', 'Pedidos agrupados por área enviados correctamente.');
}

}
