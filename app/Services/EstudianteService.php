<?php

namespace App\Services;

use App\Models\Intranet\Estudiante;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EstudianteService
{

    public function create(array $data): Estudiante
    {
        $data = $this->sanitizeData($data);
        return Estudiante::create($data);
    }
    
    public function update(Estudiante $estudiante, array $data): Estudiante
    {
        $data = $this->sanitizeData($data);
        $estudiante->update($data);
        return $estudiante;
    }

    private function sanitizeData(array $data): array
    {
        return array_filter($data, fn($value) => !is_null($value) && $value !== '');
    }

    public function getData()
    {
        $estudiante = Estudiante::all();
        return $estudiante;
    }

    public function softDelete(Estudiante $estudiante)
    {
        try {
            $estudiante->delete(); // Soft delete
            $estudiante->save();

            return [
                'success' => true,
                'message' => 'Estudiante eliminado con éxito',
                'code' => 200
            ];
        } catch (ModelNotFoundException $e) {
            return [
                'success' => false,
                'message' => 'Estudiante no encontrado',
                'code' => 404
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al eliminar el estudiante',
                'code' => 500,
                'error' => $e->getMessage()
            ];
        }
    }

    public function getEstudianteByNroDocumento($nro_documento)
    {
        $estudiante = Estudiante::where('nro_documento', $nro_documento)->first();
        return $estudiante;
    }
}
