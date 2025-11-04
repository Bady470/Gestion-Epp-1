<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ficha extends Model
{
    use HasFactory;

    protected $table = 'fichas';

    protected $fillable = [
        'numero',
        'programas_id',
    ];

    public function programa()
    {
        return $this->belongsTo(Programa::class, 'programas_id');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'fichas_id');
    }
}