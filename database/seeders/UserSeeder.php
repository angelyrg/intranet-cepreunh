<?php

namespace Database\Seeders;

use App\Models\Intranet\User;
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
        User::create([
            'name' => 'Joel Neskenz',
            'email' => 'joel.neskenz@gmail.com',
            'password' => Hash::make('password'),
        ])->assignRole('administrador');
    }
}
