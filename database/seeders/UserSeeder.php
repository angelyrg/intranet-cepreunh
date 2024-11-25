<?php

namespace Database\Seeders;

use App\Models\Intranet\TiposUsuarios;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TiposUsuarios::create(['descripcion' => 'Empleado']);
        TiposUsuarios::create(['descripcion' => 'Docentes']);
        TiposUsuarios::create(['descripcion' => 'Estudiantes']);

        User::create([
            'name' => 'Joel Neskenz',
            'username'  => 'jneskenz',
            'email'     => 'joel.neskenz@gmail.com',
            'password'  => Hash::make('password'),
            'tipos_usuarios_id' => 1,
            'sede_id' => 1,
        ])->assignRole('administrador');

        User::factory(20)->create();
        
    }
}
