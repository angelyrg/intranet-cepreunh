<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entrega extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'material_entregable_id',
        'matricula_id',
        'ciclo_id',
        'sede_id',
        'usuario_registro_id',
        'estado',
        'deleted_at',
    ];

    // estado -> 1:Entregado

    public function material_entregable()
    {
        return $this->belongsTo(MaterialEntregable::class);
    }

    public function matricula()
    {
        return $this->belongsTo(Matricula::class);
    }

    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class);
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function usuarioRegistro()
    {
        return $this->belongsTo(User::class, 'usuario_registro_id');
    }

}
