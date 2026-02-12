<?php

namespace App\Imports;

use App\Models\Programa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProgramasImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Programa([
            'nombre'    => $row['nombre'],
            'areas_id'  => $row['areas_id'],
        ]);
    }
}
