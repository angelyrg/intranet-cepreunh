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

    public function grupo_precios()
    {
        return $this->belongsToMany(GrupoPrecio::class, 'carreras_grupos', 'carrera_id', 'grupo_id');
    }

}
