<?php

namespace Database\Seeders;

use App\Models\Intranet\Sede;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SedesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Sede::create(['descripcion' => 'Huancavelica']);
        Sede::create(['descripcion' => 'Pampas']);
        Sede::create(['descripcion' => 'Andahuaylas']);

    }
}
