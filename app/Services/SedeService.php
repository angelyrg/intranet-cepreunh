<?php

namespace App\Services;

use App\Models\Intranet\Sede;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SedeService
{

    public function create(array $data): Sede
    {
        $data = $this->sanitizeData($data);
        return Sede::create($data);
    }
    
    public function update(Sede $sede, array $data): Sede
    {
        $data = $this->sanitizeData($data);
        $sede->update($data);
        return $sede;
    }

    private function sanitizeData(array $data): array
    {
        return array_filter($data, fn($value) => !is_null($value) && $value !== '');
    }

    public function getData()
    {
        $sede = Sede::all();
        return $sede;
    }

    public function softDelete(Sede $sede)
    {
        try {
            $sede->delete(); // Soft delete
            $sede->save();

            return [
                'success' => true,
                'message' => 'Sede eliminada con éxito',
                'code' => 200
            ];
        } catch (ModelNotFoundException $e) {
            return [
                'success' => false,
                'message' => 'Sede no encontrada',
                'code' => 404
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al eliminar la sede',
                'code' => 500,
                'error' => $e->getMessage()
            ];
        }
    }
}
