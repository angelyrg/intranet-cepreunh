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
        'aula_actual_id',
        'usuario_registro_id'
    ];

    const MODALIDADES_ESTUDIO = ['Presencial', 'Virtual'];
    const CONDICIONES_ACADEMICAS = ['Egresado', '5to Secundaria', '4to Secundaria', '3to Secundaria', '2to Secundaria', '1ro Secundaria'];

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

    public function aula()
    {
        return $this->belongsTo(Aula::class, 'aula_actual_id', 'id');
    }

    public function aula_actual()
    {
        return $this->belongsTo(Aula::class, 'aula_actual_id', 'id');
    }

    public function aulas()
    {
        return $this->belongsToMany(AulaCiclo::class, 'aula_matricula', 'matricula_id', 'aula_ciclo_id');
    }

    public function aulas_matriculas()
    {
        return $this->hasMany(AulaMatricula::class, 'matricula_id');
    }

    public function entregas(){
        return $this->hasMany(Entrega::class, 'matricula_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($matricula) {
            $matricula->uuid = (string) Str::uuid(); // Genera un UUID
        });
    }

    protected static function booted()
    {
        static::deleting(function ($matricula) {
            // Soft delete de los pagos relacionados
            $matricula->pagos->each(function ($pago) {
                $pago->delete();
            });

            $matricula->entregas->each(function ($entrega) {
                $entrega->delete();
            });
        });

        static::restoring(function ($matricula) {
            // Restaurar los pagos relacionados
            $matricula->pagos()->withTrashed()->each(function ($pago) {
                $pago->restore();
            });
            
            $matricula->entregas()->withTrashed()->each(function ($entrega) {
                $entrega->restore();
            });
        });
    }

}
