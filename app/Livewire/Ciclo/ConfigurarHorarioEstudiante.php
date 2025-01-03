<?php

namespace App\Livewire\Ciclo;

use App\Models\Intranet\Carrera;
use App\Models\Intranet\Ciclo;
use App\Models\Intranet\HorarioEstudiante;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ConfigurarHorarioEstudiante extends Component
{
    public $sede_id;
    public $ciclo_id;
    public $presente_inicio;
    public $presente_fin;
    public $tarde_inicio;
    public $tarde_fin;

    public $cicloTieneConfiguracion = false;
    public $horarioEstudianteId = null; // ID del horario existente


    protected $rules = [
        'sede_id' => 'required|exists:sedes,id',
        'ciclo_id' => 'required|exists:ciclos,id',
        'presente_inicio' => 'required',
        'presente_fin' => 'required',
        'tarde_inicio' => 'required',
        'tarde_fin' => 'required',
    ];


    // Cargar los datos cuando el componente se monta
    public function mount($cicloId)
    {
        $this->ciclo_id = $cicloId;
        $this->sede_id = Auth::user()->sede_id;

        $horario = HorarioEstudiante::where('ciclo_id', $cicloId)
            ->where('sede_id', $this->sede_id)
            ->first();

        if ($horario) {
            $this->cicloTieneConfiguracion = true;
            $this->horarioEstudianteId = $horario->id;
            $this->presente_inicio = $horario->presente_inicio;
            $this->presente_fin = $horario->presente_fin;
            $this->tarde_inicio = $horario->tarde_inicio;
            $this->tarde_fin = $horario->tarde_fin;
        }
    }

    public function crearHorarioEstudiante()
    {
        $this->validate();

        $horarioExistente = HorarioEstudiante::where('sede_id', $this->sede_id)
            ->where('ciclo_id', $this->ciclo_id)
            ->exists();

        if ($horarioExistente) {
            session()->flash('horario_error', 'Ya existe un horario configurado para este ciclo y sede.');
            return;
        }

        $horarioEstudianteNuevo = HorarioEstudiante::create([
            'sede_id' => $this->sede_id,
            'ciclo_id' => $this->ciclo_id,
            'presente_inicio' => $this->presente_inicio,
            'presente_fin' => $this->presente_fin,
            'tarde_inicio' => $this->tarde_inicio,
            'tarde_fin' => $this->tarde_fin,
        ]);

        $this->horarioEstudianteId = $horarioEstudianteNuevo->id;
        $this->cicloTieneConfiguracion = true;

        session()->flash('horario_success', 'Horario creado con éxito.');
    }

    public function actualizarHorarioEstudiante()
    {
        $this->validate();

        $horario = HorarioEstudiante::find($this->horarioEstudianteId);

        if ($horario) {
            $horario->update([
                'presente_inicio' => $this->presente_inicio,
                'presente_fin' => $this->presente_fin,
                'tarde_inicio' => $this->tarde_inicio,
                'tarde_fin' => $this->tarde_fin,
            ]);

            session()->flash('horario_success', 'Horario actualizado con éxito.');
        } else {
            session()->flash('horario_error', 'No se encontró un horario para este ciclo y sede.');
        }
    }

    public function render()
    {
        return view('livewire.ciclo.configurar-horario-estudiante');
    }
}