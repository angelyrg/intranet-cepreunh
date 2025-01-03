<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AsistenciaEstudiante extends Model
{
    use SoftDeletes;

    protected $table = 'asistencias_estudiantes';

    protected $fillable = [
        'estudiante_id',
        'matricula_id',
        'ciclo_id',
        'sede_id',
        'usuario_registro_id',
        'estado',
        'entrada',
        'deleted_at',
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function matricula()
    {
        return $this->belongsTo(Matricula::class);
    }

    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class);
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function usuarioRegistro()
    {
        return $this->belongsTo(User::class, 'usuario_registro_id');
    }

}
