<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramaSeeder extends Seeder
{
    public function run()
    {
        $programas = [
            [
                'nombre' => 'PRODUCCION DE MULTIMEDIA',
                'areas_id' => 7,
                'nivel' => 'TECNÓLOGO',
            ],
            [
                'nombre' => 'GESTIÓN EMPRESARIAL',
                'areas_id' => 4,
                'nivel' => 'TECNÓLOGO',
            ],
            [
                'nombre' => 'GESTION CONTABLE Y DE INFORMACION FINANCIERA',
                'areas_id' => 4,
                'nivel' => 'TECNÓLOGO',
            ],
            [
                'nombre' => 'COORDINACION EN SISTEMAS INTEGRADOS DE GESTION',
                'areas_id' => 4,
                'nivel' => 'TECNÓLOGO',
            ],
            [
                'nombre' => 'BISUTERIA ARTESANAL.',
                'areas_id' => 9,
                'nivel' => 'OPERARIO',
            ],
            [
                'nombre' => 'ANALISIS Y DESARROLLO DE SOFTWARE.',
                'areas_id' => 7,
                'nivel' => 'TECNÓLOGO',
            ],
            [
                'nombre' => 'OPERACION DE MAQUINARIA AGRICOLA',
                'areas_id' => 2,
                'nivel' => 'TÉCNICO',
            ],
            [
                'nombre' => 'EMPRENDIMIENTO Y FOMENTO EMPRESARIAL',
                'areas_id' => 9,
                'nivel' => 'TÉCNICO',
            ],
            [
                'nombre' => 'PRODUCCIÓN DE ESPECIES MENORES',
                'areas_id' => 1,
                'nivel' => 'TECNÓLOGO',
            ],
            [
                'nombre' => 'PRODUCCIÓN AGROPECUARIA ECOLÓGICA',
                'areas_id' => 6,
                'nivel' => 'TECNÓLOGO',
            ],
            [
                'nombre' => 'AGROTRONICA',
                'areas_id' => 9,
                'nivel' => 'TÉCNICO',
            ],
            [
                'nombre' => 'ELABORACION DE PRODUCTOS ALIMENTICIOS.',
                'areas_id' => 9,
                'nivel' => 'TÉCNICO',
            ],
            [
                'nombre' => 'INSTALACIONES HIDRAULICAS Y SANITARIAS EN EDIFICACIONES RESIDENCIALES Y COMERCIALES.',
                'areas_id' => 3,
                'nivel' => 'TÉCNICO',
            ],
            [
                'nombre' => 'SISTEMAS AGROPECUARIOS ECOLOGICOS.',
                'areas_id' => 6,
                'nivel' => 'TÉCNICO',
            ],
            [
                'nombre' => 'PROMOTOR DE SALUD',
                'areas_id' => 9,
                'nivel' => 'AUXILIAR',
            ],
            [
                'nombre' => 'CONTROL DE CALIDAD EN LA INDUSTRIA DE ALIMENTOS',
                'areas_id' => 5,
                'nivel' => 'TECNÓLOGO',
            ],
            [
                'nombre' => 'COCINA.',
                'areas_id' => 9,
                'nivel' => 'TÉCNICO',
            ],
            [
                'nombre' => 'SANEAMIENTO Y SALUD AMBIENTAL',
                'areas_id' => 9,
                'nivel' => 'TÉCNICO',
            ],
            [
                'nombre' => 'ELABORACION DE PRENDAS DE VESTIR SOBRE MEDIDAS',
                'areas_id' => 8,
                'nivel' => 'TÉCNICO',
            ],
            [
                'nombre' => 'COMUNICACIÓN COMERCIAL',
                'areas_id' => 4,
                'nivel' => 'TECNÓLOGO',
            ],
            [
                'nombre' => 'GESTION DE LA PRODUCCION AGRICOLA',
                'areas_id' => 2,
                'nivel' => 'TECNÓLOGO',
            ],
            [
                'nombre' => 'CONTROL DE CALIDAD EN LA INDUSTRIA DE ALIMENTOS',
                'areas_id' => 9,
                'nivel' => 'TECNÓLOGO',
            ],
            [
                'nombre' => 'PRODUCCIÓN GANADERA',
                'areas_id' => 1,
                'nivel' => 'TECNÓLOGO',
            ],
            [
                'nombre' => 'GESTIÓN DE RECURSOS NATURALES',
                'areas_id' => 6,
                'nivel' => 'TECNÓLOGO',
            ],
            [
                'nombre' => 'MECANIZACIÓN AGRÍCOLA',
                'areas_id' => 2,
                'nivel' => 'TECNÓLOGO',
            ],
            [
                'nombre' => 'GESTION DE PROYECTOS DE DESARROLLO ECONOMICO Y SOCIAL',
                'areas_id' => 9,
                'nivel' => 'TECNÓLOGO',
            ],
        ];

        DB::table('programas')->insert($programas);
    }
}
