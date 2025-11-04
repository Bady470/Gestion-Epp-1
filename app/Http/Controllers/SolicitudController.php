<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Mail\PedidoEnviadoAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SolicitudController extends Controller
{
    // 🔹 Listar las solicitudes pendientes
    public function index()
    {
        $solicitudes = Pedido::with('usuario')->where('estado', 'pendiente')->get();
        return view('solicitudes.index', compact('solicitudes'));
    }

    // 🔹 Ver una solicitud específica
    public function show($id)
    {
        $pedido = Pedido::with(['usuario', 'items.elemento'])->findOrFail($id);
        return view('solicitudes.show', compact('pedido'));
    }

    // 🔹 Enviar correo al administrador
    public function enviar($id)
    {
        $pedido = Pedido::with(['usuario', 'items.elemento'])->findOrFail($id);

        // Cambiar estado
        $pedido->update(['estado' => 'enviado']);

        // Enviar correo al administrador
        Mail::to('juancabreras529@gmail.com')->send(new PedidoEnviadoAdmin($pedido));

        return redirect()->route('solicitudes.index')->with('success', 'Pedido enviado al administrador.');
    }
}