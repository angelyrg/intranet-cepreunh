<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    use HasFactory;

    protected $table = 'tipos_documentos';

    protected $fillable = [
        'descripcion',
        'estado',
        'created_at',
        'updated_at'
    ];

    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'tipo_documento_id');
    }
}
