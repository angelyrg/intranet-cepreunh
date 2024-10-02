<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UbigeoDepartamento extends Model
{
    use HasFactory;

    protected $table = 'ubigeodepartamento';
    protected $keyType = 'string';
    public $incrementing = false;

    function provincias()
    {
        return $this->HasMany(UbigeoProvincia::class, 'departamento');
    }

    function distritos()
    {
        return $this->HasMany(UbigeoDistrito::class, 'departamento');
    }
}
