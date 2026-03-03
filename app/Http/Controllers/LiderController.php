<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Notificacion; // Añadido
use App\Models\User;         // Añadido
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LiderController extends Controller
{
    /**
     * Mostrar dashboard del líder con pedidos
     */
    public function index()
    {
        $user = Auth::user();
        $pedidos = Pedido::whereHas('usuario', function ($query) use ($user) {
            $query->where('areas_id', $user->areas_id);
        })->with(['usuario', 'ficha.programa', 'elementos'])->get();

        return view('dashboard.lider', [
            'pedidos' => $pedidos,
            'user' => $user
        ]);
    }

    // ... (resumenConsolidado y exportarGFPIF186 se mantienen igual)

    /**
     * Enviar un pedido al administrador
     */
    public function enviarPedido($id)
    {
        $pedido = Pedido::findOrFail($id);
        $user = Auth::user();

        if ($pedido->usuario->areas_id !== $user->areas_id) {
            return redirect()->back()->with('error', 'No tienes permiso para enviar este pedido');
        }

        $pedido->update(['estado' => 'enviado']);

        // --- NOTIFICACIÓN PARA ADMINISTRADORES ---
        $admins = User::where('roles_id', 1)->get();
        foreach ($admins as $admin) {
            Notificacion::create([
                'user_id' => $admin->id,
                'tipo' => 'nuevo_pedido',
                'titulo' => 'Nuevo Pedido Recibido',
                'mensaje' => "El líder {$user->nombre_completo} ha enviado el pedido #{$pedido->id} para revisión.",
                'pedido_id' => $pedido->id,
                'usuario_accion_id' => $user->id,
                'leida' => false,
                'datos_adicionales' => [
                    'Líder' => $user->nombre_completo,
                    'Área' => $user->area->nombre ?? 'No asignada',
                    'Pedido_ID' => "#" . $pedido->id,
                    'Fecha_Envío' => now()->format('d/m/Y H:i')
                ]
            ]);
        }

        return redirect()->back()->with('success', 'Pedido enviado al administrador correctamente');
    }

    /**
     * Enviar todos los pedidos pendientes
     */
    public function enviarTodos()
    {
        $user = Auth::user();

        $pedidos = Pedido::whereHas('usuario', function ($query) use ($user) {
            $query->where('areas_id', $user->areas_id);
        })->where('estado', 'pendiente')->get();

        if ($pedidos->isEmpty()) {
            return redirect()->back()->with('info', 'No hay pedidos pendientes para enviar');
        }

        foreach ($pedidos as $pedido) {
            $pedido->update(['estado' => 'enviado']);
        }

        // --- NOTIFICACIÓN PARA ADMINISTRADORES (Consolidado) ---
        $admins = User::where('roles_id', 1)->get();
        foreach ($admins as $admin) {
            Notificacion::create([
                'user_id' => $admin->id,
                'tipo' => 'consolidado_pedidos',
                'titulo' => 'Consolidado de Pedidos Enviado',
                'mensaje' => "Se han enviado " . $pedidos->count() . " pedidos del área de {$user->nombre_completo} para revisión.",
                'usuario_accion_id' => $user->id,
                'leida' => false,
                'datos_adicionales' => [
                    'Líder' => $user->nombre_completo,
                    'Área' => $user->area->nombre ?? 'No asignada',
                    'Total_Pedidos' => $pedidos->count(),
                    'Fecha_Envío' => now()->format('d/m/Y H:i')
                ]
            ]);
        }

        return redirect()->back()->with('success', 'Se enviaron ' . $pedidos->count() . ' pedidos al administrador');
    }

    /**
     * Aprobar un pedido
     */
    public function aprobar($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->update(['estado' => 'aprobado']);
        return redirect()->back()->with('success', 'Pedido aprobado correctamente');
    }

    /**
     * Rechazar un pedido
     */
    public function rechazar($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->update(['estado' => 'rechazado']);
        return redirect()->back()->with('success', 'Pedido rechazado correctamente');
    }
}
