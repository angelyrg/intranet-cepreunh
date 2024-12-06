<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoPrecio extends Model
{
    use HasFactory;

    protected $fillable = ['sede_id', 'ciclo_id' ];

    public function carreras()
    {
        return $this->belongsToMany(Carrera::class, 'carreras_grupos', 'grupo_id', 'carrera_id');
    }
    
    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class);
    }

}
