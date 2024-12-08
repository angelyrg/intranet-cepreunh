<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    use HasFactory;

    function precios(){
        return $this->HasMany(Precio::class);
    }

    public function grupos_precios()
    {
        return $this->belongsToMany(GrupoPrecio::class, 'precios', 'banco_id', 'grupo_id');
    }
}
