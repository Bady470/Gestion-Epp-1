<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {

        User::firstOrCreate(
            ['email' => 'admin@sena.com'],
            [
                'nombre_completo' => 'Administrador General',
                'password' => Hash::make('12345678'),
                'roles_id' => 1,
            ]
        );

        User::firstOrCreate(
            ['email' => 'instructor@sena.com'],
            [
                'nombre_completo' => 'Instructor Juan',
                'password' => Hash::make('12345678'),
                'roles_id' => '2',
                'areas_id' => 2,
            ]
        );

        User::firstOrCreate(
            ['email' => 'lider@sena.com'],
            [
                'nombre_completo' => 'Líder María',
                'password' => Hash::make('12345678'),
                'roles_id' => '3',
                'areas_id' => 2,
            ]
        );
    }
}
