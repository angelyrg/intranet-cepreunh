<?php

namespace Database\Seeders;

use App\Models\Intranet\Docente;
use App\Models\Intranet\Gradoacademico;
use Illuminate\Database\Seeder;

class DocentesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Gradoacademico::insert([['descripcion' => 'Licenciado'],['descripcion' => 'Magister']]);

        $campos = [
            [
                'nombres' => 'HILDEBRANDO',
                'apellidos' => 'ALMONACID VILLANUEVA',
                'genero' => 'F',
                'gradoacademico_id' => 1,
                'estado' => 1,
            ],
            [
                'nombres' => 'DEMETRIO',
                'apellidos' => 'ARROYO HILARIO',
                'genero' => 'F',
                'gradoacademico_id' => 2,
                'estado' => 1,
            ],
        ];

        Docente::insert($campos);
        
    }
}
