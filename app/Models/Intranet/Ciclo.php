<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ciclo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['descripcion', 'fecha_inicio', 'fecha_fin', 'duracion', 'tipos_ciclos_id', 'estado', 'deleted_at'];

    public function asignaturaCiclos()
    {
        return $this->hasMany(AsignaturaCiclo::class, 'ciclo_id');
    }

    public function tipo_ciclo(): BelongsTo
    {
        return $this->belongsTo(TiposCiclos::class, 'tipos_ciclos_id', 'id');
    }

    public function getDefaultCiclo()
    {
        $ciclo = Ciclo::where('estado', '1')->orderBy('id', 'desc')->first();
        return $ciclo ? $ciclo->id : 0;
    }

    public function carreras(){
        return $this->belongsToMany(Carrera::class, 'carrera_ciclo');
    }
    
    public function asignaturas(){
        return $this->belongsToMany(Asignatura::class, 'asignatura_ciclo');
    }
    
    public function matriculas(){
        return $this->hasMany(Matricula::class);
    }
    
    public function precios(){
        return $this->hasMany(Precio::class, 'ciclo_id');
    }
 

    // TODO: Agregar las relaciones: Aulas, Semanas

}
