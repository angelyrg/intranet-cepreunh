<?php

namespace Database\Seeders;

use App\Models\Intranet\Departamento;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Contracts\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(CarrerasSeeder::class);
        $this->call(DocentesSeeder::class);
        $this->call(AsignaturasSeeder::class);
        $this->call(TiposCiclosSeeder::class);
        $this->call(CiclosSeeder::class);
        $this->call(CarreraCicloSeeder::class);
        $this->call(AsignaturaCicloSeeder::class);
        $this->call(TiposDocumentosSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(DepartamentosSeeder::class);
        $this->call(EmpleadosSeeder::class);

        

        $this->call(DiscapacidadSeeder::class);
        $this->call(EstadoCivilSeeder::class);
        $this->call(GeneroSeeder::class);
        $this->call(IdentidadEtnicaSeeder::class);
        $this->call(FormaDePagoSeeder::class);
    }
}
