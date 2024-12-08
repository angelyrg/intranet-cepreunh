<?php

namespace App\Livewire\Ciclo;

use App\Models\Intranet\Carrera;
use App\Models\Intranet\Ciclo;
use Livewire\Component;

class AsignarCarrerasACiclo extends Component
{
    public $cicloId;
    public $ciclos;
    public $carreras;
    public $carrerasAsignadas = [];

    // Cargar los datos cuando el componente se monta
    public function mount($cicloId)
    {
        $this->cicloId = $cicloId;
        $this->ciclos = Ciclo::all(); // Obtener todos los ciclos
        $this->carreras = Carrera::all(); // Obtener todas las carreras
        $this->carrerasAsignadas = Ciclo::find($this->cicloId)->carreras->pluck('id')->toArray(); // Obtener las carreras asignadas
    }

    // Asignar una carrera al ciclo
    public function asignarCarrera($carreraId)
    {
        $ciclo = Ciclo::find($this->cicloId);
        if (!$ciclo->carreras->contains($carreraId)) {
            $ciclo->carreras()->attach($carreraId); // Relacionar la carrera con el ciclo
            $this->carrerasAsignadas[] = $carreraId; // Agregar a la lista de carreras asignadas
        }
        $this->dispatch('asignacionCarreraActualizada');
    }

    // Quitar una carrera del ciclo
    public function quitarCarrera($carreraId)
    {
        $ciclo = Ciclo::find($this->cicloId);
        $ciclo->carreras()->detach($carreraId); // Desasignar la carrera del ciclo
        $this->carrerasAsignadas = array_diff($this->carrerasAsignadas, [$carreraId]); // Eliminar de la lista de carreras asignadas
        $this->dispatch('asignacionCarreraActualizada');
    }

    // Asignar todas las carreras al ciclo
    public function asignarTodasLasCarreras()
    {
        $ciclo = Ciclo::find($this->cicloId);
        $ciclo->carreras()->attach($this->carreras->pluck('id')->toArray()); // Asignar todas las carreras
        $this->carrerasAsignadas = $this->carreras->pluck('id')->toArray(); // Actualizar la lista de carreras asignadas
        $this->dispatch('asignacionCarreraActualizada');
    }

    // Quitar todas las carreras del ciclo
    public function quitarTodasLasCarreras()
    {
        $ciclo = Ciclo::find($this->cicloId);
        $ciclo->carreras()->detach(); // Quitar todas las carreras
        $this->carrerasAsignadas = []; // Limpiar la lista de carreras asignadas
        $this->dispatch('asignacionCarreraActualizada');
    }

    public function render()
    {
        return view('livewire.ciclo.asignar-carreras-a-ciclo');
    }
}