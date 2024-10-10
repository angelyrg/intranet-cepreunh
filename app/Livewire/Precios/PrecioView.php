<?php

namespace App\Livewire\Precios;

use App\Models\Intranet\Precio;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class PrecioView extends Component
{
    public $title = 'Precios';
    public $showModal = false;
    public $id;

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';

    public function updatingSearch(){
        $this->resetPage();
    }

    #[On('precio-saved')]
    public function refreshList(){

    }

    public function render(){
        $precios = Precio::paginate(10);
        return view('livewire.precios.precio-view', compact('precios'));
    }

    public function delete($itemId){
        $precio = Precio::find($itemId);
        if($precio){
            $precio->delete();
            $this->dispatch('show-alert', 'Precio eliminado con éxito');
        }
    }

    public function showForm($itemId = null){
        $this->id = $itemId;
        $this->showModal = true;
    }

    #[On('modal-closed')]
    public function hideModal(){
        $this->showModal = false;
    }

}
