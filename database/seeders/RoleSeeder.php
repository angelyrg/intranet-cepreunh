<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name' => 'administrador']);
        $role2 = Role::create(['name' => 'secretaria']);
        $role2 = Role::create(['name' => 'informes']);

        Permission::create(['name' => 'sedes'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'sedes.index'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'sedes.create'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'sedes.edit'])->syncRoles([$role1,$role2]);

        Permission::create(['name' => 'carreras'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'carreras.index'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'carreras.create'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'carreras.edit'])->syncRoles([$role1,$role2]);


    }
}
