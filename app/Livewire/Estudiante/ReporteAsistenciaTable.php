<?php

namespace App\Livewire\Estudiante;

use App\Models\Intranet\Area;
use App\Models\Intranet\Ciclo;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Intranet\Matricula;
use App\Models\Intranet\Sede;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\IncrementColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MatriculaExport;
use App\Models\Intranet\AsistenciaEstudiante;
use App\Models\Intranet\Estudiante;
use App\Models\Intranet\Genero;
use Carbon\Carbon;
use Livewire\Attributes\On;

class ReporteAsistenciaTable extends DataTableComponent
{
    protected $model = AsistenciaEstudiante::class;
    public ?bool $searchFilterDefer = true; // Añadir .defer
    public ?int $searchFilterDebounce = 300;  // 300 ms

    public string $emptyMessage = 'No se encontraron registros de asistencias para tu búsqueda';


    public $cicloId;
    public $sedeId;
    public $carrerasDelCicloFiltro;
    public $sedespemitidosFiltro;


    public function mount($sedeId=null)
    {
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
        $this->setTableAttributes(['class' => 'table-hover']);
        // $this->setExportable(true);
    }

    public function columns(): array
    {
        return [
            IncrementColumn::make('#'),

            Column::make('Entrada', 'entrada')->sortable(),
            Column::make("Estado", 'estado')
                ->sortable()
                ->searchable()
                ->format(function ($value) {
                    return $value == 1 ? 'Presente' : ($value == 2 ? 'Tarde' : 'Falta');
                }),
            Column::make("DNI", "estudiante.nro_documento")->sortable()->searchable(),
            Column::make("Nombres", "estudiante.nombres")->sortable()->searchable(),
            Column::make("Apellido paterno", "estudiante.apellido_paterno")->sortable()->searchable(),
            Column::make("Apellido materno", "estudiante.apellido_materno")->sortable()->searchable(),
            Column::make("Carrera", "matricula.carrera.descripcion")->sortable()->searchable(),
            Column::make("Área", "matricula.area.descripcion")->sortable()->searchable(),
            Column::make("Tel. Personal", "estudiante.telefono_personal")->sortable()->searchable(),
            Column::make("Whatsapp", "estudiante.whatsapp")->sortable()->searchable(),
            Column::make("Tel. Apoderado", "estudiante.apoderado.telefono_apoderado")->sortable()->searchable(),
        ];
    }

    public function filters(): array
    {
        return [
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
                        $query->whereDate('asistencias_estudiantes.created_at', '>=', $dateRange['minDate'])
                            ->whereDate('asistencias_estudiantes.created_at', '<=', $dateRange['maxDate']);
                    }
                }),
            SelectFilter::make('Sede', 'sede_id')
                ->options(['' => 'Todos'] + $this->sedespemitidosFiltro)
                ->filter(function (Builder $query, $value) {
                    if ($value) {
                        $query->where('sede_actual_id', $value);
                    }
                }),
        ];
    }


    public function builder(): Builder
    {
        $query = AsistenciaEstudiante::query()
            ->withCount('estudiante', 'matricula');

        if ($this->sedeId) {
            $query->where('asistencias_estudiantes.sede_id', $this->sedeId);
        }

        return $query;
    }


    // public function bulkActions(): array
    // {
    //     return [
    //         'export' => 'Export',
    //     ];
    // }

    // public function export()
    // {
    //     $selectedIds  = $this->getSelected();

    //     if (empty($selectedIds)) {
    //         $estudiantes = $this->builder()->get();
    //     } else {
    //         $estudiantes = Estudiante::whereIn('id', $selectedIds)->get();
    //     }

    //     $this->clearSelected();

    //     return Excel::download(new MatriculaExport($estudiantes), 'matriculas.xlsx');
    // }

}
