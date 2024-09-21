<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    use HasFactory;
    
    protected $fillable = ['descripcion','estado'];

    function area(){
        return $this->belongsTo(Area::class);
    }

    public function asignaturaCiclos()
    {
        return $this->hasMany(AsignaturaCiclo::class, 'asignatura_id');
    }

}
