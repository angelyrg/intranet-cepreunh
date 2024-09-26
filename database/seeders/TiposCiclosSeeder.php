<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposCiclosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipos_ciclos')->insert([
            ['descripcion' => 'Ciclo regular'],
            ['descripcion' => 'Ciclo intensivo'],
        ]);
    }
}
