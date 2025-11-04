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

        User::create([
            'nombre_completo' => 'Administrador General',
            'email' => 'admin@sena.com',
            'password' => Hash::make('12345678'),
            'roles_id' => 1,
        ]);

        User::create([
            'nombre_completo' => 'Instructor Juan',
            'email' => 'instructor@sena.com',
            'password' => Hash::make('12345678'),
            'roles_id' => '2',
            'areas_id' => 2,
        ]);

        User::create([
            'nombre_completo' => 'Líder María',
            'email' => 'lider@sena.com',
            'password' => Hash::make('12345678'),
            'roles_id' => '3',
            'areas_id' => 1,
        ]);
    }
}