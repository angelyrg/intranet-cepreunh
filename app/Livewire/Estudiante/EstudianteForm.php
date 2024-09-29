<?php

namespace App\Livewire\Estudiante;

use App\Models\Intranet\Estudiante;
use Livewire\Component;
use Livewire\Attributes\Rule;

class EstudianteForm extends Component
{
    public $title = 'Estudiante';

    public $id;

    #[Rule('required|min:3')]
    public $nombres = '';
    #[Rule('required|min:3')]
    public $apellido_paterno = '';
    #[Rule('required|min:3')]
    public $apellido_materno = '';
    #[Rule('required|email')]
    public $correo_institucional = '';
    #[Rule('required|min:6|max:9')]
    public $telefono_personal = '';
    // #[Rule('required')]
    public $tipo_documento = '';

    public function mount($studentId = null)
    {
        if ($studentId) {
            $student = Estudiante::find($studentId);
            $this->id = $student->id;
            $this->nombres = $student->nombres;
            $this->apellido_paterno = $student->apellido_paterno;
            $this->apellido_materno = $student->apellido_materno;
            $this->correo_institucional = $student->correo_institucional;
            $this->telefono_personal = $student->telefono_personal;
            $this->tipo_documento = $student->tipo_documento;
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->id) {
            Estudiante::find($this->id)->update($this->only(['nombres','apellido_paterno','apellido_materno','correo_institucional','telefono_personal','tipo_documento']));
        } else {
            Estudiante::create($this->only(['nombres','apellido_paterno','apellido_materno','correo_institucional','telefono_personal','tipo_documento']));
        }

        $this->dispatch('student-saved');
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->dispatch('modal-closed');
        $this->reset(['id', 'nombres', 'apellido_paterno', 'apellido_materno', 'correo_institucional', 'telefono_personal']);
    }

    public function render()
    {
        return view('livewire.estudiante.estudiante-form');
    }


    // public $showModal = true;

    // protected $rules = [
    //     'nombres' => 'required|min:3',
    //     'apellido_paterno' => 'required|min:3',
    //     'apellido_materno' => 'required|min:3',
    //     'correo_institucional' => 'required|email',
    //     'telefono_personal' => 'required|min6|max9',
    // ];



    // public function save()
    // {
    //     $this->validate();

    //     if ($this->studentId) {
    //         Estudiante::find($this->studentId)->update([
    //             'nombres' => $this->nombres,
    //             'correo_institucional' => $this->correo_institucional,
    //             'apellido_paterno' => $this->apellido_paterno,
    //             'apellido_materno' => $this->apellido_materno,
    //             'telefono_personal' => $this->telefono_personal,
    //         ]);
    //     } else {
    //         Estudiante::create([
    //             'nombres' => $this->nombres,
    //             'correo_institucional' => $this->correo_institucional,
    //             'apellido_paterno' => $this->apellido_paterno,
    //             'apellido_materno' => $this->apellido_materno,
    //             'telefono_personal' => $this->telefono_personal,
    //         ]);
    //     }

    //     $this->emit('refreshList');
    //     $this->emit('closeModal');
    //     $this->reset(['nombres', 'correo_institucional', 'apellido_paterno', 'apellido_materno', 'telefono_personal']);
    // }

    // public function render()
    // {
    //     return view('livewire.estudiante.estudiante-form');
    // }

    // public function closeModal()
    // {
    //     $this->showModal = false;
    //     $this->emitUp('modalClosed');
    //     $this->reset(['name', 'email', 'course', 'studentId']);
    // }

    // public function closeModal()
    // {
    //     $this->emit('closeModal');
    // }


}
