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
    
    public function forceDelete(Matricula $matricula)
    {
        try {
            $matricula->forceDelete(); // Force delete
            $matricula->save();

            return [
                'success' => true,
                'message' => 'Matricula eliminada forzosamente con éxito',
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
                'message' => 'Error al eliminar la matricula forzosamente',
                'code' => 500,
                'error' => $e->getMessage()
            ];
        }
    }

    public function getMatriculaById($id)
    {
        $matricula = Matricula::findOrFail($id);
        return $matricula;
    }

    public function getMatriculaByUuid($uuid)
    {
        $matricula = Matricula::where('uuid', $uuid)->first();
        return $matricula;
    }

    /**
     * Obtiene las matrículas que coincidan con los filtros proporcionados.
     *
     * @param array $filters Los filtros a aplicar en la consulta.
     * @return \Illuminate\Database\Eloquent\Collection Las matrículas que coinciden con los filtros.
     */
    public function getMatriculasByColumns($filters = [], $getOnlyFirst = false)
    {
        $query = Matricula::query();

        foreach ($filters as $column => $value) {
            $query->where($column, $value);
        }

        return $getOnlyFirst ?  $query->first() : $query->get();
    }

    /**
     * Obtiene los datos de matrícula para imprimir.
     *
     * @param mixed $identifier Se acepta el ID o el UUID del estudiante.
     * @return array Los datos de matrícula listos para imprimir.
     */
    public function getMatriculaDataToPrint($identifier)
    {
        try {
            if (is_numeric($identifier)) {
                $matricula = $this->getMatriculaById($identifier);
            } elseif (is_string($identifier)) {
                $matricula = $this->getMatriculaByUuid($identifier);
            } else {
                throw new \InvalidArgumentException('El identificador debe ser un número o una cadena.');
            }

            if (!$matricula) {
                throw new ModelNotFoundException('No se pudo encontrar la matrícula con identificador proporcionado.');
            }
            
            if ($matricula->modalidad_matricula == 1) {
                $matricula->modalidad_matricula = 'Presencial';
            } elseif ($matricula->modalidad_matricula == 2) {
                $matricula->modalidad_matricula = 'Virtual';
            } else {
                $matricula->modalidad_matricula = '';
            }

            $unh_logo_icon = public_path('assets/images/logos/CepreUNH.webp');
            $document_header_img = public_path('assets/images/document-header.jpg');
            $sello_VB = public_path('assets/images/sello_cepreunh_VB.webp');
            
            $data = [
                'success' => true,
                'matricula' => $matricula,
                'unh_logo_icon' => $unh_logo_icon,
                'document_header_img' => $document_header_img,
                'sello_VB' => $sello_VB
            ];

            return $data;
        } catch (ModelNotFoundException $e) {
            return [
                'success' => false,
                'message' => 'Matricula no encontrada :(',
                'error' => $e->getMessage(),
                'code' => 404
            ];
        } catch (\InvalidArgumentException $e) {
            return [
                'success' => false,
                'message' => 'InvalidArgumentException',
                'error' => $e->getMessage(),
                'code' => 400
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al obtener los datos de la matricula',
                'error' => $e->getMessage(),
                'code' => 500
            ];
        }
    }
}
