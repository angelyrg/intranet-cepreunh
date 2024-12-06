<?php

namespace App\Livewire\Ciclo;

use App\Models\Intranet\Asignatura;
use App\Models\Intranet\Ciclo;
use Livewire\Component;

class AsignarAsignaturasACiclo extends Component
{
    public $cicloId;
    public $ciclos;
    public $asignaturas;
    public $asignaturasAsignadas = [];

    // Cargar los datos cuando el componente se monta
    public function mount($cicloId)
    {
        $this->cicloId = $cicloId;
        $this->ciclos = Ciclo::all(); // Obtener todos los ciclos
        $this->asignaturas = Asignatura::all(); // Obtener todas las asignaturas
        $this->asignaturasAsignadas = Ciclo::find($this->cicloId)->asignaturas->pluck('id')->toArray(); // Obtener las asignaturas asignadas
    }

    // Asignar una asignatura al ciclo
    public function asignarAsignatura($asignaturaId)
    {
        $ciclo = Ciclo::find($this->cicloId);
        if (!$ciclo->asignaturas->contains($asignaturaId)) {
            $ciclo->asignaturas()->attach($asignaturaId); // Relacionar la asignatura con el ciclo
            $this->asignaturasAsignadas[] = $asignaturaId; // Agregar a la lista de asignaturas asignadas
        }
    }

    // Quitar una asignatura del ciclo
    public function quitarAsignatura($asignaturaId)
    {
        $ciclo = Ciclo::find($this->cicloId);
        $ciclo->asignaturas()->detach($asignaturaId); // Desasignar la asignatura del ciclo
        $this->asignaturasAsignadas = array_diff($this->asignaturasAsignadas, [$asignaturaId]); // Eliminar de la lista de asignaturas asignadas
    }

    // Asignar todas las asignaturas al ciclo
    public function asignarTodasLasAsignaturas()
    {
        $ciclo = Ciclo::find($this->cicloId);
        $ciclo->asignaturas()->attach($this->asignaturas->pluck('id')->toArray()); // Asignar todas las asignaturas
        $this->asignaturasAsignadas = $this->asignaturas->pluck('id')->toArray(); // Actualizar la lista de asignaturas asignadas
    }

    // Quitar todas las asignaturas del ciclo
    public function quitarTodasLasAsignaturas()
    {
        $ciclo = Ciclo::find($this->cicloId);
        $ciclo->asignaturas()->detach(); // Quitar todas las asignaturas
        $this->asignaturasAsignadas = []; // Limpiar la lista de asignaturas asignadas
    }

    public function render()
    {
        return view('livewire.ciclo.asignar-asignaturas-a-ciclo');
    }
}
