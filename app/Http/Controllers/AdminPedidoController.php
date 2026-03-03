<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\ElementoPP;
use App\Models\Notificacion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with(['usuario'])->latest()->get();
        return view('admin.pedidos.index', compact('pedidos'));
    }

    public function show($id)
    {
        $pedido = Pedido::with(['usuario', 'elementos.area', 'ficha.programa'])->findOrFail($id);

        // 👈 NUEVO: Obtener todos los pedidos del área para el resumen consolidado
        $area = $pedido->elementos->first()->area ?? null;
        $pedidosDelArea = [];

        if ($area) {
            $pedidosDelArea = Pedido::with(['elementos' => function($q) use ($area) {
                $q->where('areas_id', $area->id);
            }, 'usuario'])
            ->whereHas('elementos', function($q) use ($area) {
                $q->where('areas_id', $area->id);
            })
            ->get();
        }

        return view('admin.pedidos.show', compact('pedido', 'pedidosDelArea', 'area'));
    }

    public function dashboard()
    {
        // Contar notificaciones no leídas para el admin
        $notificacionesNoLeidas = \App\Models\Notificacion::where('leida', false)->count();

        return view('dashboard.admin', compact('notificacionesNoLeidas'));
    }

    // 👈 MÉTODO CORREGIDO: Obtener productos por área CON CANTIDAD DEL PEDIDO
    public function productosArea(Request $request)
    {
        $areaId = $request->query('areas_id');

        // Obtener todos los elementos de pedidos con sus cantidades y tallas de la tabla pivot
        $query = Pedido::with(['elementos' => function($q) {
            $q->with(['area', 'filtro']);
        }])
        ->get()
        ->pluck('elementos')
        ->flatten();

        // Si hay un área específica, filtrar
        if ($areaId) {
            $query = $query->filter(function($elemento) use ($areaId) {
                return $elemento->area_id == $areaId;
            });
        }

        // Transformar los datos para incluir cantidad y talla del pivot
        $productos = $query->map(function($elemento) {
            return [
                'id' => $elemento->id,
                'nombre' => $elemento->nombre,
                'descripcion' => $elemento->descripcion,
                'img_url' => $elemento->img_url,
                'cantidad' => $elemento->pivot->cantidad,  // 👈 CANTIDAD DEL PEDIDO
                'talla' => $elemento->pivot->talla,        // 👈 TALLA DEL PEDIDO
                'area' => $elemento->area,
                'filtro' => $elemento->filtro,
                'disponible' => $elemento->cantidad         // Stock disponible
            ];
        })->values();

        return response()->json([
            'success' => true,
            'productos' => $productos
        ]);
    }

    // 👈 NUEVO: Obtener resumen consolidado de pedidos por área
    public function resumenConsolidado($areaId)
    {
        // Obtener todos los pedidos del área
        $pedidos = Pedido::with(['elementos' => function($q) use ($areaId) {
            $q->where('areas_id', $areaId);
        }, 'usuario'])
        ->whereHas('elementos', function($q) use ($areaId) {
            $q->where('areas_id', $areaId);
        })
        ->get();

        if ($pedidos->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No hay pedidos para esta área'
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
                        'pedidos_count' => 0,
                    ];
                }

                $consolidado[$clave]['cantidad_total'] += $elemento->pivot->cantidad;
                $consolidado[$clave]['pedidos_count'] = count(array_unique(
                    array_column($consolidado, 'pedidos_count')
                ));
            }
        }

        // Ordenar por nombre
        uasort($consolidado, function($a, $b) {
            return strcmp($a['nombre'], $b['nombre']);
        });

        return response()->json([
            'success' => true,
            'consolidado' => array_values($consolidado),
            'total_pedidos' => $pedidos->count(),
            'total_unidades' => array_sum(array_column($consolidado, 'cantidad_total'))
        ]);
    }
    public function aprobar($id)
    {
        $pedido = Pedido::with('usuario')->findOrFail($id);
        $pedido->update(['estado' => 'aprobado']);

        $admin = Auth::user();

        // --- NOTIFICACIÓN PARA EL LÍDER DEL ÁREA ---
        // Buscamos al líder del área del usuario que hizo el pedido
        $lider = User::where('areas_id', $pedido->usuario->areas_id)
                     ->where('roles_id', 3) // Según tu seeder, el líder es roles_id = 3
                     ->first();

        if ($lider) {
            Notificacion::create([
                'user_id' => $lider->id,
                'tipo' => 'pedido_aprobado',
                'titulo' => 'Pedido Aprobado',
                'mensaje' => "El administrador ha aprobado tu pedido #{$pedido->id}.",
                'pedido_id' => $pedido->id,
                'usuario_accion_id' => $admin->id,
                'leida' => false,
                'datos_adicionales' => [
                    'Estado' => 'APROBADO',
                    'Pedido_ID' => "#" . $pedido->id,
                    'Aprobado_por' => $admin->nombre_completo,
                    'Fecha' => now()->format('d/m/Y H:i')
                ]
            ]);
        }

        return redirect()->back()->with('success', 'Pedido aprobado correctamente');
    }
    public function rechazar($id)
    {
        $pedido = Pedido::with('usuario')->findOrFail($id);
        $pedido->update(['estado' => 'rechazado']);

        $admin = Auth::user();

        // --- NOTIFICACIÓN PARA EL LÍDER DEL ÁREA ---
        $lider = User::where('areas_id', $pedido->usuario->areas_id)
                     ->where('roles_id', 3)
                     ->first();

        if ($lider) {
            Notificacion::create([
                'user_id' => $lider->id,
                'tipo' => 'pedido_rechazado',
                'titulo' => 'Pedido Rechazado',
                'mensaje' => "Tu pedido #{$pedido->id} ha sido rechazado por el administrador.",
                'pedido_id' => $pedido->id,
                'usuario_accion_id' => $admin->id,
                'leida' => false,
                'datos_adicionales' => [
                    'Estado' => 'RECHAZADO',
                    'Pedido_ID' => "#" . $pedido->id,
                    'Rechazado_por' => $admin->nombre_completo,
                    'Fecha' => now()->format('d/m/Y H:i'),
                    'Acción' => 'Por favor, revisa los detalles del pedido.'
                ]
            ]);
        }

        return redirect()->back()->with('success', 'Pedido rechazado correctamente');
    }
}
