<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Area;

class AreaSeeder extends Seeder
{
    public function run(): void
    {
        $areas = [
            ['nombre' => 'Seguridad Industrial', ],
            ['nombre' => 'Agrícola', ],
            ['nombre' => 'Tecnológica', ],
        ];

        foreach ($areas as $area) {
            Area::create($area);
        }
    }
}