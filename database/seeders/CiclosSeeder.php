<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CiclosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ciclos')->insert([
            [
                'descripcion' => 'Periodo Académico 2025-II',
                'fecha_inicio' => '2024-09-02',
                'fecha_fin' => '2024-11-16',
                'duracion' => 11,
                'tipos_ciclos_id' => 1,
                'estado' => true,
            ],
        ]);
    }
}
