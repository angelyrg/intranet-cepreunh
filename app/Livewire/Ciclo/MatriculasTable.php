<?php

namespace App\Livewire\Ciclo;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Intranet\Matricula;
use Illuminate\Contracts\Database\Eloquent\Builder;

class MatriculasTable extends DataTableComponent
{
    protected $model = Matricula::class;

    public $cicloId;

    public function mount($cicloId = null)
    {
        $this->cicloId = $cicloId;
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function query(): Builder
    {
        $query = Matricula::query();

        if ($this->cicloId) {
            $query->where('ciclo_id', $this->cicloId);
        }

        return $query;
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Ciclo id", "ciclo.descripcion")
                ->sortable(),
            Column::make("Estudiante id", "estudiante_id")
                ->sortable(),
            Column::make("Area id", "area_id")
                ->sortable(),
            Column::make("Carrera id", "carrera_id")
                ->sortable(),
            Column::make("Sede id", "sede_id")
                ->sortable(),
            Column::make("Turno", "turno")
                ->sortable(),
            Column::make("Estado", "estado")
                ->sortable(),
            Column::make("Uuid", "uuid")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }

    
    
}
