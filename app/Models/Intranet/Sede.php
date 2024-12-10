<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sede extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['descripcion', 'estado', 'deleted_at'];

    public function empleados()
    {
        return $this->hasMany(Empleado::class);
    }
    
}
