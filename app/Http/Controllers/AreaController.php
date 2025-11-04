<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Mostrar todas las áreas.
     */
    public function index()
    {
        $areas = Area::orderBy('id', 'desc')->get();
        return view('areas.index', compact('areas'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        return view('areas.create');
    }

    /**
     * Guardar una nueva área.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:areas,nombre',
        ]);

        Area::create([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('areas.index')
                         ->with('success', 'Área creada correctamente.');
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(Area $area)
    {
        return view('areas.edit', compact('area'));
    }

    /**
     * Actualizar área.
     */
    public function update(Request $request, Area $area)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:areas,nombre,' . $area->id,
        ]);

        $area->update([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('areas.index')
                         ->with('success', 'Área actualizada correctamente.');
    }

    /**
     * Eliminar un área.
     */
    public function destroy(Area $area)
    {
        $area->delete();
        return redirect()->route('areas.index')
                         ->with('success', 'Área eliminada correctamente.');
    }
}