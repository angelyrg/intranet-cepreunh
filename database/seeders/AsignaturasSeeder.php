<?php

namespace Database\Seeders;

use App\Models\Intranet\Asignatura;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AsignaturasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $campos = [
            [
                'descripcion' => 'ECOLOGÍA',
                'estado' => 1,
            ],
            [
                'descripcion' => 'ESTADÍSTICA Y PROBABILIDADES A',
                'estado' => 1,
            ],
            [
                'descripcion' => 'FINANZAS',
                'estado' => 1,
            ],
        ];

        Asignatura::insert($campos);
    }
}
