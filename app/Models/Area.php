<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $table = 'areas';

    protected $fillable = [
        'nombre',
    ];

    public function programas()
    {
        return $this->hasMany(Programa::class, 'areas_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'areas_id');
    }

    public function elementos()
    {
        return $this->hasMany(ElementoPP::class, 'areas_id');
    }
}