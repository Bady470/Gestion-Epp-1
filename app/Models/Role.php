<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
        'nombre',
    ];

    // Un rol puede tener muchos usuarios
    public function users()
    {
        return $this->hasMany(User::class, 'roles_id');
    }

    // Un rol puede tener muchos permisos (relación muchos a muchos)
    public function permisos()
    {
        return $this->belongsToMany(Permiso::class, 'permisos_x_rol', 'roles_id', 'permisos_id');
    }
}