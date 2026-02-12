<?php

namespace App\Imports;

use App\Models\ElementoPP;
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
        $rowNumber = $row['__row'] ?? null;  // Número real de la fila del Excel
        $imgPath = null;

        if ($rowNumber) {
            $expectedCell = "C" . $rowNumber;  // ← Imagen debe estar en columna C
        }

        foreach ($this->drawings as $drawing) {
            if ($drawing->getCoordinates() === $expectedCell) {

                // Contenido de la imagen
                $imageContent = file_get_contents($drawing->getPath());
                $extension = $drawing->getExtension();

                // Nombre único
                $filename = 'epp_' . time() . rand(1000, 9999) . '.' . $extension;

                // Guardar imagen en storage/app/public/img
                Storage::disk('public')->put('img/' . $filename, $imageContent);

                // Ruta pública
                $imgPath = '/storage/img/' . $filename;
            }
        }

        return new ElementoPP([
            'nombre'      => $row['nombre'] ?? null,
            'descripcion' => $row['descripcion'] ?? null,
            'cantidad'    => $row['cantidad'] ?? 0,
            'talla'       => $row['talla'] ?? null,
            'areas_id'    => $row['areas_id'] ?? null,
            'filtros_id'  => $row['filtros_id'] ?? null,
            'img_url'     => $imgPath
        ]);
    }
}
