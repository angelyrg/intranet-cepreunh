<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apoderado extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tipo_documento_id',
        'nro_documento',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        
        'telefono_apoderado',
        'correo_apoderado',
        'parentesco_id'
    ];
    
    public function tipo_documento(){
        return $this->belongsTo(TipoDocumento::class);
    }

    public function parentesco()
    {
        return $this->belongsTo(Parentesco::class);
    }

}
