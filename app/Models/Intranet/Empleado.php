<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Empleado extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'empleados';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tipo_documento_id',
        'nro_documento',
        'nombres',
        'apellido_paterno',
        'apellido_materno', 
        'telefono_personal',
        'whatsapp',
        'correo_personal',
        'correo_institucional',
        'departamento_id',
        'sede_id',
        'estado',
        'created_at',
        'updated_at'
    ];      

    public function tipo_documento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento_id');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

    // public function provincia()
    // {
    //     return $this->belongsTo(Provincia::class, 'provincia_id');
    // }
// 
    // public function distrito()
    // {
    //     return $this->belongsTo(Distrito::class, 'distrito_id');
    // }
}
