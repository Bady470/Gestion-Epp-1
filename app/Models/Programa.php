<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    use HasFactory;

    protected $table = 'programas';

    protected $fillable = [
        'nombre',
        'areas_id',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class, 'areas_id');
    }

    public function fichas()
    {
        return $this->hasMany(Ficha::class, 'programas_id');
    }
}