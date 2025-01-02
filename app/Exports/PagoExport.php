<?php

namespace App\Exports;

use App\Models\Intranet\Matricula;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\DB;

class PagoExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $pagos;

    public function __construct($pagos)
    {
        $this->pagos = $pagos;
    }

    public function collection()
    {
        return $this->pagos;
    }

    public function headings(): array
    {
        return [
            'PAGOID',
            'N° TRANSACCIÓN',
            'DESCRIPCIÓN',
            'COD. OPERACIÓN',
            'MONTO',
            'COMISIÓN',
            'MONTO NETO',
            'FECHA DE PAGO',
            'MODALIDAD DE PAGO',
            'BANCO',
            'DNI',
            'NOMBRES',
            'APELLIDO PATERNO',
            'APELLIDO MATERNO',
            'CARRERA',
            'AREA',
            'SEDE',
            'FECHA REGISTRO',
        ];
    }

    public function map($pago): array
    {
        return [
            $pago->id ?? '',
            $pago->n_transaccion ?? '',
            $pago->descripcion_pago ?? '',
            $pago->cod_operacion ?? '',
            $pago->monto ?? '',
            $pago->comision ?? '',
            $pago->monto_neto ?? '',
            $pago->fecha_pago ?? '',
            $pago->forma_de_pago->descripcion ?? '',
            $pago->banco->descripcion ?? '',
            $pago->matricula->estudiante->nro_documento ?? '',
            $pago->matricula->estudiante->nombres ?? '',
            $pago->matricula->estudiante->apellido_paterno ?? '',
            $pago->matricula->estudiante->apellido_materno ?? '',
            $pago->matricula->carrera->descripcion ?? '',
            $pago->matricula->area->descripcion ?? '',
            $pago->matricula->sede->descripcion ?? '',
            $pago->created_at ? $pago->created_at->format('d/m/Y h:i:sA') : '',
        ];
    }
}
