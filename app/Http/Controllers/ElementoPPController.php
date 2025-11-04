<?php

namespace App\Http\Controllers;

use App\Models\ElementoPP;
use App\Models\Area;
use App\Models\Filtro;
use Illuminate\Http\Request;

class ElementoPPController extends Controller
{
    public function index()
    {
        $elementos = ElementoPP::with(['area', 'filtro'])->paginate(10);
        return view('elementos_pp.index', compact('elementos'));
    }

    public function create()
    {
        $areas = Area::all();
        $filtros = Filtro::all();
        return view('elementos_pp.create', compact('areas', 'filtros'));
    }

   public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:45',
        'descripcion' => 'nullable|string',
        'cantidad' => 'required|integer|min:0',
        'talla' => 'nullable|string',
        'areas_id' => 'nullable|exists:areas,id',
        'filtros_id' => 'nullable|exists:filtros,id',
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $data = $request->only([
        'nombre', 'descripcion', 'cantidad', 'talla', 'areas_id', 'filtros_id'
    ]);

    if ($request->hasFile('imagen')) {
        $file = $request->file('imagen');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('img'), $filename);
        $data['img_url'] = '/img/' . $filename;
    }

    ElementoPP::create($data);

    return redirect()->route('elementos_pp.index')->with('success', 'Elemento creado.');
}

    public function edit(ElementoPP $elementos_pp)
    {
        $areas = Area::all();
        $filtros = Filtro::all();
        return view('elementos_pp.edit', compact('elementos_pp', 'areas', 'filtros'));
    }

    public function update(Request $request, ElementoPP $elementos_pp)
{
    $request->validate([
        'nombre' => 'required|string|max:45',
        'descripcion' => 'nullable|string',
        'cantidad' => 'required|integer|min:0',
        'talla' => 'nullable|string',
        'areas_id' => 'nullable|exists:areas,id',
        'filtros_id' => 'nullable|exists:filtros,id',
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $data = $request->only([
        'nombre', 'descripcion', 'cantidad', 'talla', 'areas_id', 'filtros_id'
    ]);

    if ($request->hasFile('imagen')) {
        if ($elementos_pp->img_url && file_exists(public_path($elementos_pp->img_url))) {
            unlink(public_path($elementos_pp->img_url));
        }
        $file = $request->file('imagen');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('img'), $filename);
        $data['img_url'] = '/img/' . $filename;
    }

    $elementos_pp->update($data);

    return redirect()->route('elementos_pp.index')->with('success', 'Elemento...) actualizado correctamente.');
}
    public function destroy(ElementoPP $elementos_pp)
    {
        $elementos_pp->delete();
        return redirect()->route('elementos_pp.index')->with('success', 'Elemento eliminado correctamente');
    }
}