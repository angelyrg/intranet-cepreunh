<?php

namespace App\Services;

use App\Models\Intranet\Aula;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AulaService
{

    public function create(array $data): Aula
    {
        $data = $this->sanitizeData($data);
        return Aula::create($data);
    }
    
    public function update(Aula $aula, array $data): Aula
    {
        $data = $this->sanitizeData($data);
        $aula->update($data);
        return $aula;
    }

    private function sanitizeData(array $data): array
    {
        return array_filter($data, fn($value) => !is_null($value) && $value !== '');
    }

    public function getData()
    {
        $aula = Aula::with('sede')->get();
        return $aula;
    }

    public function softDelete(Aula $aula)
    {
        try {
            $aula->delete(); // Soft delete
            $aula->save();

            return [
                'success' => true,
                'message' => 'Aula eliminado con éxito',
                'code' => 200
            ];
        } catch (ModelNotFoundException $e) {
            return [
                'success' => false,
                'message' => 'Aula no encontrado',
                'code' => 404
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al eliminar el aula',
                'code' => 500,
                'error' => $e->getMessage()
            ];
        }
    }
}
