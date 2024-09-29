<?php

namespace App\Livewire\Estudiante;

use App\Models\Intranet\Estudiante;
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
        return view('livewire.estudiante.estudiante-list', [
            'students' => Estudiante::paginate(10)
        ]);
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
