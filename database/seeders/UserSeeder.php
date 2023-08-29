<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Nilton Romero',
            'email' => 'niltondeveloper96@gmail.com',
            'password' => bcrypt('RegM7xSHhBuVG6'),
            'status' => 'active',
            'photo' => 'default-profile.jpg'
        ])->assignRole('Administrador');

        User::create([
            'name' => 'Rosa Sheen',
            'email' => 'rosmarasoc@rosmarasociados.com',
            'password' => bcrypt('123456789'),
            'status' => 'active',
            'photo' => 'default-profile.jpg'
        ])->assignRole('Administrador');

        User::create([
            'name' => 'Milagros',
            'email' => 'inscripciones@rosmarasociados.com',
            'password' => bcrypt('123456789'),
            'status' => 'active',
            'photo' => 'default-profile.jpg'
        ])->assignRole('Secretaria');

        User::create([
            'name' => 'Jhon Perez',
            'email' => 'hl@example.com',
            'password' => bcrypt('123456789'),
            'status' => 'inactive',
            'photo' => 'default-profile.jpg'
        ])->assignRole('Participante');

    }
}
