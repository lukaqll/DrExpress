<?php

namespace Database\Seeders;

use App\Models\Role;
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
                'name' => 'Vendedor',
                'slug' => 'seller',
                'description' => ''
            ],
            [
                'id' => 3,
                'name' => 'Cliente',
                'slug' => 'client',
                'description' => ''
            ]
        ]);
    }
}
