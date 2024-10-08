<?php

namespace Database\Seeders;

use App\Models\Intranet\Empleado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmpleadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Empleado::create([
            'tipo_documento_id' => '1',
            'nro_documento' => '73509509',
            'nombres' => 'JOEL NESKENZ',
            'apellido_paterno' => 'CRISPIN',
            'apellido_materno' => 'RIVERA',
            'fecha_nacimiento' => '2024-02-24',
            'pais_nacimiento' => '140',
            'telefono_personal' => '940588829',
            'whatsapp' => '940588829',
            'correo_personal' => 'joel.neskenz@gmail.com',
            'correo_institucional' => '',
            'departamento_id' => '1',

        ]);

        // User::factory(99)->create();
        Empleado::factory(20)->create();
    }
}
