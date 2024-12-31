<?php

namespace App\Livewire\Ciclo;

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
use App\Models\Intranet\Aula;
use App\Models\Intranet\AulaCiclo;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class MatriculasTable extends DataTableComponent
{
    protected $model = Matricula::class;
    public ?bool $searchFilterDefer = true; // Añadir .defer
    public ?int $searchFilterDebounce = 300;  // 300 ms

    public string $emptyMessage = 'No se encontraron matrículas para tu búsqueda';
    public string $filterLabel = 'Filtrar';
    public string $columnsLabel = 'Columnas';
    public string $showingLabel = 'Mostrando :from a :to de :total entradas';
    public string $noResultsLabel = 'No se encontraron resultados';
    public string $clearFiltersLabel = 'Borrar filtros';
    public string $searchLabel = 'Buscar...';
    public string $selectedLabel = 'Seleccionado';


    protected $listeners = ['asignacionCarreraActualizada' => 'updateCarreras'];

    public $cicloId;
    public $sedeId;
    public $carrerasDelCicloFiltro;
    public $aulasDelCicloFiltro;
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

        $this->loadCarrerasDelCiclo();
        $this->loadAulasDelCiclo();
    }

    private function loadCarrerasDelCiclo()
    {
        $this->carrerasDelCicloFiltro = Ciclo::find($this->cicloId)
            ->carreras()
            ->select('carreras.descripcion', 'carreras.id')
            ->pluck('descripcion', 'id')
            ->toArray();
    }

    private function loadAulasDelCiclo()
    {
        $this->aulasDelCicloFiltro = Ciclo::find($this->cicloId)
            ->aulas()
            ->where('sede_id', Auth::user()->sede_id)
            ->select('aulas.id', 'aulas.descripcion', 'aulas.aforo')
            ->pluck('aulas.descripcion', 'aulas.id')
            ->toArray();
    }

    public function updateCarreras()
    {
        $this->loadCarrerasDelCiclo();
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
                    ->location(fn($row) => route('matricula.show', $row))
                    ->attributes(fn($row)  => [
                        'class' => 'text-info',
                        'alt' => 'Ver detalles',
                        'title' => 'Ver detalles'
                    ])->html(),
                    LinkColumn::make('View', 'id')
                    ->title(fn($row) => '<i class="ti ti-edit fs-5"></i>')
                    ->location(fn($row) => route('matricula.edit', $row))
                    ->attributes(fn($row)  => [
                        'class' => 'text-info',
                        'alt' => 'Editar matrícula',
                        'title' => 'Editar matrícula'
                    ])->html(),
                    LinkColumn::make('Delete', 'id')
                        ->title(fn($row) => '<i class="ti ti-trash fs-5 text-danger"></i>')
                        ->location(fn($row) => '#')
                        ->attributes(function ($row) {
                            return [
                                'class' => 'text-danger',
                                'alt' => 'Eliminar matrícula',
                                'title' => 'Eliminar matrícula',
                                'onclick' => 'confirmDeletion(' . $row->id . ')',
                            ];
                        })
                        ->html(),
                ]),

            // Column::make('DNI1', "estudiante.nro_documento")->collapseAlways(),

            Column::make("DNI", "estudiante.nro_documento")->sortable()->searchable(),
            Column::make("NOMBRES", "estudiante.nombres")->sortable()->searchable(),
            Column::make("APELLIDO PATERNO", "estudiante.apellido_paterno")->sortable()->searchable(),
            Column::make("APELLIDO MATERNO", "estudiante.apellido_materno")->sortable()->searchable(),
            Column::make("GÉNERO", "estudiante.genero.descripcion")->sortable()->searchable(),
            Column::make("CARRERA", "carrera.descripcion")->sortable()->searchable(),
            Column::make("ÁREA", "area.descripcion")->sortable()->searchable(),
            Column::make("SEDE", "sede.descripcion")->sortable()->searchable(),
            Column::make("AULA", "aula_actual.descripcion")->sortable()->searchable(),
            Column::make("MODALIDAD ESTUDIO", "modalidad_estudio")->sortable()->searchable(),
            Column::make("CONDICION ACADÉMICA", "condicion_academica")->sortable()->searchable(),
            
            Column::make("TEL. PERSONAL", "estudiante.telefono_personal")->sortable()->searchable(),
            Column::make("WHATSAPP", "estudiante.whatsapp")->sortable()->searchable(),
            Column::make("CORREO PERSONAL", "estudiante.correo_personal")->sortable()->searchable(),
            Column::make("CORREO INSTITUCIONAL", "estudiante.correo_institucional")->sortable()->searchable(),
            BooleanColumn::make("¿TIENE DISCAPACIDAD?", "estudiante.tiene_discapacidad")->sortable(),
            
            Column::make("MODALIDAD MATRÍCULA", 'modalidad_matricula')
                ->sortable()
                ->searchable()
                ->format(function ($value) {
                    return $value == 1 ? 'Presencial' : ($value == 2 ? 'Virtual' : 'Desconocido');
                }),

            DateColumn::make('FECHA DE MATRÍCULA', 'created_at')->sortable()->outputFormat('d/m/Y h:i:sA'),

            Column::make('Monto total')
            ->label(function ($row) {
                $totalPagos = $row->pagos->sum('monto');
                return 'S/' . number_format($totalPagos, 2);
            })
                ->sortable()
                ->searchable(),
            Column::make('Comisión total')
                ->label(function ($row) {
                    $totalPagos = $row->pagos->sum('comision');
                    return 'S/' . number_format($totalPagos, 2);
                })
                ->sortable()
                ->searchable(),
            Column::make('Monto neto total')
            ->label(function ($row) {
                $totalPagos = $row->pagos->sum('monto_neto');
                return 'S/' . number_format($totalPagos, 2);
            })
                ->sortable()
                ->searchable(),
            Column::make('Cantidad de pagos')
            ->label(function ($row) {
                return $row->pagos->count();
            })
                ->sortable()
                ->searchable(),
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Área', 'area_id')
                ->options(['' => 'Todos'] + Area::all()->pluck('descripcion', 'id')->toArray())
                ->filter(function (Builder $query, $value) {
                    if ($value) {
                        $query->where('matriculas.area_id', $value);
                    }
                }),
            SelectFilter::make('Carrera', 'carrera_id')
                    ->options(['' => 'Todos'] + $this->carrerasDelCicloFiltro)
                    ->filter(function (Builder $query, $value) {
                        if ($value) {
                            $query->where('matriculas.carrera_id', $value);
                        }
                    }),
            SelectFilter::make('Sede', 'sede_id')
                ->options(['' => 'Todos'] + $this->sedespemitidosFiltro)
                    ->filter(function (Builder $query, $value) {
                        if ($value) {
                            $query->where('matriculas.sede_id', $value);
                        }
                    }),
            SelectFilter::make('Aula', 'aula_actual_id')
                ->options(['' => 'Todos'] + $this->aulasDelCicloFiltro)
                    ->filter(function (Builder $query, $value) {
                        if ($value) {
                            $query->where('matriculas.aula_actual_id', $value);
                        }
                    }),
            DateRangeFilter::make('Fecha de matrícula', 'created_at')
                ->config([
                    'allowInput' => false,
                    'altFormat' => 'd/m/Y',
                    'ariaDateFormat' => 'd/m/Y',
                    'autocomplete' => 'off',
                    'placeholder' => 'Seleccione las fechas',
                ])
                ->filter(function (Builder $query, array $dateRange) {
                    if ($dateRange['minDate'] && $dateRange['maxDate']) {
                        $query->whereDate('matriculas.created_at', '>=', $dateRange['minDate'])
                            ->whereDate('matriculas.created_at', '<=', $dateRange['maxDate']);
                    }
                }),

            SelectFilter::make('Modalidad de estudio', 'modalidad_estudio')
                ->options(['' => 'Todos'] + array_combine(Matricula::MODALIDADES_ESTUDIO, array_map(fn($item) => $item, Matricula::MODALIDADES_ESTUDIO)))
                ->filter(function (Builder $query, $value) {
                    if ($value) {
                        $query->where('modalidad_estudio', $value);
                    }
                }),

            SelectFilter::make('Condición Académica', 'condicion_academica')
                ->options(['' => 'Todos'] + array_combine(Matricula::CONDICIONES_ACADEMICAS, array_map(fn($item) => $item, Matricula::CONDICIONES_ACADEMICAS)))
                ->filter(function (Builder $query, $value) {
                    if ($value) {
                        $query->where('condicion_academica', $value);
                    }
                }),
            
            SelectFilter::make('Modalidad de Matrícula', 'modalidad_matricula')
                ->options([
                    '' => 'Todos',
                    1 => 'Presencial',
                    2 => 'Virtual',
                ])
                ->filter(function (Builder $query, $value) {
                    if ($value) {
                        $query->where('modalidad_matricula', $value);
                    }
                }),
        ];
    }

    public function builder(): Builder
    {
        $query = Matricula::query();

        $query->with([
            'estudiante',
            'estudiante.genero',
            'carrera',
            'area',
            'sede',
            'pagos',
            'aula_actual'
        ]);

        if ($this->cicloId) {
            $query->where('ciclo_id', $this->cicloId);
        }
        if ($this->sedeId) {
            $query->where('matriculas.sede_id', $this->sedeId);
        }

        $query->whereIn('matriculas.id', function ($subquery) {
            $subquery->selectRaw('MAX(id)')
                ->from('matriculas')
                ->groupBy('estudiante_id');
        });

        return $query;
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
            // Aplicamos eager loading con las relaciones necesarias
            $matriculas = $this->builder()
                ->with([
                    'estudiante',
                    'estudiante.genero',
                    'carrera',
                    'area',
                    'sede',
                    'pagos',
                    'aula_actual'
                ])
                ->get();
        } else {
            // Aplicamos eager loading para las matrículas seleccionadas
            $matriculas = Matricula::with([
                'estudiante',
                'estudiante.genero',
                'carrera',
                'area',
                'sede',
                'pagos',
                'aula_actual'
            ])
                ->whereIn('id', $selectedIds)
                ->get();
        }

        $this->clearSelected();

        return Excel::download(new MatriculaExport($matriculas), 'matriculas.xlsx');
    }

    #[On('delete-matricula')]
    public function deleteMatricula($matriculaId)
    {
        $matricula = Matricula::find($matriculaId);
        if ($matricula->delete()){
            $this->dispatch('show-alert', message: 'Matricula eliminado correctamente');
        }        
    }
}
