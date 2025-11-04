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
            ['parte_del_cuerpo' => 'Ojos y rostro'],
            ['parte_del_cuerpo' => 'Manos'],
            ['parte_del_cuerpo' => 'Pies'],
            ['parte_del_cuerpo' => 'Cuerpo completo'],
            ['parte_del_cuerpo' => 'Vías respiratorias'],
            ['parte_del_cuerpo' => 'Oídos'],
        ];

        foreach ($filtros as $filtro) {
            Filtro::create($filtro);
        }
    }
}