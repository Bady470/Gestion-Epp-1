<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Area;

class AreaSeeder extends Seeder
{
    public function run(): void
    {
        $areas = [
            ['nombre' => 'Pecuaria'],
            ['nombre' => 'Agricola'],
            ['nombre' => 'Acuicola'],
            ['nombre' => 'FIC'],
            ['nombre' => 'Comercio y servicios'],
            ['nombre' => 'Agroindustria'],
            ['nombre' => 'Hoteleria Y Turismo'],
            ['nombre' => 'Ambiental'],
            ['nombre' => 'Tecnologia'],
            ['nombre' => 'Confecciones'],
            ['nombre' => 'Cultura'],
        ];

        foreach ($areas as $area) {
            Area::create($area);
        }
    }
}
