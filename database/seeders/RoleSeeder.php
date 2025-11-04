<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['nombre' => 'admin' ],
            ['nombre' => 'instructor'],
            ['nombre' => 'lider']
        ];

        foreach ($roles as $rol) {
            Role::create($rol);
        }
    }
}