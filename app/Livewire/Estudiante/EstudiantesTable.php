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
use App\Models\Intranet\Estudiante;
use App\Models\Intranet\Genero;
use Carbon\Carbon;

class EstudiantesTable extends DataTableComponent
{
    protected $model = Estudiante::class;
    public ?bool $searchFilterDefer = true; // Añadir .defer
    public ?int $searchFilterDebounce = 300;  // 300 ms

    public string $emptyMessage = 'No se encontraron resultados para tu búsqueda';
    public string $filterLabel = 'Filtrar';
    public string $columnsLabel = 'Columnas';
    public string $showingLabel = 'Mostrando :from a :to de :total entradas';
    public string $noResultsLabel = 'No se encontraron resultados';
    public string $clearFiltersLabel = 'Borrar filtros';
    public string $searchLabel = 'Buscar...';
    public string $selectedLabel = 'Seleccionado';


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
        // $this->setDebugStatus(true);
    }

    public function columns(): array
    {
        return [
            IncrementColumn::make('#'),

            ButtonGroupColumn::make('ACCIONES', 'id')
            ->attributes(function ($row) {
                return [
                    'class' => 'd-flex gap-2',
                ];
            })
                ->buttons([
                    LinkColumn::make('View', 'id')
                        ->title(fn($row) => '<i class="ti ti-eye fs-5"></i>')
                        ->location(fn($row) => route('estudiante.show', $row))
                        ->attributes(fn($row)  => [
                            'class' => 'text-info',
                            'alt' => 'Ver detalles',
                            'title' => 'Ver detalles'
                        ])->html(),
                    LinkColumn::make('Editar', 'id')
                        ->title(fn($row) => '<i class="ti ti-edit fs-5"></i>')
                        ->location(fn($row) => route('estudiante.edit', $row))
                        ->attributes(fn($row)  => [
                            'class' => 'text-info',
                            'alt' => 'Editar',
                            'title' => 'Editar'
                        ])->html(),
                    // LinkColumn::make('Eliminar', 'id')
                    //     ->title(fn($row) => '<i class="ti ti-trash fs-5"></i>')
                    //     ->location(fn($row) => '#') TODO: Eliminar estudiante
                    //     ->attributes(fn($row)  => [
                    //         'class' => 'text-danger',
                    //         'alt' => 'Editar',
                    //         'title' => 'Editar'
                    //     ])->html(),
                ]),

            Column::make("DNI", "nro_documento")->sortable()->searchable(),
            Column::make("NOMBRES", "nombres")->sortable()->searchable(),
            Column::make("APELLIDO PATERNO", "apellido_paterno")->sortable()->searchable(),
            Column::make("APELLIDO MATERNO", "apellido_materno")->sortable()->searchable(),
            Column::make("GÉNERO", "genero.descripcion")->sortable()->searchable(),
            Column::make("ESTADO CIVIL", "estado_civil.descripcion")->sortable()->searchable(),
            Column::make("EDAD", "fecha_nacimiento")
                ->label(fn($row) => Carbon::parse($row->fecha_nacimiento)->age)
                ->sortable(),
            Column::make("FECHA NAC.", "fecha_nacimiento")
                ->sortable()
                ->searchable()
                ->label(function ($row) {
                    return Carbon::parse($row->fecha_nacimiento)->format('d/m/Y');
                }),
            
            Column::make('MATRÍCULAS')
                ->label(function ($row) {
                    return '<a href="' . route('estudiante.show', $row->id) . '" class="text-decoration-underline">Ver(' . $row->matriculas_count . ')</a>';
                })
                ->sortable()
                ->html(),

            Column::make("WHATSAPP", "whatsapp")->sortable()->searchable(),
            Column::make("CORREO PERSONAL", "correo_personal")->sortable()->searchable(),
            Column::make("CORREO INSTITUCIONAL", "correo_institucional")->sortable()->searchable(),
            BooleanColumn::make("¿TIENE DISCAPACIDAD?", "tiene_discapacidad")->sortable(),
            
            DateColumn::make('FECHA DE REGISTRO', 'created_at')->sortable()->outputFormat('d/m/Y h:i:sA'),
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
                        $query->whereDate('created_at', '>=', $dateRange['minDate'])
                            ->whereDate('created_at', '<=', $dateRange['maxDate']);
                    }
                }),
            SelectFilter::make('Género', 'genero_id')
                ->options(['' => 'Todos'] + Genero::all()->pluck('descripcion', 'id')->toArray())
                ->filter(function (Builder $query, $value) {
                    if ($value) {
                        $query->where('genero_id', $value);
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
        $query = Estudiante::query()
            ->withCount('matriculas');

        if ($this->sedeId) {
            $query->where('sede_actual_id', $this->sedeId);
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
