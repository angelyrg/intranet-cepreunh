<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AulaMatricula extends Model
{
    use HasFactory;

    protected $table = 'aula_matricula';

    protected $fillable = ['matricula_id', 'aula_ciclo_id', 'estado'];

    public function aula_ciclo()
    {
        return $this->belongsTo(AulaCiclo::class, 'aula_ciclo_id');
    }
}
