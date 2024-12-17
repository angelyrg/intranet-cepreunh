<?php

namespace App\Livewire\Empleado;

use App\Http\Requests\Intranet\GenerarCuentaEmpleadoRequest;
use App\Models\Intranet\Empleado;
use App\Models\Intranet\Permission;
use App\Models\Intranet\Role;
use App\Models\Intranet\Sede;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Rule;
use Livewire\Component;

class AsignarRolUsuario extends Component
{
    public $id;
    #[Rule('required')]
    public $sede_id = '';
    #[Rule('required')]
    public $correo_personal = '';
    #[Rule('required')]
    public $username = '';
    #[Rule('required')]
    public $password = '';
    
    public $user_id;
    public $sedes = [];

    // public $roles = [];
    #[Rule('required')]
    public $role_id;
    public $permisos = [];

    public function mount($empleadoId){
        
        $empleado = Empleado::findOrFail($empleadoId);
        $this->id = $empleado->id;
        $this->user_id = $empleado->user_id;

        if($this->user_id){
            $usuario = User::findOrFail($this->user_id);
                        
            $this->role_id = $usuario->roles->first()?->id;
            if ($this->role_id){
                $this->permisos = Role::find($this->role_id)->permissions;
            }
            
            $this->sede_id = $usuario->sede_id;
            $this->correo_personal = $usuario->email;
            $this->username = $usuario->username;
            $this->password = '';
        }else{
            $this->role_id = '';
            $this->sede_id = '';
            $this->correo_personal = $empleado->correo_personal;
            $this->username = $empleado->nro_documento;
            $this->password = '';
        }

        $this->sedes = Sede::all()->pluck('descripcion', 'id')->toArray();

        // $this->roles = Role::all();

    }

    public function generarCuenta(){
        try {

            logger('sede_id: ' . $this->sede_id);

            $validatedData = $this->validate((new GenerarCuentaEmpleadoRequest())->rules(), (new GenerarCuentaEmpleadoRequest())->messages());

            $empleado = Empleado::find($this->id);
            $name = explode(' ', $empleado->nombres)[0] . ' ' . $empleado->apellido_paterno;
            $tipoUsuario = 1; // 1 = empleado, 2 = docente, 3 = estudiante

            $userData = [
                'name' => $name,
                'email' => $validatedData['correo_personal'],
                'username' => $validatedData['username'],
                'password' => Hash::make($validatedData['password']),
                'sede_id' => $this->sede_id,
                'tipos_usuarios_id' => $tipoUsuario,
            ];

            $usuario = User::create($userData);

            $empleado->user_id = $usuario->id;
            $empleado->save();

            // Logging
            // Log::info("Cuenta creada para el empleado ID: {$empleado->id}", ['usuario_id' => $usuario->id]);

            $this->dispatch('showNotify', ['type' => 'success', 'msg' => 'La cuenta del empleado ha sido registrada correctamente.']);
            
            // $this->emit('cuentaCreada');
            
        } catch (\Exception $e) {
            $this->addError('usuario', 'Error al generar la cuenta: ' . $e->getMessage());
            return;
        }


        
        
    }

    public function save(){
        
        logger('id: ' . $this->id);
        dd($this->id);
    }

    public function update(){
        
        // logger('Método update ejecutado');

        // logger('id ===>  ' . $this->id);
        // dd($this->id);

        try {
            
            $empleado = Empleado::find($this->id);

            $usuario = User::find($empleado->user_id);

            if(!$usuario->id) throw new \Exception('Usuario no encontrado');

            $usuarioData = [
                'sede_id' => $this->sede_id,
                'email' => $this->correo_personal,
                'username' => $this->username,
            ];

            if($this->password != ''){
                $usuarioData['password'] = Hash::make($this->password);
            }

            $usuario->update($usuarioData);

            $empleado->update([
                'sede_id' => $this->sede_id,
            ]);

            if ($this->role_id) {
                $dataRole = Role::find($this->role_id);
                $usuario->syncRoles([$dataRole->name]);
            }

            $this->dispatch('showNotify', ['type' => 'success', 'msg' => 'La cuenta del empleado ha sido actualizada correctamente.']);

            // session()->flash('success', 'La cuenta del empleado ha sido actualizada correctamente.');
            // $this->dispatch('empleado-saved');


        } catch (\Exception $e) {
            $this->addError('usuario', 'Error al actualizar la cuenta: ' . $e->getMessage());
            return;
        }
    }

    public function updatedRoleId($value) {
        // $this->permisos = Permission::where('role_id', $value)->get();
        if ($value) {
            $this->permisos = Role::find($value)->permissions;
        } else {
            $this->permisos = [];
        }
    }

    public function closeModalAsignarRolUsuario()
    {
        $this->dispatch('modal-closed-asignar-rol-usuario');
    }


    public function render()
    {
        $empleado = Empleado::find($this->id);
        $nombre_completo = $empleado->nombres . ' ' . $empleado->apellido_paterno . ' ' . $empleado->apellido_materno;
        $sedes = Sede::all();
        $roles = Role::all();

        

        return view('livewire.empleado.asignar-rol-usuario', compact('empleado', 'nombre_completo', 'sedes', 'roles'));
    }

}
