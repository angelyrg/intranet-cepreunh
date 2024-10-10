<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Matricula extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'ciclo_id',
        'estudiante_id',
        'area_id',
        'carrera_id',
        'sede_id',
        'turno',
        'estado',
        'uuid'
    ];


    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class, 'ciclo_id');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'matricula_id');
    }
    
    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($matricula) {
            $matricula->uuid = (string) Str::uuid(); // Genera un UUID
        });
    }
}
