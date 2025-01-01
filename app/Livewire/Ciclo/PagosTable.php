<?php

namespace App\Livewire\Ciclo;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Intranet\Sede;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\IncrementColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PagoExport;
use App\Models\Intranet\Banco;
use App\Models\Intranet\FormaDePago;
use App\Models\Intranet\Pago;
use Carbon\Carbon;

class PagosTable extends DataTableComponent
{
    protected $model = Pago::class;
    public ?bool $searchFilterDefer = true; // Añadir .defer
    public ?int $searchFilterDebounce = 300;  // 300 ms

    public $cicloId;
    public $sedeId;
    public $sedespemitidosFiltro;

    public function mount($cicloId = null, $sedeId=null)
    {
        $this->cicloId = (string)$cicloId;
        $this->sedeId = (string)$sedeId;

        if ($sedeId) {
            $this->sedespemitidosFiltro = Sede::where('id', $sedeId)->pluck('descripcion', 'id')->toArray();
        }else{
            $this->sedespemitidosFiltro = Sede::all()->pluck('descripcion', 'id')->toArray();
        }

    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setTableAttributes(['class' => 'table-hover table-striped']);
    }

    public function columns(): array
    {
        return [
            IncrementColumn::make('#'),
            Column::make("ID", "id")->sortable()->searchable(),
            Column::make("N° TRANSACCIÓN", "n_transaccion")->sortable()->searchable(),
            Column::make("DESCRIPCIÓN", "descripcion_pago")->sortable()->searchable(),
            Column::make("COD. OPERACIÓN", "cod_operacion")->sortable()->searchable(),
            Column::make("MONTO", "monto")->sortable()->searchable(),
            Column::make("COMISIÓN", "comision")->sortable()->searchable(),            
            Column::make("MONTO NETO", "monto_neto")->sortable()->searchable(),
            Column::make('FECHA DE PAGO')->label(fn($record) => Carbon::parse($record['fecha_pago'])->format('d/m/Y h:i:sA')),
            Column::make("MODALIDAD DE PAGO", "forma_de_pago.descripcion")->sortable()->searchable(),
            Column::make("BANCO", "banco.descripcion")->sortable()->searchable(),
            Column::make("DNI", "matricula.estudiante.nro_documento")->sortable()->searchable(),
            Column::make("NOMBRES", "matricula.estudiante.nombres")->sortable()->searchable(),
            Column::make("APELLIDO PATERNO", "matricula.estudiante.apellido_paterno")->sortable()->searchable(),
            Column::make("APELLIDO MATERNO", "matricula.estudiante.apellido_materno")->sortable()->searchable(),
            Column::make("CARRERA", "matricula.carrera.descripcion")->sortable()->searchable(),
            Column::make("AREA", "matricula.area.descripcion")->sortable()->searchable(),
            Column::make("SEDE", "matricula.sede.descripcion")->sortable()->searchable(),
            DateColumn::make("FECHA REGISTRO", "created_at")->sortable()->outputFormat('d/m/Y h:i:sA'),
        ];
    }

    public function builder(): Builder
    {
        $query = Pago::query();

        // Filtrar por ciclo_id si está disponible
        if ($this->cicloId) {
            $query->whereHas('matricula', function ($q) {
                $q->where('ciclo_id', $this->cicloId);
            });
        }

        // Filtrar por sede_id si está disponible
        if ($this->sedeId) {
            $query->whereHas('matricula', function ($q) {
                $q->where('sede_id', $this->sedeId);
            });
        }

        return $query;
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Modalidad de pago', 'forma_de_pago_id')
                ->options(['' => 'Todos'] + FormaDePago::all()->pluck('descripcion', 'id')->toArray())
                ->filter(function (Builder $query, $value) {
                    if ($value) {
                        $query->where('forma_de_pago_id', $value);
                    }
                }),
            
            SelectFilter::make('Banco', 'banco_id')
                ->options(['' => 'Todos'] + Banco::all()->pluck('descripcion', 'id')->toArray())
                ->filter(function (Builder $query, $value) {
                    if ($value) {
                        $query->where('banco_id', $value);
                    }
                }),
            
            SelectFilter::make('Sede', 'sede_id')
                ->options(['' => 'Todos'] + $this->sedespemitidosFiltro)
                ->filter(function (Builder $query, $value) {
                    if ($value) {
                        $query->where('matricula.sede_id', $value);
                    }
                }),
            
            DateRangeFilter::make('Fecha de registro', 'created_at')
                ->config([
                    'allowInput' => false,
                    'altFormat' => 'd/m/Y',
                    'ariaDateFormat' => 'd/m/Y',
                    'autocomplete' => 'off',
                    'placeholder' => 'Seleccione las fechas',
                ])
                ->filter(function (Builder $query, array $dateRange) {
                    if ($dateRange['minDate'] && $dateRange['maxDate']) {
                        $query->whereDate('pagos.created_at', '>=', $dateRange['minDate'])
                            ->whereDate('pagos.created_at', '<=', $dateRange['maxDate']);
                    }
                }),

            SelectFilter::make('Modalidad de Matrícula', 'matricula.modalidad_matricula')
                ->options([
                    '' => 'Todos',
                    1 => 'Presencial',
                    2 => 'Virtual',
                ])
                ->filter(function (Builder $query, $value) {
                    if ($value) {
                        $query->where('matricula.modalidad_matricula', $value);
                    }
                }),
        ];
    }


    public function bulkActions(): array
    {
        return [
            'export' => 'Exportar',
        ];
    }

    public function export()
    {
        $selectedIds  = $this->getSelected();

        if (empty($selectedIds)) {
            $pagos = $this->builder()->get();
        } else {
            $pagos = Pago::whereIn('id', $selectedIds)->get();
        }

        $this->clearSelected();

        return Excel::download(new PagoExport($pagos), 'CepreUNH _ pagos.xlsx');
    }


}
