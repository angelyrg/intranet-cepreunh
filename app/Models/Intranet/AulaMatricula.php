<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AulaMatricula extends Model
{
    use HasFactory;

    protected $table = 'aula_matricula';

    protected $fillable = ['matricula_id', 'aula_ciclo_id', 'estado'];
}
