<?php

namespace App\Models\intranet;

use App\Models\Intranet\Area;
use App\Models\Intranet\CarreraCiclo;
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
