<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElementoXPedido extends Model
{
    use HasFactory;

    protected $table = 'elementos_x_pedido';
    protected $fillable = ['pedidos_id', 'elementos_pp_id'];
}