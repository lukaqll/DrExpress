<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
            [
                'id' => 1,
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'Administrador do sistema'
            ],
            [
                'id' => 2,
                'name' => 'Operador',
                'slug' => 'operator',
                'description' => 'Operador do sistema'
            ],
            [
                'id' => 3,
                'name' => 'Vendedor',
                'slug' => 'seller',
                'description' => ''
            ],
            [
                'id' => 4,
                'name' => 'Cliente',
                'slug' => 'client',
                'description' => ''
            ],
        ]);

        User::first()->roles()->attach(1);
    }
}
