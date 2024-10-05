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
        'genero_id',
        'estado_civil_id',
        'fecha_nacimiento',
        'pais_nacimiento',
        'nacionalidad',
        'telefono_personal',
        'whatsapp',
        'correo_personal',
        'correo_institucional',
        'discapacidad',
        'discapacid_detalle',
        'identidad_etnica_id',
        'nacimiento_ubigeodepartamento_id',
        'nacimiento_ubigeoprovincia_id',
        'nacimiento_ubigeodistrito_id',
        'direccion_ubigeodepartamento_id',
        'direccion_ubigeoprovincia_id',
        'direccion_ubigeodistrito_id',
        'direccion',
        'colegio_id',
        'year_culminacion',
        'apoderado_id',
        'estado',
    ];
}
