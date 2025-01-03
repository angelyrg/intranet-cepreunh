<?php

namespace App\Exports;

use App\Models\Intranet\Matricula;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\DB;

class AsistenciaEstudianteExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $asistencias;

    // Recibe las asistencias seleccionadas
    public function __construct($asistencias)
    {
        $this->asistencias = $asistencias;
    }

    // Devuelve la colección de asitencias, que ya debe estar filtrada
    public function collection()
    {
        return $this->asistencias;
    }

    public function headings(): array
    {
        return [
            'HORA DE ENTRADA',
            'ESTADO',
            'DNI', 
            'NOMBRES', 
            'APELLIDO PATERNO', 
            'APELLIDO MATERNO', 
            'CARRERA',
            'ÁREA', 
            'SEDE',
            'TELÉFONO PERSONAL', 
            'WHATSAPP', 
            'TELEFONO APODERADO', 
            'CORREO APODERADO', 
            'TUTOR REGISTRO',
        ];
    }

    public function map($asistencia): array
    {

        return [
            $asistencia->entrada ?? '',
            $asistencia->estado == 1 ? 'PRESENTE' : ($asistencia->estado == 2 ? 'TARDE' : 'FALTA'),

            $asistencia->estudiante->nro_documento ?? '',
            $asistencia->estudiante->nombres ?? '',
            $asistencia->estudiante->apellido_paterno ?? '',
            $asistencia->estudiante->apellido_materno ?? '',
            
            $asistencia->matricula->carrera->descripcion ?? '',
            $asistencia->matricula->area->descripcion ?? '',
            $asistencia->sede->descripcion ?? '',
            $asistencia->estudiante->telefono_personal ?? '',
            $asistencia->estudiante->whatsapp ?? '',
            $asistencia->estudiante->apoderado->telefono_apoderado ?? '',
            $asistencia->estudiante->apoderado->correo_apoderado ?? '',
            $asistencia->usuarioRegistro->name ?? '',
        ];
    }
}
