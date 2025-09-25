<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear el rol de administrador si no existe
        $adminRole = Role::firstOrCreate(
            ['name' => 'Administrador'],
            ['description' => 'Usuario con acceso total al sistema']
        );

        // Crear el usuario administrador
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@mesadeayuda.com',
            'password' => Hash::make('admin12345'),
        ]);

        // Asignar el rol de administrador
        $admin->roles()->attach($adminRole->id);
    }
}