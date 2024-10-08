<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    use HasFactory;

    protected $fillable = ['area_id', 'descripcion', 'estado'];

    function area(){
        return $this->belongsTo(Area::class);
    }

    function CarreraCiclo(){
        return $this->HasMany(CarreraCiclo::class);
    }

}
