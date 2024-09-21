<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignaturaCiclo extends Model
{
    use HasFactory;

    protected $table = 'asignatura_ciclo';

    protected $fillable = ['ciclo_id', 'asignatura_id', 'estado'];

    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class, 'ciclo_id');
    }
    
    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class, 'asignatura_id');
    }

}
