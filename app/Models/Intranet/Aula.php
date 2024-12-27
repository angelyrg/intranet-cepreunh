<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aula extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['descripcion', 'piso', 'aforo', 'sede_id', 'deleted_at'];


    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function ciclos()
    {
        return $this->belongsToMany(Ciclo::class);
    }

    public function matriculas(){
        return $this->hasMany(Matricula::class, 'aula_actual_id');
    }

}
