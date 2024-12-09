<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormaDePago extends Model
{
    use HasFactory;

    protected $table = 'formas_de_pago';

    public function precios()
    {
        return $this->hasMany(Precio::class, 'forma_de_pago_id');
    }
}
