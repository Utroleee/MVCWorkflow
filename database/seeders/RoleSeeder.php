<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Administrador',
                'description' => 'Usuario con acceso total al sistema'
            ],
            [
                'name' => 'Cliente',
                'description' => 'Usuario que puede crear y dar seguimiento a tickets'
            ],
            [
                'name' => 'Técnico',
                'description' => 'Usuario que puede atender y resolver tickets'
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}