<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialEntregable extends Model
{
    use SoftDeletes;

    protected $table = 'materiales_entregables';

    protected $fillable = [
        'descripcion',
        'deleted_at',
    ];

    public function entregas()
    {
        return $this->hasMany(Entrega::class, 'material_entregable_id');
    }
}
