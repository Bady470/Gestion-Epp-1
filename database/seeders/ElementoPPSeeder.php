<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ElementoPP;
use App\Models\Area;
use App\Models\Filtro;

class ElementoPPSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $elementos = [
            [
                'nombre' => 'Casco de seguridad',
                'descripcion' => 'Casco dieléctrico para protección de la cabeza.',
                'img_url' => 'img/casco.png',
                'cantidad' => 50,
                'talla' => 'Única',
                'areas_id' => 1,
                'filtros_id' => 1,
            ],
            [
                'nombre' => 'Guantes de cuero',
                'descripcion' => 'Guantes resistentes al calor y abrasión.',
                'img_url' => 'img/guantes.png',
                'cantidad' => 100,
                'talla' => 'M',
                'areas_id' => 1,
                'filtros_id' => 2,
            ],
            [
                'nombre' => 'Gafas de protección',
                'descripcion' => 'Gafas transparentes con protección UV.',
                'img_url' => 'img/gafas.png',
                'cantidad' => 80,
                'talla' => 'Única',
                'areas_id' => 2,
                'filtros_id' => 1,
            ],
            [
                'nombre' => 'Botas dieléctricas',
                'descripcion' => 'Botas de caucho con suela antideslizante.',
                'img_url' => 'img/botas.png',
                'cantidad' => 60,
                'talla' => '42',
                'areas_id' => 3,
                'filtros_id' => 4,
            ],
        ];

        foreach ($elementos as $item) {
            ElementoPP::create($item);
        }
    }
}