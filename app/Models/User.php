<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * Los atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'nombre_completo',
        'email',
        'password',
        'roles_id',
        'areas_id',
    ];

    /**
     * Los atributos que deben ocultarse para la serialización.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * IMPORTANTE: Indica a Laravel el nombre de la columna para el "Remember Me".
     * Esto asegura que el token se guarde correctamente en la base de datos.
     */
    protected $rememberTokenName = 'remember_token';

    // Relaciones
    public function rol()
    {
        return $this->belongsTo(Role::class, 'roles_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'areas_id');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'users_id');
    }

    /**
     * Los atributos que deben ser convertidos.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
