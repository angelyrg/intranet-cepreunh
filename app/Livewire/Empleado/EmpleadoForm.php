<?php

namespace App\Livewire\Empleado;

use App\Models\Intranet\Departamento;
use App\Models\Intranet\Empleado;
use App\Models\Intranet\TipoDocumento;
use Livewire\Attributes\Rule;
use Livewire\Component;

class EmpleadoForm extends Component
{
    public $title = 'Empleados';
    public $id;

    #[Rule('required')]
    public $nombres = '';
    #[Rule('required')]
    public $apellido_paterno = '';
    #[Rule('required')]
    public $apellido_materno = '';
    #[Rule('required')]
    public $tipo_documento_id = '';
    #[Rule('required')]
    public $nro_documento = '';
    #[Rule('required')]
    public $telefono_personal = '';
    #[Rule('required')]
    public $whatsapp = '';
    #[Rule('required')]
    public $correo_personal = '';
    #[Rule('required')]
    public $correo_institucional = '';
    #[Rule('required')]
    public $estado = '';
    #[Rule('required')]
    public $departamento_id = '';

    public function mount($empleadoId = null){       

        if($empleadoId){
            $empleado = Empleado::find($empleadoId);
            $this->id = $empleado->id;
            $this->nombres              = $empleado->nombres;
            $this->apellido_paterno     = $empleado->apellido_paterno;
            $this->apellido_materno     = $empleado->apellido_materno;
            $this->tipo_documento_id    = $empleado->tipo_documento_id;
            $this->nro_documento        = $empleado->nro_documento;
            $this->telefono_personal    = $empleado->telefono_personal;
            $this->whatsapp             = $empleado->whatsapp;
            $this->correo_personal      = $empleado->correo_personal;
            $this->correo_institucional = $empleado->correo_institucional;
            $this->departamento_id      = $empleado->departamento_id;
            $this->estado               = $empleado->estado;
        }

        // $this->departamento_id = $empleado->departamento_id;
    }

    public function save(){

        try {

            $dataValid = $this->validate(
                [
                    'nombres' => 'required',
                    'apellido_paterno' => 'required',
                    'apellido_materno' => 'required',
                    'tipo_documento_id' => 'required|exists:tipos_documentos,id',
                    'nro_documento' => 'required|numeric',
                    'telefono_personal' => 'required|numeric',
                    // 'whatsapp' => 'required|numeric',
                    'correo_personal' => 'required|email',
                    // 'correo_institucional' => 'required|email',
                    'departamento_id' => 'required|exists:departamentos,id',
                    'estado' => 'required|in:0,1',
                ]
            );

            if (!$dataValid) {
                throw new \Exception('Los datos no son válidos');
            }



            $empleado = Empleado::find($this->id);

            if($empleado){
                $empleado->update($this->only([
                    'nombres',
                    'apellido_paterno',
                    'apellido_materno',
                    'tipo_documento_id',
                    'nro_documento',
                    'telefono_personal',
                    'whatsapp',
                    'correo_personal',
                    'correo_institucional',
                    'departamento_id',
                    'estado'
                ]));

            }else{
                Empleado::create($this->only([
                    'nombres',
                    'apellido_paterno',
                    'apellido_materno',
                    'tipo_documento_id',
                    'nro_documento',
                    'telefono_personal',
                    'whatsapp',
                    'correo_personal',
                    'correo_institucional',
                    'departamento_id',
                    'estado'
                ]));
            }

            $this->dispatch('empleado-saved');
            $this->closeModal();

        } catch (\Exception $e) {
            
            $this->addError('save', 'Error al guardar el empleado: ' . $e->getMessage());
        }

    }

    public function closeModal()
    {
        $this->dispatch('empleados-modal-closed');
        $this->reset([
            'id',
            'nombres',
            'apellido_paterno',
            'apellido_materno',
            'tipo_documento_id',
            'nro_documento',
            'telefono_personal',
            'whatsapp',
            'correo_personal',
            'correo_institucional',
            'departamento_id',
            'estado'
        ]);
    }
    
    public function render()
    {
        $tipo_documentos = TipoDocumento::all();
        $departamentos = Departamento::all();
        
        return view('livewire.empleado.empleado-form', compact('tipo_documentos', 'departamentos'));
    }
}
