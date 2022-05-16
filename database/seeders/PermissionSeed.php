<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
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
                'name' => 'Ver Usuários',
                'slug' => 'view-user',
                'topic' => 'user',
                'description' => 'Pode ver usuários',
                'active' => 1
            ],
            [
                'name' => 'Criar Usuário',
                'slug' => 'create-user',
                'topic' => 'user',
                'description' => 'Pode criar usuários',
                'active' => 1
            ],
            [
                'name' => 'Editar Usuário',
                'slug' => 'update-user',
                'topic' => 'user',
                'description' => 'Pode editar usuários',
                'active' => 1
            ],
            [
                'name' => 'Deletar Usuário',
                'slug' => 'delete-user',
                'topic' => 'user',
                'description' => 'Pode deletar usuários',
                'active' => 1
            ],

            [
                'name' => 'Ver Permissão',
                'slug' => 'view-permission',
                'topic' => 'permission',
                'description' => 'Pode ver permissões',
                'active' => 1
            ],
            [
                'name' => 'Criar Permissão',
                'slug' => 'create-permission',
                'topic' => 'permission',
                'description' => 'Pode criar permissões',
                'active' => 1
            ],
            [
                'name' => 'Editar Permissão',
                'slug' => 'update-permission',
                'topic' => 'permission',
                'description' => 'Pode editar permissões',
                'active' => 1
            ],
            [
                'name' => 'Deletar Permissão',
                'slug' => 'delete-permission',
                'topic' => 'permission',
                'description' => 'Pode deletar permissões',
                'active' => 1
            ],
            
        ]);
    }
}
