<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoCivilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('estados_civiles')->insert([
            ['descripcion' => 'Soltero/a'],
            ['descripcion' => 'Casado/a'],
            ['descripcion' => 'Viudo/a'],
            ['descripcion' => 'Divorciado/a'],
            ['descripcion' => 'Conviviendo'],
            ['descripcion' => 'Separado/a'],
        ]);
    }
}
