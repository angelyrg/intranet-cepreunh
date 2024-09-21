<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;

    protected $fillable = ['nombres','apellidos','genero','gradoacademico_id','estado'];

    function gradoacademico(){
        return $this->belongsTo(Gradoacademico::class);
    }
}
