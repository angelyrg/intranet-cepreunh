<?php

namespace Database\Seeders;

use App\Models\Intranet\Area;
use App\Models\intranet\Carrera;
use Illuminate\Database\Seeder;

class CarrerasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Area::create(['descripcion' => 'ÁREA I']);
        Area::create(['descripcion' => 'ÁREA II']);
        Area::create(['descripcion' => 'ÁREA III']);
        
        $campos = [
            [
                'area_id' => 1,
                'descripcion' => 'INGENIERÍA DE SISTEMAS',
                'estado' => 1,
            ],
            [
                'area_id' => 1,
                'descripcion' => 'INGENIERÍA INDUSTRIAL',
                'estado' => 1,
            ],
        ];

        Carrera::insert($campos);


    }
}
