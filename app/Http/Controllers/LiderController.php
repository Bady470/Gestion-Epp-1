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

        // 👈 NUEVO: Cargar ficha en los pedidos
        $pedidos = Pedido::with(['usuario', 'elementos.area', 'ficha.programa'])
            ->whereHas('usuario', function ($query) use ($areaLider) {
                $query->where('areas_id', $areaLider);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.lider', compact('pedidos'));
    }

    // 🔹 Enviar un pedido individual
    public function enviarPedido($id)
    {
        // 👈 NUEVO: Cargar ficha
        $pedido = Pedido::with(['usuario', 'elementos.area', 'ficha.programa'])->findOrFail($id);

        // Obtener área del primer elemento
        $area = $pedido->elementos->first()->area ?? null;

        if (!$area) {
            return back()->with('error', 'No se pudo identificar el área del pedido.');
        }

        // Encontrar administrador
        $admin = User::where('roles_id', 1)->first();

        if (!$admin) {
            return back()->with('error', 'No existe un administrador asignado.');
        }

        try {
            // 👈 NUEVO: Pasar un array de pedidos (aunque sea uno solo)
            Mail::to($admin->email)->send(new PedidoEnviadoAdmin([$pedido], $area->nombre));

            // Cambiar estado
            $pedido->estado = 'enviado';
            $pedido->save();

            // 👈 NUEVO: Crear notificación para el admin
            try {
                Notificacion::create([
                    'user_id' => $admin->id,
                    'titulo' => 'Nuevo pedido recibido',
                    'mensaje' => 'El instructor ' . $pedido->usuario->nombre_completo . ' ha enviado un pedido desde el área ' . $area->nombre . '.',
                    'leida' => false,
                    'correo_enviado' => false,
                    'datos_adicionales' => [
                        'pedido_id' => $pedido->id,
                        'area' => $area->nombre,
                        'instructor' => $pedido->usuario->nombre_completo,
                        'ficha' => $pedido->ficha ? $pedido->ficha->numero : 'Sin ficha',
                        'cantidad_elementos' => $pedido->elementos->count(),
                    ]
                ]);
            } catch (\Exception $e) {
                \Log::error('Error al crear notificación individual: ' . $e->getMessage());
            }

            return back()->with('success', 'Pedido enviado correctamente al administrador.');
        } catch (\Exception $e) {
            \Log::error('Error al enviar pedido: ' . $e->getMessage());
            return back()->with('error', 'Error al enviar el pedido: ' . $e->getMessage());
        }
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

    // 🔹 Enviar todos los pedidos pendientes
    public function enviarTodos(Request $request)
    {
        // 👈 NUEVO: Cargar ficha en los pedidos
        $pedidos = Pedido::with(['usuario', 'elementos.area', 'ficha.programa'])
            ->where('estado', 'pendiente')
            ->whereHas('usuario', function ($query) {
                $query->where('areas_id', Auth::user()->areas_id);
            })
            ->get();

        if ($pedidos->isEmpty()) {
            return back()->with('error', 'No hay pedidos pendientes para enviar.');
        }

        // Encontrar administrador
        $admin = User::where('roles_id', 1)->first();

        if (!$admin) {
            return back()->with('error', 'No existe un administrador asignado.');
        }

        try {
            // Obtener área del primer pedido
            $area = $pedidos->first()->elementos->first()->area ?? null;
            $areaName = $area ? $area->nombre : 'Sin área';

            // 👈 NUEVO: Enviar email con todos los pedidos
            Mail::to($admin->email)->send(new PedidoEnviadoAdmin($pedidos, $areaName));

            // Actualizar estado de todos los pedidos
            foreach ($pedidos as $pedido) {
                $pedido->update(['estado' => 'enviado']);
            }

            // Crear notificación
            try {
                Notificacion::create([
                    'user_id' => $admin->id,
                    'titulo' => 'Nuevos pedidos recibidos',
                    'mensaje' => 'El líder ' . Auth::user()->nombre_completo . ' ha enviado ' . $pedidos->count() . ' pedidos.',
                    'leida' => false,
                    'correo_enviado' => false,
                    'datos_adicionales' => [
                        'area' => $areaName,
                        'cantidad_pedidos' => $pedidos->count(),
                        'enviado_por' => Auth::user()->nombre_completo,
                    ]
                ]);
            } catch (\Exception $e) {
                \Log::error('Error al crear notificación: ' . $e->getMessage());
            }

            return back()->with('success', '¡Todos los pedidos han sido enviados al administrador con éxito!');
        } catch (\Exception $e) {
            \Log::error('Error al enviar pedidos: ' . $e->getMessage());
            return back()->with('error', 'Error al enviar los pedidos: ' . $e->getMessage());
        }
    }

    // 👈 NUEVO: Obtener resumen consolidado de pedidos del área del líder
    public function resumenConsolidado()
    {
        try {
            $areaId = Auth::user()->areas_id;

            // Obtener todos los pedidos del área
            $pedidos = Pedido::with(['elementos' => function($q) use ($areaId) {
                $q->where('areas_id', $areaId);
            }, 'usuario'])
            ->whereHas('usuario', function ($query) use ($areaId) {
                $query->where('areas_id', $areaId);
            })
            ->get();

            if ($pedidos->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay pedidos para tu área'
                ], 404);
            }

            // Consolidar: agrupar por nombre de producto y talla
            $consolidado = [];

            foreach ($pedidos as $pedido) {
                foreach ($pedido->elementos as $elemento) {
                    $clave = $elemento->nombre . '|' . ($elemento->pivot->talla ?? 'Sin talla');

                    if (!isset($consolidado[$clave])) {
                        $consolidado[$clave] = [
                            'nombre' => $elemento->nombre,
                            'talla' => $elemento->pivot->talla ?? 'Sin talla especificada',
                            'cantidad_total' => 0,
                            'area' => $elemento->area->nombre ?? '-',
                            'proteccion' => $elemento->filtro->parte_del_cuerpo ?? '-',
                        ];
                    }

                    $consolidado[$clave]['cantidad_total'] += $elemento->pivot->cantidad;
                }
            }

            // Ordenar por nombre
            uasort($consolidado, function($a, $b) {
                return strcmp($a['nombre'], $b['nombre']);
            });

            $totalUnidades = array_sum(array_column($consolidado, 'cantidad_total'));

            return response()->json([
                'success' => true,
                'consolidado' => array_values($consolidado),
                'total_pedidos' => $pedidos->count(),
                'total_unidades' => $totalUnidades
            ]);
        } catch (\Exception $e) {
            \Log::error('Error en resumenConsolidado del líder: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar el resumen: ' . $e->getMessage()
            ], 500);
        }
    }
}
