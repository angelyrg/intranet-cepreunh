<?php

namespace App\Services;

use App\Models\Intranet\Pago;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PagoService
{

    public function create(array $data): Pago
    {
        $data = $this->sanitizeData($data);
        return Pago::create($data);
    }
    
    public function update(Pago $pago, array $data): Pago
    {
        $data = $this->sanitizeData($data);
        $pago->update($data);
        return $pago;
    }

    private function sanitizeData(array $data): array
    {
        return array_filter($data, fn($value) => !is_null($value) && $value !== '');
    }

    public function getData()
    {
        $pago = Pago::all();
        return $pago;
    }

    public function softDelete(Pago $pago)
    {
        try {
            $pago->delete(); // Soft delete
            $pago->save();

            return [
                'success' => true,
                'message' => 'Pago eliminado con éxito',
                'code' => 200
            ];
        } catch (ModelNotFoundException $e) {
            return [
                'success' => false,
                'message' => 'Pago no encontrada',
                'code' => 404
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al eliminar el Pago',
                'code' => 500,
                'error' => $e->getMessage()
            ];
        }
    }

    public function forceDelete(Pago $pago)
    {
        try {
            $pago->forceDelete(); // Force delete
            $pago->save();

            return [
                'success' => true,
                'message' => 'Pago eliminado con éxito forzosamente',
                'code' => 200
            ];
        } catch (ModelNotFoundException $e) {
            return [
                'success' => false,
                'message' => 'Pago no encontrado',
                'code' => 404
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al eliminar el pago forzosamente',
                'code' => 500,
                'error' => $e->getMessage()
            ];
        }
    }
}
