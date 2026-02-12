<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Mail\PedidosAgrupadosAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SolicitudController extends Controller
{
    // 🔹 Listar las solicitudes pendientes
    public function index()
    {
        $solicitudes = Pedido::with(['usuario', 'items.elemento.area'])
            ->where('estado', 'pendiente')
            ->get();

        return view('solicitudes.index', compact('solicitudes'));
    }

    // 🔹 Ver una solicitud específica
    public function show($id)
    {
        $pedido = Pedido::with(['usuario', 'items.elemento.area'])
            ->findOrFail($id);

        return view('solicitudes.show', compact('pedido'));
    }


    // 🔹 Enviar pedidos agrupados al administrador (como lo hicimos en líder)
    public function enviarTodos()
    {
        // Obtener pedidos pendientes con toda la info necesaria
        $pedidos = Pedido::with(['usuario', 'items.elemento.area'])
            ->where('estado', 'pendiente')
            ->get();

        if ($pedidos->isEmpty()) {
            return redirect()->back()->with('error', 'No hay solicitudes pendientes para enviar.');
        }

        // 🔸 Agrupar por área
        $pedidosPorArea = $pedidos->groupBy(function ($pedido) {
            return optional($pedido->items->first()->elemento->area)->nombre ?? 'Sin área';
        });

        foreach ($pedidosPorArea as $area => $pedidosArea) {

            // 🔸 Enviar correo agrupado por área
            Mail::to('juancabreras529@gmail.com')->send(
                new PedidosAgrupadosAdmin($pedidosArea, $area)
            );

            // 🔸 Cambiar estado de esos pedidos a 'enviado'
            foreach ($pedidosArea as $pedido) {
                $pedido->estado = 'enviado';
                $pedido->save();
            }
        }

        return redirect()->route('solicitudes.index')
            ->with('success', 'Solicitudes enviadas correctamente al administrador.');
    }



    // 🔹 Enviar un pedido individual (si quieres dejarlo también)
    public function enviar($id)
    {
        $pedido = Pedido::with(['usuario', 'items.elemento.area'])
            ->findOrFail($id);

        $area = $pedido->items->first()->elemento->area->nombre ?? 'Sin área';

        // Enviar solo este pedido
        Mail::to('juancabreras529@gmail.com')->send(
            new PedidosAgrupadosAdmin(collect([$pedido]), $area)
        );

        $pedido->update(['estado' => 'enviado']);

        return redirect()->route('solicitudes.index')->with('success', 'Pedido enviado al administrador.');
    }
}
