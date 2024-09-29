<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estudiante extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'tipo_documento',
        'nro_documento',
        'fecha_nacimiento',
        'pais_nacimiento',
        'nacionalidades',
        'whatsapp',
        'telefono_personal',
        'telefono_apoderado',
        'correo_personal',
        'correo_institucional',

    ];

}
