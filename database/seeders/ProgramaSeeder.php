<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramaSeeder extends Seeder
{
    public function run()
    {
        $csvFile = base_path("database/csv/programas_fichas_areas.csv");
        $data = array_map("str_getcsv", file($csvFile));
        $header = array_shift($data); // Remove header row

        $processedPrograms = [];

        foreach ($data as $row) {
            if (count($row) < 4) continue; // Skip malformed rows

            $rowData = array_combine($header, $row);

            $areaName = trim($rowData["AREA"]);
            $programName = trim($rowData["NOMBRE_PROGRAMA_FORMACION"]);
            $nivel = trim($rowData["NIVEL"]);

            // Default to "SIN ÁREA DEFINIDA" if area not found or empty
            if (empty($areaName)) {
                $areaName = "SIN ÁREA DEFINIDA";
            }

            $area = DB::table("areas")->where("nombre", $areaName)->first();
            $areaId = $area ? $area->id : null;

            if ($areaId && !isset($processedPrograms[$programName])) {
                DB::table("programas")->insertOrIgnore([
                    "nombre" => $programName,
                    "areas_id" => $areaId,
                    "nivel" => $nivel,
                ]);
                $processedPrograms[$programName] = true;
            }
        }
    }
}
