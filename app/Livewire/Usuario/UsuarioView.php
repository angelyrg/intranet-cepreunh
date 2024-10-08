<?php

namespace App\Livewire\Usuario;

use App\Models\Intranet\User;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class UsuarioView extends Component
{

    public $title = 'Usuarios';
    public $showModal = false;
    public $id;

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';

    public function updatingSearch(){
        $this->resetPage();
    }

    #[On('usuario-seved')]
    public function refreshList(){

    }

    public function render(){

        $usuarios = User::where('name', 'LIKE', '%'.$this->search.'%')
                        ->orWhere('email', 'LIKE', '%'.$this->search.'%')
                        ->paginate(10);

        return view('livewire.usuario.usuario-view', compact('usuarios'));

        // Log::info('Render called with search: ' . $this->search);

        // return view('livewire.usuario.usuario-view', [
        //     'usuarios' => User::where('name', 'LIKE', '%'.$this->search.'%')
        //                     ->orWhere('email', 'LIKE', '%'.$this->search.'%')
        //                     ->paginate(10)
        // ]);
    }

    public function delete($usuarioId){
        $usuarios = User::find($usuarioId);
        if($usuarios){
            $usuarios->delete();
            $this->dispatch('show-alert', 'Usuario eliminado con éxito');
        }
    }

    public function showForm($usuarioId = null){
        $this->id = $usuarioId;
        $this->showModal = true;
    }

    #[On('modal-closed')]
    public function hideModal(){
        $this->showModal = false;
    }

}
