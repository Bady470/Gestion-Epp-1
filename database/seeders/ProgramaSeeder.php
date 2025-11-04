<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Programa;
use App\Models\Area;

class ProgramaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $programas = [
            [
                'nombre' => 'Análisis y Desarrollo de Software',
                'areas_id' => 1,
            ],
            [
                'nombre' => 'Técnico en Programación',
                'areas_id' => 1,
            ],
            [
                'nombre' => 'Desarrollo de Aplicaciones Móviles',
                'areas_id' => 1 ,
            ],
            [
                'nombre' => 'Auxiliar en Cuidado de Adulto Mayor',
                'areas_id' => 2,
            ],
            [
                'nombre' => 'Técnico en Salud Oral',
                'areas_id' => 2 ,
            ],
            [
                'nombre' => 'Contabilidad y Finanzas',
                'areas_id' => 3,
            ],
            [
                'nombre' => 'Gestión Administrativa',
                'areas_id' => 3,
            ]
            
        ];

        foreach ($programas as $item) {
            Programa::create($item);
        }
    }
}