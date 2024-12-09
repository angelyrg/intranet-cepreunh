<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiposUsuarios extends Model
{
    use HasFactory;

    protected $table = 'tipos_usuarios';
    protected $fillable = ['descripcion'];

    public function usuarios()
    {
        return $this->hasMany(User::class, 'tipo_usuario_id');
    }
}
