<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ElementoPP;
use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    // Mostrar carrito
    public function index()
    {
        $carrito = session()->get('carrito', []);
        return view('carrito.index', compact('carrito'));
    }

    // Agregar al carrito
    public function agregar(Request $request)
    {
        $producto = ElementoPP::findOrFail($request->id);

        $carrito = session()->get('carrito', []);

        $carrito[$producto->id] = [
            'id' => $producto->id,
            'nombre' => $producto->nombre,
            'cantidad' => $request->cantidad,
            'disponible' => $producto->cantidad,
            'img_url' => $producto->img_url,
        ];

        session()->put('carrito', $carrito);

        return redirect()->route('carrito.index')->with('success', 'Elemento agregado al carrito.');
    }

    // Eliminar elemento del carrito
    public function eliminar($id)
    {
        $carrito = session()->get('carrito', []);
        unset($carrito[$id]);
        session()->put('carrito', $carrito);

        return back()->with('success', 'Elemento eliminado del carrito');
    }

    // Confirmar pedido
    public function confirmar()
    {
        $carrito = session()->get('carrito', []);

        if (empty($carrito)) {
            return back()->with('error', 'Tu carrito está vacío.');
        }

        // Crear el pedido
        $pedido = Pedido::create([
            'fecha' => now(),
            'users_id' => Auth::id(),
            'estado' => 'pendiente',
        ]);

        // Asociar los elementos al pedido con la cantidad
        foreach ($carrito as $item) {
            $producto = ElementoPP::find($item['id']);

            if ($producto) {
                // Verificar si hay stock suficiente
                if ($producto->cantidad >= $item['cantidad']) {
                    // Descontar solo la cantidad pedida
                    $producto->cantidad -= $item['cantidad'];
                    $producto->save();

                    // Guardar relación en la tabla pivote con la cantidad
                    $pedido->elementos()->attach($producto->id, [
                        'cantidad' => $item['cantidad'],
                    ]);
                } else {
                    // Si no hay suficiente stock, se omite y muestra error
                    return back()->with('error', "No hay suficiente stock para {$producto->nombre}.");
                }
            }
        }

        // Vaciar carrito
        session()->forget('carrito');

        return redirect()->route('dashboard.instructor')->with('success', 'Pedido enviado al líder 📦');
    }
}