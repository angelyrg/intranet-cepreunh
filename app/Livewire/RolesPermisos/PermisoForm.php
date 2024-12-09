<?php

namespace App\Livewire\RolesPermisos;

use App\Models\Intranet\Permission;
use Livewire\Attributes\Rule;
use Livewire\Component;

class PermisoForm extends Component
{

    public $title = 'Roles y permisos';

    public $id;

    #[Rule('required')]
    public $name = '';

    public $guard_name = 'web';

    public function mount($permisoId = null)
    {

        // dd($permisoId);

        if ($permisoId) {
            $rules = Permission::find($permisoId);

            $this->id = $rules->id;
            $this->name = $rules->name;
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->id) {
            Permission::find($this->id)->update($this->only(['name','guard_name']));
        } else {
            Permission::create($this->only(['name','guard_name']));
        }

        $this->dispatch('role-saved');
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->dispatch('modal-closed');
        $this->reset(['id', 'name']);
    }
    
    public function render()
    {
        return view('livewire.roles-permisos.permiso-form');
    }
}
