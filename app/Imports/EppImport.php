<?php

namespace App\Imports;

use App\Models\Area;
use App\Models\ElementoPP;
use App\Models\Filtro;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class EppImport implements ToModel, WithHeadingRow, WithDrawings
{
    private $drawings = [];

    // Excel guarda las imágenes aquí automáticamente
    public function drawings()
    {
        return $this->drawings;
    }

    public function registerDrawing(Drawing $drawing)
    {
        $this->drawings[] = $drawing;
    }

public function model(array $row)
{
   $areaExcel = trim(strtolower($row['areas'] ?? ''));
    $filtroExcel = trim(strtolower($row['partes_del_cuerpo'] ?? ''));

    $area = Area::whereRaw('LOWER(nombre) = ?', [$areaExcel])->first();

    $filtro = Filtro::whereRaw('LOWER(parte_del_cuerpo) = ?', [$filtroExcel])->first();

    return new ElementoPP([
        'nombre'      => trim($row['nombre'] ?? ''),
        'descripcion' => trim($row['descripcion'] ?? ''),
        'cantidad'    => (int) ($row['cantidad'] ?? 0),
        'talla'       => trim($row['talla'] ?? ''),
        'areas_id'    => $area?->id,
        'filtros_id'  => $filtro?->id,
        'img_url'     => $imgPath = $row[''] ?? null,
    ]);
}
}
