<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Precio extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sede_id',
        'ciclo_id',
        'area_id',
        'forma_de_pago_id',
        'monto',
        'fraccionado',
        'grupo_id',
        'banco_id'
    ];

    public function forma_de_pago()
    {
        return $this->belongsTo(FormaDePago::class);
    }

    public function banco()
    {
        return $this->belongsTo(Banco::class);
    }

    public function grupo_precio()
    {
        return $this->belongsTo(GrupoPrecio::class, 'forma_de_pago_id');
    }
}
