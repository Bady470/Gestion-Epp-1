<?php

namespace App\Imports;

use App\Models\Ficha;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FichasImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Ficha([
            'numero'        => $row['numero'],
            'programas_id'  => $row['programas_id'],
        ]);
    }
}
