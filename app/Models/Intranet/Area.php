<?php

namespace App\Models\Intranet;

use App\Models\intranet\Carrera;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = ['descripcion', 'estado'];

    function carreras(){
        return $this->HasMany(Carrera::class);
    }

    function asignaturas(){
        return $this->hasMany(Asignatura::class);
    }

}
