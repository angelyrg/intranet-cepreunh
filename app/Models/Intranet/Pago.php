<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pago extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'matricula_id',
        'monto',
        'cod_operacion',
        'descripcion_pago',
        'fecha_pago',
        'n_transaccion',
        'banco_id',
        'comision',
        'monto_neto',
        'condicion_pago',
        'forma_de_pago_id',
    ];

    const CONDICIONES_PAGO = ['Cancelado', 'Parcial'];

    public function banco()
    {
        return $this->belongsTo(Banco::class);
    }

    public function forma_de_pago()
    {
        return $this->belongsTo(FormaDePago::class);
    }

    public function matricula()
    {
        return $this->belongsTo(Matricula::class, 'matricula_id');
    }
}
