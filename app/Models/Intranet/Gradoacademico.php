<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gradoacademico extends Model
{
    use HasFactory;

    protected $table = 'gradoacademico';
    
    protected $fillable = ['descripcion'];

    function docentes(){
        return $this->HasMany(Docente::class);
    }

}
