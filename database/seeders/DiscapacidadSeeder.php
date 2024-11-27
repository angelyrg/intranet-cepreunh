<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscapacidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('discapacidades')->insert([
            ['descripcion' => 'Motora'],
            ['descripcion' => 'Auditiva'],
            ['descripcion' => 'Visual'],
            ['descripcion' => 'Intelectual'],
            ['descripcion' => 'Psicosocial'],
            ['descripcion' => 'Múltiple'],
            ['descripcion' => 'Del Espectro Autista'],
            ['descripcion' => 'Del Habla'],
        ]);
    }
}
