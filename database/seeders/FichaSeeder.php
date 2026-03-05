<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ficha;
use Illuminate\Support\Facades\DB;

class FichaSeeder extends Seeder
{
    public function run()
    {
        $csvFile = base_path("database/csv/programas_fichas_areas.csv");
        $data = array_map("str_getcsv", file($csvFile));
        $header = array_shift($data); // Remove header row

        foreach ($data as $row) {
            if (count($row) < 4) continue; // Skip malformed rows

            $rowData = array_combine($header, $row);

            $programName = trim($rowData["NOMBRE_PROGRAMA_FORMACION"]);
            $fichaNumero = trim($rowData["FICHA"]);

            $programa = DB::table("programas")->where("nombre", $programName)->first();
            $programaId = $programa ? $programa->id : null;

            if ($programaId) {
                Ficha::create([
                    "numero" => $fichaNumero,
                    "programas_id" => $programaId,
                ]);
            }
        }
    }
}
