<?php

namespace App\Http\Controllers;

use App\Models\ElementoPP;
use App\Models\Ficha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstructoresController extends Controller
{
    public function index()
    {
        // Obtener el usuario logueado
        $user = Auth::user();

        // Verificar si el usuario tiene un área asignada
        if (!$user->areas_id) {
            return redirect()->back()->with('error', 'No tienes un área asignada.');
        }

        // 👈 NUEVO: Obtener las fichas del área del usuario
        // Las fichas están relacionadas con programas, y los programas con áreas
        $fichas = Ficha::whereHas('programa', function ($query) use ($user) {
            $query->where('areas_id', $user->areas_id);
        })->get();

        // Obtener los EPP solo de su área
        $elementos = ElementoPP::with(['area', 'filtro'])
            ->where('areas_id', $user->areas_id)
            ->paginate(10);

        return view('dashboard.instructor', compact('elementos', 'user', 'fichas'));
    }
}
