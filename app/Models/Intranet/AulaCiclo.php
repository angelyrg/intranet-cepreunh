<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AulaCiclo extends Model
{
    use HasFactory;

    protected $table = 'aula_ciclo';

    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }

    public function aulas_matriculas(){
        return $this->hasMany(AulaMatricula::class, 'aula_ciclo_id');
    }

}
