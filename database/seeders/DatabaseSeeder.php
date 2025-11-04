<?php

namespace Database\Seeders;

use App\Models\Programa;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            AreaSeeder::class,

            UserSeeder::class,
            ProgramaSeeder::class,
            FiltroSeeder::class,
            FichaSeeder::class,

            ElementoPPSeeder::class,
        ]);
    }
}