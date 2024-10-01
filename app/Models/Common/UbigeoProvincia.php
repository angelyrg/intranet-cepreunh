<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UbigeoProvincia extends Model
{
    use HasFactory;

    protected $table = 'ubigeoprovincia';

    function distritos()
    {
        return $this->HasMany(UbigeoDistrito::class, 'provincia');
    }

    function departamento()
    {
        return $this->belongsTo(UbigeoDepartamento::class, 'departamento');
    }
}
