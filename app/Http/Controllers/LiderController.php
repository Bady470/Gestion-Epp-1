<?php

namespace App\Http\Controllers;

use App\Mail\PedidoEnviadoAdmin;
use App\Models\Pedido;
use App\Models\User;
use App\Models\Notificacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class LiderController extends Controller
{
    // 🔹 Mostrar todos los pedidos pendientes
    public function index()
    {
        // Obtener el área del líder autenticado

        $user = Auth::user();

        if (!$user) {
            abort(403, 'No autenticado');
        }

        $areaLider = $user->areas_id;


        // Obtener los pedidos solo de instructores de la misma área
        $pedidos = Pedido::with(['usuario', 'elementos.area'])
            ->whereHas('usuario', function ($query) use ($areaLider) {
                $query->where('areas_id', $areaLider);
            })
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


public function enviarTodos(Request $request)
{
    $pedidos = Pedido::where('estado', 'pendiente')
                ->whereHas('usuario', function($query) {
                    $query->where('areas_id', Auth::user()->areas_id);
                })->get();

    if ($pedidos->isEmpty()) {
        return back()->with('error', 'No hay pedidos pendientes para enviar.');
    }

    foreach ($pedidos as $pedido) {
        $pedido->update(['estado' => 'enviado']);
    }

    // 🔍 PRUEBA: Vamos a ver si encontramos al admin
    // Cambia el '1' por el ID real del rol de admin si es necesario
    $admin = User::where('roles_id', 1)->first();

    try {
        // Intentamos crear la notificación
        $nuevaNotificacion = Notificacion::create([
            'user_id' => $admin->id ?? Auth::id(), // Si no hay admin, se la asigna al mismo líder para probar
            'titulo' => 'Nuevos pedidos recibidos',
            'mensaje' => 'El líder ' . Auth::user()->nombre_completo . ' ha enviado ' . $pedidos->count() . ' pedidos.',
            'leida' => false,
            'correo_enviado' => false,
            'datos_adicionales' => [
                'area' => Auth::user()->area->nombre ?? 'Sin área',
                'cantidad_pedidos' => $pedidos->count(),
                'enviado_por' => Auth::user()->nombre_completo,
            ]
        ]);

        // Si llegamos aquí, se guardó. Vamos a confirmar:
        // dd($nuevaNotificacion);

    } catch (\Exception $e) {
        // Si hay un error de base de datos, esto lo detendrá y te mostrará el error real
        dd("Error al crear notificación: " . $e->getMessage());
    }

    return back()->with('success', '¡Todos los pedidos han sido enviados al administrador con éxito!');
}


}
