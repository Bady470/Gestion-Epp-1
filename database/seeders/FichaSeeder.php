<?php

namespace Database\Seeders;

use App\Models\Ficha;
use Illuminate\Database\Seeder;

class FichaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asegúrate de que existan programas en la tabla 'programas'
        // Si no, crea algunos o usa IDs existentes

        Ficha::create([
            'numero' => '2588110',
            'programas_id' => 1, // Asegúrate de que exista este programa
        ]);

        Ficha::create([
            'numero' => '2588111',
            'programas_id' => 2,
        ]);

        Ficha::create([
            'numero' => '2588112',
            'programas_id' => 3,
        ]);

        Ficha::create([
            'numero' => '2588113',
            'programas_id' => 4,
        ]);

        Ficha::create([
            'numero' => '2588114',
            'programas_id' => 5,
        ]);

        Ficha::create([
            'numero' => '2588115',
            'programas_id' => 6,
        ]);
    }
}