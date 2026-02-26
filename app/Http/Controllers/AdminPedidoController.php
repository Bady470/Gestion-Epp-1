<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\ElementoPP;
use Illuminate\Http\Request;

class AdminPedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with(['usuario'])->latest()->get();
        return view('admin.pedidos.index', compact('pedidos'));
    }

    public function show($id)
    {
        $pedido = Pedido::with(['usuario', 'elementos.area'])->findOrFail($id);
        return view('admin.pedidos.show', compact('pedido'));
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
}
