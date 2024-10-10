<?php

namespace App\Livewire\Precios;

use App\Http\Requests\Intranet\PrecioRequest;
use App\Models\Intranet\Area;
use App\Models\Intranet\FormaDePago;
use App\Models\Intranet\Precio;
use Livewire\Component;

class PrecioForm extends Component
{
    public $formas_de_pago;
    public $areas;
    public $title = 'Precios';

    // Campos para la tabla precios
    public $id;
    public $sede_id=1; //TODO: La sede se debe obtner de la session del usurio
    public $ciclo_id=1; //TODO: Esta seccion se debe pasar al seleccionar un ciclo
    public $area_id;
    public $forma_de_pago_id;
    public $monto;
    public $fraccionado = false;


    public function mount($precioId = null)
    {
        $this->formas_de_pago = FormaDePago::all();
        $this->areas = Area::all();

        if($precioId){
            $precio = Precio::find($precioId);

            $this->id = $precio->id;
            $this->forma_de_pago_id = $precio->forma_de_pago_id;
            $this->ciclo_id = $precio->ciclo_id;
            $this->sede_id = $precio->sede_id;
            $this->area_id = $precio->area_id;
            $this->monto = $precio->monto;
            $this->fraccionado = $precio->fraccionado;
        }
    }

    public function save(){
        
        $validatedData = $this->validate((new PrecioRequest())->rules(), (new PrecioRequest())->messages());


        if($this->id){
            Precio::find($this->id)->update($validatedData);
        }else{
            Precio::create($validatedData);
        }

        $this->dispatch('precio-saved');
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->dispatch('modal-closed');
        $this->reset(['id', 'forma_de_pago_id', 'ciclo_id', 'sede_id', 'area_id', 'monto', 'fraccionado']);
    }

    public function render()
    {
        return view('livewire.precios.precio-form');
    }

}
