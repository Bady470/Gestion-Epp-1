<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElementoPP extends Model
{
    use HasFactory;

    protected $table = 'elementos_pp';

    protected $fillable = [
        'nombre',
        'descripcion',
        'img_url',
        'cantidad',
        'talla',
        'areas_id',
        'filtros_id',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class, 'areas_id');
    }

    public function filtro()
    {
        return $this->belongsTo(Filtro::class, 'filtros_id');
    }

    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class, 'elementos_x_pedido', 'elementos_pp_id', 'pedidos_id');
    }
}