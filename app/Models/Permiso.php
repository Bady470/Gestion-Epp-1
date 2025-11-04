<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    use HasFactory;

    protected $table = 'permisos';

    protected $fillable = [
        'nombre',
    ];

    // Un permiso puede pertenecer a muchos roles
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permisos_x_rol', 'permisos_id', 'roles_id');
    }
}