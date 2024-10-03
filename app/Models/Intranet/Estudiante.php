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
        'tipo_documento_id',
        'nro_documento',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'fecha_nacimiento',
        'pais_nacimiento',
        'nacionalidad',
        'telefono_personal',
        'whatsapp',
        'correo_personal',
        'correo_institucional',
        'ubigeodepartamento_id',
        'ubigeoprovincia_id',
        'ubigeodistrito_id',
        'direccion',
        'colegio_id',
        'year_culminacion',
        'apoderado_id',
        'estado',
    ];
}
