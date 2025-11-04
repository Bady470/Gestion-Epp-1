<?php

namespace App\Http\Controllers;

use App\Models\ElementoPP;
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

        // Obtener los EPP solo de su área
        $elementos = ElementoPP::with(['area', 'filtro'])
            ->where('areas_id', $user->areas_id)
            ->paginate(10);

        return view('dashboard.instructor', compact('elementos', 'user'));
    }





}
