<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::insert([
            [
                'id' => 1,
                'name' => 'Criar Usuário',
                'slug' => 'create-user',
                'description' => 'Pode criar usuários',
                'active' => 1
            ],
            [
                'id' => 2,
                'name' => 'Editar Usuário',
                'slug' => 'update-user',
                'description' => 'Pode editar usuários',
                'active' => 1
            ],
            [
                'id' => 3,
                'name' => 'Deletar Usuário',
                'slug' => 'delete-user',
                'description' => 'Pode deletar usuários',
                'active' => 1
            ],
            
        ]);
    }
}
