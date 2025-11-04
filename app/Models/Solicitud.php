<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;

    protected $table = 'solicitudes';

    protected $fillable = [
        'descripcion',
    ];

    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class, 'pedidos_has_solicitudes', 'solicitudes_id', 'pedidos_id');
    }
}