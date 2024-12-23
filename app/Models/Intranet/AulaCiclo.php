<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AulaCiclo extends Model
{
    use HasFactory;

    protected $table = 'aula_ciclo';
    protected $fillable = ['aula_id', 'ciclo_id', 'area_id'];

    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }

    public function aulas_matriculas(){
        return $this->hasMany(AulaMatricula::class, 'aula_ciclo_id');
    }

}
