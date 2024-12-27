<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carrera extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['area_id', 'descripcion', 'estado', 'deleted_at'];

    function area(){
        return $this->belongsTo(Area::class);
    }

    function carrera_ciclo(){
        return $this->HasMany(CarreraCiclo::class);
    }

    public function grupo_precios()
    {
        return $this->belongsToMany(GrupoPrecio::class, 'carreras_grupos', 'carrera_id', 'grupo_id');
    }

}
