<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaSeeder extends Seeder
{
    public function run()
    {
        $areas = [
            ["nombre" => "PECUARIA"],
            ["nombre" => "AGRICOLA"],
            ["nombre" => "FIC"],
            ["nombre" => "COMERCIO Y SERVICIOS"],
            ["nombre" => "AGROINDUSTRIA"],
            ["nombre" => "AMBIENTAL"],
            ["nombre" => "TECNOLOGIA"],
            ["nombre" => "CONFECCIONES"],
            ["nombre" => "SIN ÁREA DEFINIDA"],
        ];

        foreach ($areas as $area) {
            DB::table("areas")->insertOrIgnore($area);
        }
    }
}
