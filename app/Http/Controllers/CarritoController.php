<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\ElementoPP;
    use App\Models\Pedido;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;

    class CarritoController extends Controller
    {
        // Mostrar carrito
        public function index()
        {
            $carrito = session()->get('carrito', []);
            return view('carrito.index', compact('carrito'));
        }

        // ✅ AGREGAR UN PRODUCTO AL CARRITO (AJAX - SIN REDIRECCIÓN)
        public function agregar(Request $request)
        {
            try {
                // Log para debugging
                \Log::info('Carrito agregar llamado', [
                    'expectsJson' => $request->expectsJson(),
                    'id' => $request->id,
                    'cantidad' => $request->cantidad,
                    'talla' => $request->talla
                ]);

                // Validar que exista el ID
                if (!$request->has('id') || !$request->has('cantidad')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Faltan parámetros requeridos'
                    ], 400);
                }

                $producto = ElementoPP::findOrFail($request->id);
                $cantidad = (int) $request->cantidad;
                $talla = $request->input('talla', null); // 👈 OBTENER TALLA

                // Validar cantidad
                if ($cantidad <= 0 || $cantidad > $producto->cantidad) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cantidad inválida o insuficiente stock'
                    ], 400);
                }

                $carrito = session()->get('carrito', []);

                // Crear una clave única que incluya el ID del producto y la talla
                $clave_carrito = $producto->id . '_' . ($talla ?? 'sin-talla');

                // Si el producto con la misma talla ya está en el carrito, sumar cantidad
                if (isset($carrito[$clave_carrito])) {
                    $carrito[$clave_carrito]['cantidad'] += $cantidad;
                } else {
                    // Agregar nuevo producto
                    $carrito[$clave_carrito] = [
                        'id' => $producto->id,
                        'nombre' => $producto->nombre,
                        'cantidad' => $cantidad,
                        'talla' => $talla, // 👈 GUARDAR TALLA
                        'disponible' => $producto->cantidad,
                        'img_url' => $producto->img_url,
                    ];
                }

                session()->put('carrito', $carrito);

                \Log::info('Producto agregado al carrito', [
                    'producto_id' => $producto->id,
                    'cantidad' => $cantidad,
                    'talla' => $talla,
                    'carrito_count' => count($carrito)
                ]);

                // ✅ SIEMPRE responder con JSON
                return response()->json([
                    'success' => true,
                    'message' => 'Producto agregado al carrito',
                    'carrito_count' => count($carrito)
                ], 200);

            } catch (\Exception $e) {
                \Log::error('Error al agregar al carrito', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);

                // ✅ SIEMPRE responder con JSON
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 500);
            }
        }

        // ✅ AGREGAR MÚLTIPLES PRODUCTOS AL CARRITO (AJAX)
        public function agregarMultiple(Request $request)
        {
            try {
                $items = $request->input('items', []);

                if (empty($items)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No hay items para agregar'
                    ], 400);
                }

                $carrito = session()->get('carrito', []);
                $items_agregados = 0;

                foreach ($items as $item) {
                    // Validar que tenga id y cantidad
                    if (!isset($item['id']) || !isset($item['cantidad'])) {
                        continue;
                    }

                    $producto = ElementoPP::find($item['id']);
                    $cantidad = (int) $item['cantidad'];
                    $talla = $item['talla'] ?? null; // 👈 OBTENER TALLA

                    if (!$producto || $cantidad <= 0 || $cantidad > $producto->cantidad) {
                        continue;
                    }

                    // Crear una clave única que incluya el ID del producto y la talla
                    $clave_carrito = $producto->id . '_' . ($talla ?? 'sin-talla');

                    // Si el producto con la misma talla ya está en el carrito, sumar cantidad
                    if (isset($carrito[$clave_carrito])) {
                        $carrito[$clave_carrito]['cantidad'] += $cantidad;
                    } else {
                        // Agregar nuevo producto
                        $carrito[$clave_carrito] = [
                            'id' => $producto->id,
                            'nombre' => $producto->nombre,
                            'cantidad' => $cantidad,
                            'talla' => $talla, // 👈 GUARDAR TALLA
                            'disponible' => $producto->cantidad,
                            'img_url' => $producto->img_url,
                        ];
                    }

                    $items_agregados++;
                }

                session()->put('carrito', $carrito);

                \Log::info('Múltiples productos agregados al carrito', [
                    'items_agregados' => $items_agregados,
                    'carrito_count' => count($carrito)
                ]);

                // ✅ SIEMPRE responder con JSON
                return response()->json([
                    'success' => true,
                    'message' => "$items_agregados producto(s) agregado(s)",
                    'carrito_count' => count($carrito)
                ], 200);

            } catch (\Exception $e) {
                \Log::error('Error al agregar múltiples al carrito', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);

                // ✅ SIEMPRE responder con JSON
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 500);
            }
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

            try {
                // Crear el pedido
                $pedido = Pedido::create([
                    'fecha' => now(),
                    'users_id' => Auth::id(),
                    'estado' => 'pendiente',
                ]);

                // Asociar los elementos al pedido
                foreach ($carrito as $item) {
                    $producto = ElementoPP::find($item['id']);

                    if ($producto) {
                        // Validar que no pidan más de lo disponible
                        if ($producto->cantidad < $item['cantidad']) {
                            return back()->with('error', "No hay suficiente stock para {$producto->nombre}.");
                        }

                        // Guardar cantidad pedida Y TALLA 👈
                        $pedido->elementos()->attach($producto->id, [
                            'cantidad' => $item['cantidad'],
                            'talla' => $item['talla'] ?? null, // 👈 GUARDAR TALLA EN PIVOT
                        ]);

                        // ✅ DESCONTAR DEL INVENTARIO
                        DB::table('elementos_pp')
                            ->where('id', $producto->id)
                            ->decrement('cantidad', (int) $item['cantidad']);
                    }
                }

                // Vaciar carrito
                session()->forget('carrito');

                \Log::info('Pedido confirmado', [
                    'pedido_id' => $pedido->id,
                    'usuario_id' => Auth::id(),
                    'items_count' => count($carrito)
                ]);

                return redirect()->route('dashboard.instructor')
                                ->with('success', 'Pedido enviado al líder 📦');
            } catch (\Exception $e) {
                \Log::error('Error al confirmar pedido', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);

                return back()->with('error', 'Error al confirmar pedido: ' . $e->getMessage());
            }
        }
    }
