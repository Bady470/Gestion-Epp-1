<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new User([
            'nombre_completo' => $row['nombre_completo'],
            'email'           => $row['email'],
            'password'        => Hash::make($row['password']),
            'roles_id'        => $row['roles_id'],
            'areas_id'        => $row['areas_id'],
        ]);
    }
}
