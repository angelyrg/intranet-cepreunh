<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposDocumentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipos_documentos')->insert([
            ['descripcion' => 'DNI - Documento Nacional de Identidad'],
            ['descripcion' => 'Carnet de extranjería'],
            ['descripcion' => 'Pasaporte'],
        ]);
    }
}
