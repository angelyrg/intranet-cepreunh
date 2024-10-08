<?php

namespace Database\Seeders;

use App\Models\Intranet\Departamento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartamentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Departamento::create([
            'descripcion' => 'Gerente',
        ]);
    }
}
