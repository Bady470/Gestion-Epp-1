<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Filtro;

class FiltroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filtros = [
            ['parte_del_cuerpo' => 'Cabeza'],
            ['parte_del_cuerpo' => 'Ojos'],
            ['parte_del_cuerpo' => 'Manos'],
            ['parte_del_cuerpo' => 'Pies y Piernas'],
            ['parte_del_cuerpo' => 'Cuerpo completo'],
            ['parte_del_cuerpo' => 'Sistema Respiratorio'],
            ['parte_del_cuerpo' => 'Cara'],
            ['parte_del_cuerpo' => 'Oídos'],
        ];

        foreach ($filtros as $filtro) {
            Filtro::create($filtro);
        }
    }
}
