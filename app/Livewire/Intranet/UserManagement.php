<?php

namespace App\Livewire\Intranet;


use App\Models\Intranet\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class UserManagement extends Component
{
    public $users, $name, $username, $email, $password, $estado;
    public $isOpen = false;
    public $userId;

    public function render()
    {
        $this->users = User::all();
        // return view('livewire.intranet.user-management');
        return view('livewire.users.view');
    }

    private function resetInputFields(){
        $this->name = '';
        $this->username = '';
        $this->email = '';
        $this->password = '';
        $this->estado = 1;
        $this->userId = null;
    }

    public function openModal()
    {
        $this->isOpen = true; 
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetInputFields();
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email|unique:users,email,'.$this->userId,
            'estado' => 'required|in:0,1,2',
        ]);

        if ($this->userId) {
            User::find($this->userId)->update([
                'name' => $this->name, 
                'username' => $this->username, 
                'email' => $this->email,
                'estado' => $this->estado,
            ]);
        } else {
            $this->validate(['password' => 'required|min:6']);
            User::create([
                'name' => $this->name,
                'username' => $this->username,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'estado' => $this->estado,
            ]);
        }

        session()->flash('message', $this->userId ? 'Usuario actualizado exitosamente.' : 'Usuario creado exitosamente.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        Log::info($user);
        // dd($user);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->estado = $user->estado;
    
        $this->openModal();
    }

    public function delete($id)
    {
        User::find($id)->delete();
        session()->flash('message', 'Usuario eliminado exitosamente.');
    }
}