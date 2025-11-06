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

        // Enviar correo al admin
        $correoAdmin = 'juancabreras529@gmail.com';
        Mail::to($correoAdmin)->send(new PedidoEnviadoAdmin($pedido, $pedido->elementos->first()->area->nombre ?? 'Sin área'));

        // 🔹 Descontar inventario
        foreach ($pedido->elementos as $elemento) {
            $cantidadSolicitada = $elemento->cantidad;
            $elemento->cantidad -= $cantidadSolicitada;
            if ($elemento->cantidad < 0) {
                $elemento->cantidad = 0;
            }
            $elemento->save();
        }

        // 🔹 Cambiar estado del pedido
        $pedido->estado = 'enviado';
        $pedido->save();
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
        // Obtener todos los pedidos pendientes agrupados por área
        $pedidosPorArea = Pedido::with(['usuario', 'elementos.area'])
            ->where('estado', 'pendiente')
            ->get()
            ->groupBy(fn($pedido) => optional($pedido->elementos->first()->area)->nombre);

        if ($pedidosPorArea->isEmpty()) {
            return redirect()->back()->with('error', 'No hay pedidos pendientes para enviar.');
        }

        foreach ($pedidosPorArea as $area => $pedidos) {
            // 🔹 Enviar correo por área
            Mail::to('juancabreras529@gmail.com')->send(new PedidoEnviadoAdmin($pedidos, $area));

            // 🔹 Cambiar estado de pedidos y descontar stock
            foreach ($pedidos as $pedido) {
                foreach ($pedido->elementos as $elemento) {
                    if ($elemento->cantidad > 0) {
                        // Restar el número solicitado del inventario
                        $cantidadSolicitada = $elemento->cantidad;
                        $nuevoStock = max(0, $elemento->cantidad - $cantidadSolicitada);
                        $elemento->update(['cantidad' => $nuevoStock]);
                    }
                }

                $pedido->estado = 'enviado';
                $pedido->save();
            }
        }

        return redirect()->back()->with('success', 'Pedidos agrupados por área y enviados al administrador.');
    }
}