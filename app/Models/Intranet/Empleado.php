<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_documento_id',
        'nro_documento',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'fecha_nacimiento',
        'telefono_personal',
        'whatsapp',
        'correo_personal',
        'correo_institucional',
        'departamento_id',
        'sede_id'
    ];

    function sede()
    {
        return $this->belongsTo(Sede::class);
    }
}
