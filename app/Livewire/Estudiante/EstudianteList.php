<?php

namespace App\Livewire\Estudiante;

use App\Models\Intranet\Estudiante;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class EstudianteList extends Component
{
    
    use WithPagination;
    
    public $title = 'Estudiante';
    public $showModal = false;
    public $id;

    #[On('student-saved')]
    public function refreshList()
    {
        // La lista se actualizará automáticamente
    }

    public function render()
    {
        $user = Auth::user();
        if ($user->can('sedes.ver_todas')){
            $students = Estudiante::paginate(10);
        }else{
            $students = Estudiante::where('sede_actual_id', $user->sede_id)->paginate(10);
        }
        return view('livewire.estudiante.estudiante-list', compact('students'));
    }

    public function delete($studentId)
    {
        $student = Estudiante::find($studentId);
        if ($student) {
            $student->delete();
            $this->dispatch('show-alert', message: 'Estudiante eliminado con éxito');
        }
    }

    public function showForm($studentId = null)
    {
        $this->id = $studentId;
        $this->showModal = true;
    }

    #[On('modal-closed')] 
    public function hideModal()
    {
        $this->showModal = false;
    }

}
