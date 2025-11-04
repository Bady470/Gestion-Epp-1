<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'fecha',
        'users_id',
        'fichas_id',
        'estado', 

    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function ficha()
    {
        return $this->belongsTo(Ficha::class, 'fichas_id');
    }

    public function elementos()
    {
        return $this->belongsToMany(ElementoPP::class, 'elementos_x_pedido', 'pedidos_id', 'elementos_pp_id');
    }

    public function solicitudes()
    {
        return $this->belongsToMany(Solicitud::class, 'pedidos_has_solicitudes', 'pedidos_id', 'solicitudes_id');
    }
}