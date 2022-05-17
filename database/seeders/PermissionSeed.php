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

        $permissions = [
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

            // permissions
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

            // category
            [
                'name' => 'Ver Categoria',
                'slug' => 'view-category',
                'topic' => 'category',
                'description' => 'Pode ver categorias',
                'active' => 1
            ],
            [
                'name' => 'Criar Categoria',
                'slug' => 'create-category',
                'topic' => 'category',
                'description' => 'Pode criar categorias',
                'active' => 1
            ],
            [
                'name' => 'Editar Categoria',
                'slug' => 'update-category',
                'topic' => 'category',
                'description' => 'Pode editar categorias',
                'active' => 1
            ],
            [
                'name' => 'Deletar Categoria',
                'slug' => 'delete-category',
                'topic' => 'category',
                'description' => 'Pode deletar categorias',
                'active' => 1
            ],

            // adresses
            [
                'name' => 'Ver Endereço',
                'slug' => 'view-address',
                'topic' => 'address',
                'description' => 'Pode ver endereços',
                'active' => 1
            ],
            [
                'name' => 'Criar Endereço',
                'slug' => 'create-address',
                'topic' => 'address',
                'description' => 'Pode criar endereços',
                'active' => 1
            ],
            [
                'name' => 'Editar Endereço',
                'slug' => 'update-address',
                'topic' => 'address',
                'description' => 'Pode editar endereços',
                'active' => 1
            ],
            [
                'name' => 'Deletar Endereço',
                'slug' => 'delete-address',
                'topic' => 'address',
                'description' => 'Pode deletar endereços',
                'active' => 1
            ],
            
        ];

        foreach($permissions as $permission){
            $exists = Permission::where('slug', $permission['slug'])->first();
            if( empty($exists) ){
                Permission::insert($permission);
            }
        }
        
    }
}
