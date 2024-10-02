<?php

namespace App\Livewire\RolesPermisos;

use App\Models\Intranet\Role;
use Livewire\Component;
use Livewire\Attributes\Rule;

use Illuminate\Support\Facades\Log;

class RolForm extends Component
{
    public $title = 'Roles y permisos';

    public $id;

    #[Rule('required')]
    public $name = '';

    public $guard_name = 'web';

    public function mount($roleId = null)
    {

        Log::error('data form => ', [$roleId]);


        if ($roleId) {
            $rules = Role::find($roleId);

            $this->id = $rules->id;
            $this->name = $rules->name;
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->id) {
            Role::find($this->id)->update($this->only(['name','guard_name']));
        } else {
            Role::create($this->only(['name','guard_name']));
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
        return view('livewire.roles-permisos.rol-form');
    }

}
