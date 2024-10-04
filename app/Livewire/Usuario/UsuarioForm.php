<?php

namespace App\Livewire\Usuario;

use App\Models\Intranet\User;
use Livewire\Attributes\Rule;
use Livewire\Component;

class UsuarioForm extends Component
{

    public $title = 'Usuarios';
    public $id;

    #[Rule('required')]
    public $name = '';
    #[Rule('required')]
    public $email = '';

    public function mount($usuarioId = null){
        if($usuarioId){
            $usuarios = User::find($usuarioId);

            $this->id = $usuarios->id;
            $this->name = $usuarios->name;
            $this->email = $usuarios->email;
        }
    }

    public function save(){
        $this->validate();
        if($this->id){
            User::find($this->id)->update($this->only(['name','email']));
        }else{
            User::create($this->only(['name','email']));
        }

        $this->dispatch('usuario-saved');
        $this->closeModal();

    }

    public function closeModal()
    {
        $this->dispatch('modal-closed');
        $this->reset(['id', 'name', 'email']);
    }

    public function render()
    {
        return view('livewire.usuario.usuario-form');
    }

}
