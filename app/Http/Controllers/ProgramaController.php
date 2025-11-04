<?php

namespace App\Http\Controllers;

use App\Models\Programa;
use App\Models\Area;
use Illuminate\Http\Request;

class ProgramaController extends Controller
{
    public function index()
    {
        $programas = Programa::with('area')->paginate(10);
        return view('programas.index', compact('programas'));
    }

    public function create()
    {
        $areas = Area::all();
        return view('programas.create', compact('areas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:45|unique:programas,nombre',
            'areas_id' => 'nullable|exists:areas,id',
        ]);

        Programa::create($validated);

        return redirect()->route('programas.index')->with('success', 'Programa creado correctamente');
    }

    public function edit(Programa $programa)
    {
        $areas = Area::all();
        return view('programas.edit', compact('programa', 'areas'));
    }

    public function update(Request $request, Programa $programa)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:45|unique:programas,nombre,' . $programa->id,
            'areas_id' => 'nullable|exists:areas,id',
        ]);

        $programa->update($validated);

        return redirect()->route('programas.index')->with('success', 'Programa actualizado correctamente');
    }

    public function destroy(Programa $programa)
    {
        $programa->delete();
        return redirect()->route('programas.index')->with('success', 'Programa eliminado correctamente');
    }
}