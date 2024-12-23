<?php

namespace App\Livewire\Ciclo;

use App\Models\Intranet\Area;
use App\Models\Intranet\Aula;
use App\Models\Intranet\Ciclo;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AsignarAulasACiclo extends Component
{
    public $cicloId;
    public $sedeId;
    public $ciclo;
    public $aulas;
    public $aulasAsignadas = [];
    public $areas;


    public function mount($cicloId)
    {
        $this->cicloId = $cicloId;
        $this->ciclo = Ciclo::findOrFail($cicloId);
        $this->sedeId = Auth::user()->sede_id;
        $this->aulas = Aula::where('sede_id', $this->sedeId)->get();
        $this->areas = Area::all();

        $this->aulasAsignadas = $this->ciclo->aulas()
            ->where('sede_id', $this->sedeId)
            ->pluck('aulas.id')
            ->toArray();
    }

    public function asignarAula($aulaId, $areaId)
    {
        $ciclo = Ciclo::find($this->cicloId);

        if (!$this->ciclo->aulas->contains($aulaId)) {
            $this->ciclo->aulas()->attach($aulaId, ['area_id' => $areaId]);
            $this->aulasAsignadas[] = $aulaId;
        }
    }

    public function quitarAula($aulaId)
    {
        $this->ciclo->aulas()->detach($aulaId);
        $this->aulasAsignadas = array_diff($this->aulasAsignadas, [$aulaId]);
    }

    public function asignarTodasLasAulas()
    {
        $this->ciclo->aulas()->attach($this->aulas->pluck('id')->toArray());
        $this->aulasAsignadas = $this->aulas->pluck('id')->toArray();
    }

    public function quitarTodasLasAulas()
    {
        $this->ciclo->aulas()->detach();
        $this->aulasAsignadas = [];
    }

    public function render()
    {
        return view('livewire.ciclo.asignar-aulas-a-ciclo');
    }
}
