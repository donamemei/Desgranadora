<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Administrador
        User::updateOrCreate(
            ['email' => 'admin@desgranadora.com'],
            [
                'name'     => 'Administrador',
                'password' => Hash::make('admin1234'),
                'rol'      => 'administrador',
            ]
        );

        // Supervisor
        User::updateOrCreate(
            ['email' => 'supervisor@desgranadora.com'],
            [
                'name'     => 'Supervisor',
                'password' => Hash::make('super1234'),
                'rol'      => 'supervisor',
            ]
        );

        // Operador
        User::updateOrCreate(
            ['email' => 'operador@desgranadora.com'],
            [
                'name'     => 'Operador',
                'password' => Hash::make('oper1234'),
                'rol'      => 'operador',
            ]
        );

        $this->command->info('Usuarios creados: admin / supervisor / operador');
    }
}
