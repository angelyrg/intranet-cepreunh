<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Matricula extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'ciclo_id',
        'estudiante_id',
        'area_id',
        'carrera_id',
        'sede_id',
        'modalidad_estudio',
        'modalidad_matricula',
        'condicion_academica',
        'cantidad_matricula',
        'turno',
        'estado',
    ];

    const MODALIDADES_ESTUDIO = ['Presencial', 'Virtual'];
    const CONDICIONES_ACADEMICAS = ['Egresado', '5to Secundaria', '4to Secundaria', 'Estudiante de secundaria'];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class, 'ciclo_id');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'matricula_id');
    }
    
    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class, 'sede_id');
    }

    public function aulas()
    {
        return $this->belongsToMany(AulaCiclo::class, 'aula_matricula', 'matricula_id', 'aula_ciclo_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($matricula) {
            $matricula->uuid = (string) Str::uuid(); // Genera un UUID
        });
    }
}
