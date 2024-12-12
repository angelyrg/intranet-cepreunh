<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discapacidad extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'discapacidades';

    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class, 'estudiante_discapacidad', 'estudiante_id', 'discapacidad_id');
    }
}
