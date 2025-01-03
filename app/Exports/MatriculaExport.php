<?php

namespace App\Exports;

use App\Models\Intranet\Matricula;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\DB;

class MatriculaExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $matriculas;

    // Recibe las matrículas seleccionadas
    public function __construct($matriculas)
    {
        $this->matriculas = $matriculas;
    }

    // Devuelve la colección de matrículas, que ya debe estar filtrada
    public function collection()
    {
        return $this->matriculas;
    }

    public function headings(): array
    {
        return [
            'EstudianteID',
            'DNI',
            'Nombres', 
            'Apellido Paterno', 
            'Apellido Materno', 
            'Género', 
            'MatrículaID',
            'Carrera', 
            'Área', 
            'Sede', 
            'Aula',
            'Modalidad de Estudio', 
            'Condición Académica', 
            'Tel. Personal', 
            'Whatsapp', 
            'Correo Personal', 
            'Correo Institucional', 
            '¿Tiene Discapacidad?', 
            'Modalidad Matrícula', 
            'Fecha de Matrícula',
            'Monto total',
            'Comisión total',
            'Monto neto total',
            'Cantidad de pagos'
        ];
    }

    public function map($matricula): array
    {
        $totalMonto = $matricula->pagos->sum('monto');
        $totalComision = $matricula->pagos->sum('comision');
        $totalMontoNeto = $matricula->pagos->sum('monto_neto');
        $cantidadPagos = $matricula->pagos->count();

        return [
            $matricula->estudiante->id ?? '',
            $matricula->estudiante->nro_documento ?? '',
            $matricula->estudiante->nombres ?? '',
            $matricula->estudiante->apellido_paterno ?? '',
            $matricula->estudiante->apellido_materno ?? '',
            $matricula->estudiante->genero->descripcion ?? '',
            $matricula->id ?? '',
            $matricula->carrera->descripcion ?? '',
            $matricula->area->descripcion ?? '',
            $matricula->sede->descripcion ?? '',
            $matricula->aula_actual->descripcion ?? '',
            $matricula->modalidad_estudio,
            $matricula->condicion_academica,
            $matricula->estudiante->telefono_personal ?? '',
            $matricula->estudiante->whatsapp ?? '',
            $matricula->estudiante->correo_personal ?? '',
            $matricula->estudiante->correo_institucional ?? '',
            ($matricula->estudiante->tiene_discapacidad ?? false) ? 'Sí' : 'No',
            $matricula->modalidad_matricula == 1 ? 'Presencial' : ($matricula->modalidad_matricula == 2 ? 'Virtual' : 'Desconocido'),
            $matricula->created_at->format('d/m/Y h:i:sA'),
            $totalMonto,
            $totalComision,
            $totalMontoNeto,
            $cantidadPagos,
        ];
    }
}
