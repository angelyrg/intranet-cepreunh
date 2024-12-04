<?php

namespace App\Livewire\Empleado;

use App\Models\Intranet\Departamento;
use App\Models\Intranet\Sede;
use App\Models\Intranet\TipoDocumento;
use App\Models\Intranet\Empleado;
use Livewire\Attributes\Rule;
use Livewire\Component;

class EmpleadoForm extends Component
{
    public $title = 'Empleados';
    public $id;

    #[Rule('required')]
    public $tipo_documento_id = '';
    #[Rule('required')]
    public $nro_documento = '';
    #[Rule('required')]
    public $nombres = '';
    #[Rule('required')]
    public $apellido_paterno = '';
    #[Rule('required')]
    public $apellido_materno = '';
    #[Rule('required')]
    public $fecha_nacimiento = '';
    #[Rule('required')]
    public $telefono_personal = '';
    #[Rule('required')]
    public $whatsapp = '';
    #[Rule('required')]
    public $correo_personal = '';
    #[Rule('required')]
    public $correo_institucional = '';
    #[Rule('required')]
    public $departamento_id = '';
    #[Rule('required')]
    public $sede_id = '';

    public $tipos_documentos = [];
    public $departamentos = [];
    public $sedes = [];

    public function mount($empleadoId = null){
        $this->tipos_documentos = TipoDocumento::all();
        $this->departamentos = Departamento::all();
        $this->sedes = Sede::all();

        if ($empleadoId) {
            $empleado = Empleado::find($empleadoId);

            $this->id = $empleado->id;
            $this->tipo_documento_id = $empleado->tipo_documento_id;
            $this->nro_documento = $empleado->nro_documento;
            $this->nombres = $empleado->nombres;
            $this->apellido_paterno = $empleado->apellido_paterno;
            $this->apellido_materno = $empleado->apellido_materno;
            $this->fecha_nacimiento = $empleado->fecha_nacimiento;
            $this->telefono_personal = $empleado->telefono_personal;
            $this->whatsapp = $empleado->whatsapp;
            $this->correo_personal = $empleado->correo_personal;
            $this->correo_institucional = $empleado->correo_institucional;
            $this->departamento_id = $empleado->departamento_id;
            $this->sede_id = $empleado->sede_id;
        }
    }

    public function save(){
        $this->validate();
        if($this->id){
            Empleado::find($this->id)->update($this->only([
                'tipo_documento_id',
                'nro_documento',
                'nombres',
                'apellido_paterno',
                'apellido_materno',
                'fecha_nacimiento',
                'telefono_personal',
                'whatsapp',
                'correo_personal',
                'correo_institucional',
                'departamento_id',
                'sede_id'
            ]));
        }else{
            Empleado::create($this->only([
                'tipo_documento_id',
                'nro_documento',
                'nombres',
                'apellido_paterno',
                'apellido_materno',
                'fecha_nacimiento',
                'telefono_personal',
                'whatsapp',
                'correo_personal',
                'correo_institucional',
                'departamento_id',
                'sede_id'
            ]));
        }

        $this->dispatch('empleado-saved');
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->dispatch('empleados-modal-closed');
        $this->reset([
            'id',
            'tipo_documento_id',
            'nro_documento',
            'nombres',
            'apellido_paterno',
            'apellido_materno',
            'fecha_nacimiento',
            'telefono_personal',
            'whatsapp',
            'correo_personal',
            'correo_institucional',
            'departamento_id',
            'sede_id'
        ]);
    }

    public function render()
    {
        return view('livewire.empleado.empleado-form');
    }

}
