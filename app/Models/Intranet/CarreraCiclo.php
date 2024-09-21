<?php

namespace App\Models\Intranet;

use App\Models\intranet\Carrera;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarreraCiclo extends Model
{
    use HasFactory;

    protected $table = 'carrera_ciclo';

    protected $fillable = ['ciclo_id', 'carrera_id', 'estado'];

    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class, 'ciclo_id');
    }
    
    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }


}
