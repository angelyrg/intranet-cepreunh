<?php

namespace Database\Seeders;

use App\Models\Intranet\CarreraCiclo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarreraCicloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $campos = [
            [
                'ciclo_id' => 1,
                'carrera_id' => 1,
                'estado' => 1,
            ]
        ];
        
        CarreraCiclo::insert($campos);
    }
}
