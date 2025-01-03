<?php

namespace App\Models\Intranet;

use App\Models\Common\Colegio;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estudiante extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'tipo_documento_id',
        'nro_documento',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'genero_id',
        'estado_civil_id',
        'fecha_nacimiento',
        'pais_nacimiento',
        'nacionalidad',
        'telefono_personal',
        'whatsapp',
        'correo_personal',
        'correo_institucional',
        'tiene_discapacidad',
        'discapacidades',
        'identidad_etnica_id',
        'nacimiento_ubigeodistrito_id',
        'direccion_ubigeodistrito_id',
        'direccion',
        'colegio_ubigeodistrito_id',
        'colegio_id',
        'year_culminacion',
        'apoderado_id',
        'sede_actual_id',
        'user_id',
        'estado',
        // 'telefono_apoderado',
        // 'correo_apoderado',
    ];
    
    public function tipo_documento(){
        return $this->belongsTo(TipoDocumento::class);
    }

    public function genero(){
        return $this->belongsTo(Genero::class, 'genero_id');
    }

    public function estado_civil(){
        return $this->belongsTo(EstadoCivil::class, 'estado_civil_id');
    }

    public function identidad_etnica(){
        return $this->belongsTo(IdentidadEtnica::class, 'identidad_etnica_id');
    }
    
    public function colegio(){
        return $this->belongsTo(Colegio::class);
    }

    public function matriculas(){
        return $this->hasMany(Matricula::class);
    }

    public function ciclos(){
        return $this->belongsToMany(Ciclo::class);
    }

    public function discapacidades(){
        return $this->belongsToMany(Discapacidad::class, 'estudiante_discapacidad', 'estudiante_id', 'discapacidad_id');
    }

    public function apoderado()
    {
        return $this->belongsTo(Apoderado::class);
    }
    
    public function sede_actual()
    {
        return $this->belongsTo(Sede::class, 'sede_actual_id');
    }

    protected static function booted()
    {
        static::deleting(function ($estudiante) {
            // Soft delete de las matrículas relacionadas
            $estudiante->matriculas->each(function ($matricula) {
                $matricula->delete();
            });
        });

        static::restoring(function ($estudiante) {
            // Restaurar las matrículas relacionadas
            $estudiante->matriculas()->withTrashed()->each(function ($matricula) {
                $matricula->restore();
            });
        });
    }

}
