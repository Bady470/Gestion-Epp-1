<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardLiderController extends Controller
{
    public function index()
    {
        // Obtener el área del líder autenticado
        $user = Auth::user();

        if (!$user) {
            abort(403, 'No autenticado');
        }

        $areaLider = $user->areas_id;


        // Obtener los pedidos solo de instructores de la misma área
        $pedidos = Pedido::with('usuario')
            ->whereHas('usuario', function ($query) use ($areaLider) {
                $query->where('areas_id', $areaLider);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Enviar variable a la vista
        return view('dashboard.lider', compact('pedidos'));
    }
}
