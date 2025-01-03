<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Model;

class HorarioEstudiante extends Model
{
    protected $table = 'horario_estudiantes';

    protected $fillable = [
        'sede_id',
        'ciclo_id',
        'presente_inicio',
        'presente_fin',
        'tarde_inicio',
        'tarde_fin',
    ];

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class);
    }

}
