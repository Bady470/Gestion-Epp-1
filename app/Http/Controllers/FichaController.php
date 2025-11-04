<?php

namespace App\Http\Controllers;

use App\Models\Ficha;
use App\Models\Programa;
use Illuminate\Http\Request;

class FichaController extends Controller
{
    public function index()
    {
        $fichas = Ficha::with('programa')->paginate(10);
        return view('fichas.index', compact('fichas'));
    }

    public function create()
    {
        $programas = Programa::all();
        return view('fichas.create', compact('programas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'numero' => 'required|string|max:45|unique:fichas,numero',
            'programas_id' => 'nullable|exists:programas,id',
        ]);

        Ficha::create($validated);

        return redirect()->route('fichas.index')->with('success', 'Ficha creada correctamente');
    }

    public function edit(Ficha $ficha)
    {
        $programas = Programa::all();
        return view('fichas.edit', compact('ficha', 'programas'));
    }

    public function update(Request $request, Ficha $ficha)
    {
        $validated = $request->validate([
            'numero' => 'required|string|max:45|unique:fichas,numero,' . $ficha->id,
            'programas_id' => 'nullable|exists:programas,id',
        ]);

        $ficha->update($validated);

        return redirect()->route('fichas.index')->with('success', 'Ficha actualizada correctamente');
    }

    public function destroy(Ficha $ficha)
    {
        $ficha->delete();
        return redirect()->route('fichas.index')->with('success', 'Ficha eliminada correctamente');
    }
}