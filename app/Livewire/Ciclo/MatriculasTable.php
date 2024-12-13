<?php

namespace App\Livewire\Ciclo;

use App\Models\Intranet\Ciclo;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Intranet\Matricula;
use Rappasoft\LaravelLivewireTables\Views\Action;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\IncrementColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectDropdownFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class MatriculasTable extends DataTableComponent
{
    protected $model = Matricula::class;

    public $cicloId;

    public function mount($cicloId = null)
    {
        $this->cicloId = (string)$cicloId;
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDebugStatus(true);
    }

    public function actions(): array
    {
        return [
            Action::make('View Dashboard')
            ->setRoute('/home'),
            Action::make('Otro')
            ->setRoute('/home'),
        ];
    }

    public function columns(): array
    {
        return [
            IncrementColumn::make('#'),
            Column::make("DNI", "estudiante.nro_documento")->sortable(),
            Column::make("Nombres", "estudiante.nombres")->sortable(),
            Column::make("Apellido Paterno", "estudiante.apellido_paterno")->sortable(),
            Column::make("Apellido Materno", "estudiante.apellido_materno")->sortable(),
            Column::make("Género", "estudiante.genero.descripcion")->sortable(),
            Column::make("Carrera", "carrera.descripcion")->sortable(),
            Column::make("Área", "area.descripcion")->sortable(),
            Column::make("Modalidad de estudio", "modalidad_estudio")->sortable(),
            Column::make("Condición Académica", "condicion_academica")->sortable(),
            
            Column::make("Teléfono personal", "estudiante.telefono_personal")->sortable(),
            Column::make("Whatsapp", "estudiante.whatsapp")->sortable(),
            Column::make("Correo personal", "estudiante.correo_personal")->sortable(),
            Column::make("Correo Institucional", "estudiante.correo_institucional")->sortable(),
            BooleanColumn::make("¿Tiene discapacidad?", "estudiante.tiene_discapacidad")->sortable(),
            
            Column::make("Modalidad de matricula", 'modalidad_matricula')
                ->sortable()
                ->format(function ($value) {
                    return $value == 1 ? 'Presencial' : ($value == 2 ? 'Virtual' : 'Desconocido');
                }),

            DateColumn::make('Fecha de matrícula', 'created_at')->outputFormat('d/m/Y h:i:sA'),
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Modalidad de Matrícula', 'modalidad_matricula')
                ->options([
                    1 => 'Presencial',
                    2 => 'Virtual',
                ])
                ->filter(function (Builder $query, $value) {
                    if ($value == 1) {
                        $query->where('modalidad_matricula', 1);
                    } elseif ($value == 2) {
                        $query->where('modalidad_matricula', 2);
                    }
                }),
        ];
    }

    public function builder(): Builder
    {
        $query = Matricula::query();

        if ($this->cicloId) {
            $query->where('ciclo_id', $this->cicloId);
        }

        return $query;
    }

}
