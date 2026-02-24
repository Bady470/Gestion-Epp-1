<?php
namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Http\Request;

class NotificacionController extends Controller
{
public function index()
{
    $notificaciones = Notificacion::orderBy('created_at', 'desc')->get();
    $noLeidas = Notificacion::where('leida', false)->count();

    // Opcional: Si quieres mostrar los pedidos directamente en esta vista
    $pedidosEnviados = \App\Models\Pedido::with(['usuario', 'elementos'])
                        ->where('estado', 'enviado')
                        ->get();

    return view('notificacion.notificaciones_index', compact('notificaciones', 'noLeidas', 'pedidosEnviados'));
}



    public function marcarLeida($id)
    {
        $notificacion = Notificacion::findOrFail($id);
        $notificacion->update(['leida' => true]);

        return response()->json(['success' => true]);
    }

    public function marcarNoLeida($id)
    {
        $notificacion = Notificacion::findOrFail($id);
        $notificacion->update(['leida' => false]);

        return response()->json(['success' => true]);
    }

    public function marcarTodasLeidas() // Nombre corregido para la ruta
    {
        Notificacion::where('leida', false)->update(['leida' => true]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $notificacion = Notificacion::findOrFail($id);
        $notificacion->delete();

        return response()->json(['success' => true]);
    }
}
