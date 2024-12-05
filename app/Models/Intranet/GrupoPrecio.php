<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoPrecio extends Model
{
    use HasFactory;

    public function carreras()
    {
        return $this->belongsToMany(Carrera::class);
    }

}
