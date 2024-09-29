<?php

namespace Database\Seeders;

use App\Models\Intranet\AsignaturaCiclo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AsignaturaCicloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        

        $campos = [
            [
                'ciclo_id' => 1,
                'asignatura_id' => 1,
                'estado' => 1,
            ]
            ];
        AsignaturaCiclo::insert($campos);
    }
}
