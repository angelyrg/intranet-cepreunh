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
        'banco',
        'comision',
        'monto_neto',
    ];
}
