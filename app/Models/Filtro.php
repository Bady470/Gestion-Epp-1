<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filtro extends Model
{
    use HasFactory;

    protected $table = 'filtros';

    protected $fillable = [
        'parte_del_cuerpo',
    ];

    public function elementos()
    {
        return $this->hasMany(ElementoPP::class, 'filtros_id');
    }
}