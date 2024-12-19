<?php

namespace App\Services;

use App\Models\Intranet\Matricula;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MatriculaService
{

    public function create(array $data): Matricula
    {
        $data = $this->sanitizeData($data);
        return Matricula::create($data);
    }
    
    public function update(Matricula $matricula, array $data): Matricula
    {
        $data = $this->sanitizeData($data);
        $matricula->update($data);
        return $matricula;
    }

    private function sanitizeData(array $data): array
    {
        return array_filter($data, fn($value) => !is_null($value) && $value !== '');
    }

    public function getData()
    {
        $matricula = Matricula::all();
        return $matricula;
    }

    public function softDelete(Matricula $matricula)
    {
        try {
            $matricula->delete(); // Soft delete
            $matricula->save();

            return [
                'success' => true,
                'message' => 'Matricula eliminada con éxito',
                'code' => 200
            ];
        } catch (ModelNotFoundException $e) {
            return [
                'success' => false,
                'message' => 'Matricula no encontrada',
                'code' => 404
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al eliminar la matricula',
                'code' => 500,
                'error' => $e->getMessage()
            ];
        }
    }
}
