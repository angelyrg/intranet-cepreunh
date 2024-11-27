<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IdentidadEtnicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('identidades_etnicas')->insert([
            ['descripcion' => 'Quechua'],
            ['descripcion' => 'Aymara'],
            ['descripcion' => 'Amazonia'],
            ['descripcion' => 'Mestizo'],
            ['descripcion' => 'Blanco'],
            ['descripcion' => 'Afroperuano'],
            ['descripcion' => 'Otro'],
        ]);
    }
}
