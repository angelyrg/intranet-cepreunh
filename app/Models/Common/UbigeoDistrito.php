<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UbigeoDistrito extends Model
{
    use HasFactory;

    protected $table = 'ubigeodistrito';

    function provincia()
    {
        return $this->belongsTo(UbigeoProvincia::class, 'provincia');
    }

    function departamento()
    {
        return $this->belongsTo(UbigeoDepartamento::class, 'departamento');
    }
}
