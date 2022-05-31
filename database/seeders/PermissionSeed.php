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
            [
                'name' => 'Altera Senha de Usuário',
                'slug' => 'update-user-password',
                'topic' => 'user',
                'description' => 'Pode alterar a senha de usuários',
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
            [
                'name' => 'Ver Endereço de Usuários',
                'slug' => 'view-user-address',
                'topic' => 'address',
                'description' => 'Pode ver endereços de usuários',
                'active' => 1
            ],
            [
                'name' => 'Edita Endereço de Usuários',
                'slug' => 'update-user-address',
                'topic' => 'address',
                'description' => 'Pode editar endereços de usuários',
                'active' => 1
            ],
            [
                'name' => 'Cria Endereço de Usuários',
                'slug' => 'create-user-address',
                'topic' => 'address',
                'description' => 'Pode criar endereços de usuários',
                'active' => 1
            ],

            // products create-products
            [
                'name' => 'Cria Produtos',
                'slug' => 'create-product',
                'topic' => 'product',
                'description' => 'Pode criar produtos',
                'active' => 1
            ],
            [
                'name' => 'Edita Produtos',
                'slug' => 'update-product',
                'topic' => 'product',
                'description' => 'Pode Editar produtos',
                'active' => 1
            ],
            [
                'name' => 'Ver Produtos',
                'slug' => 'view-product',
                'topic' => 'product',
                'description' => 'Pode ver produtos',
                'active' => 1
            ],


            // brands
            [
                'name' => 'Ver Marcas',
                'slug' => 'view-brand',
                'topic' => 'brands',
                'description' => 'Pode ver marcas',
                'active' => 1
            ],
            [
                'name' => 'Criar Marcas',
                'slug' => 'create-brand',
                'topic' => 'brands',
                'description' => 'Pode criar marcas',
                'active' => 1
            ],
            [
                'name' => 'Editar Marcas',
                'slug' => 'update-brand',
                'topic' => 'brands',
                'description' => 'Pode editar marcas',
                'active' => 1
            ],
            [
                'name' => 'Deletar Marcas',
                'slug' => 'delete-brand',
                'topic' => 'brands',
                'description' => 'Pode deletar marcas',
                'active' => 1
            ],


            // served districts
            [
                'name' => 'Criar Locais Atendidos',
                'slug' => 'create-served-district',
                'topic' => 'address',
                'description' => 'Pode criar locais atendidos',
                'active' => 1
            ],
            [
                'name' => 'Editar Locais Atendidos',
                'slug' => 'update-served-district',
                'topic' => 'address',
                'description' => 'Pode editar locais atendidos',
                'active' => 1
            ],
            [
                'name' => 'Deletar Locais Atendidos',
                'slug' => 'delete-served-district',
                'topic' => 'address',
                'description' => 'Pode deletar locais atendidos',
                'active' => 1
            ],


            // cart
            [
                'name' => 'Ver Carrinho de Compras',
                'slug' => 'view-cart',
                'topic' => 'cart',
                'description' => 'Pode ver carrinhos de compra',
                'active' => 1
            ],
            [
                'name' => 'Criar Carrinho de Compras',
                'slug' => 'create-cart',
                'topic' => 'cart',
                'description' => 'Pode criar carrinhos de compra',
                'active' => 1
            ],
            [
                'name' => 'Editar Carrinho de Compras',
                'slug' => 'update-cart',
                'topic' => 'cart',
                'description' => 'Pode editar carrinhos de compra',
                'active' => 1
            ],
            [
                'name' => 'Deletar Carrinho de Compras',
                'slug' => 'delete-cart',
                'topic' => 'cart',
                'description' => 'Pode deletar carrinhos de compra',
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
