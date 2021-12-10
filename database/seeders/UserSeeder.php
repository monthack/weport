<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

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
            'name' => 'Administrador prueba',
            'email' => 'montsevm.03@gmail.com',
            'password' => bcrypt('Hola1234*'),
            'position' => 'Adminitrador de la plataforma',
            'phone' => '57-30088-88888',
            'extension' => '123',
            'enrollment' => 'Ad90JKMVM',
        ])->assignRole('admin');
        
        //developmentweport
        User::create([
            'name' => 'Administrador',
            'email' => 'developmentweport@weport.com',
            'password' => bcrypt('Hola1234*'),
            'position' => 'Adminitrador de la plataforma',
            'phone' => '57-30088-88888',
            'extension' => '8348',
            'enrollment' => 'Ad90JKDWT',
        ])->assignRole('admin');

        User::create([
            'name' => 'Empleado',
            'email' => 'empleadoweport@weport.com',
            'password' => bcrypt('Hola1234*'),
            'position' => 'Empleado de la plataforma',
            'phone' => '57-30088-88888',
            'extension' => '8348',
            'enrollment' => 'Em90PEPDW',
        ])->assignRole('empleado');
    }
}
