<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormaDePagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('formas_de_pago')->insert([
            ['descripcion' => 'Contado'],
            ['descripcion' => 'Convenio'],
            ['descripcion' => 'Hijo de trabajador por descuento'],
            ['descripcion' => 'Hijo de trabajador al contado'],
            ['descripcion' => 'Por hermanos'],
            ['descripcion' => 'Por partes'],
            ['descripcion' => 'Preparatoria'],
            ['descripcion' => 'Primeros puestos']
        ]);
    }
}
