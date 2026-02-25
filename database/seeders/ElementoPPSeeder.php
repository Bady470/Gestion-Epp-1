<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ElementoPP;
use App\Models\Area;
use App\Models\Filtro;

class ElementoPPSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener relaciones reales (NO usar ID fijo)
        $area1 = Area::where('nombre', 'Agricola')->first();
        $area2 = Area::where('nombre', 'Construcción')->first();
        $area3 = Area::where('nombre', 'Mecánica')->first();

        $filtroCabeza = Filtro::where('parte_del_cuerpo', 'Cabeza')->first();
        $filtroManos = Filtro::where('parte_del_cuerpo', 'Manos')->first();
        $filtroOjos = Filtro::where('parte_del_cuerpo', 'Ojos')->first();
        $filtroPies = Filtro::where('parte_del_cuerpo', 'Pies')->first();

        $elementos = [
            [
                'nombre' => 'Casco de seguridad',
                'descripcion' => 'Casco dieléctrico para protección de la cabeza.',
                'img_url' => 'img/casco.png',
                'cantidad' => 50,
                'talla' => 'UNICA', // No necesita talla
                'areas_id' => $area1?->id,
                'filtros_id' => $filtroCabeza?->id,
            ],
            [
                'nombre' => 'Guantes de cuero',
                'descripcion' => 'Guantes resistentes al calor y abrasión.',
                'img_url' => 'img/guantes.png',
                'cantidad' => 100,
                'talla' => 'M',
                'areas_id' => $area1?->id,
                'filtros_id' => $filtroManos?->id,
            ],
            [
                'nombre' => 'Gafas de protección',
                'descripcion' => 'Gafas transparentes con protección UV.',
                'img_url' => 'img/gafas.png',
                'cantidad' => 80,
                'talla' => 'UNICA',
                'areas_id' => $area2?->id,
                'filtros_id' => $filtroOjos?->id,
            ],
            [
                'nombre' => 'Botas dieléctricas',
                'descripcion' => 'Botas de caucho con suela antideslizante.',
                'img_url' => 'img/botas.png',
                'cantidad' => 60,
                'talla' => '42',
                'areas_id' => $area3?->id,
                'filtros_id' => $filtroPies?->id,
            ],
        ];

        foreach ($elementos as $item) {
            ElementoPP::create($item);
        }
    }
}
