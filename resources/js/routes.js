function page (path) {
    return () => import(/* webpackChunkName: '' */ `./pages/${path}`)
	.then(m => m.default || m)
}

const routes = [
    {
        path: '*',
        name: '404',
        component: page('Errors/404.vue'),
        meta: { base: 'auth' }
    },
    {
        path: '/unauthorized',
        name: '403',
        component: page('Errors/403.vue'),
        meta: { base: 'auth' }
    },
    
    {
        path: '/login',
        name: 'auth.login',
        component: page('Auth/Login'),
        meta: { base: 'auth' }
    },

    /**
     * admin routes
     */
     {
        path: '/admin',
        name: 'admin.home',
        exact: true,
        component: page('Admin/Home'),
        meta: {
            base: 'admin',
        }
    },
    {
        path: '/admin/permissions',
        name: 'admin.permissions',
        component: page('Admin/Permissions'),
        meta: {
            base: 'admin',
            can: ['view-permission']
        }
    },
    {
        path: '/admin/users',
        name: 'admin.users',
        component: page('Admin/Users'),
        meta: {
            base: 'admin',
            can: ['view-user']
        }
    },
    {
        path: '/admin/profile',
        name: 'admin.profile',
        component: page('Admin/Profile'),
        meta: {
            base: 'admin'
        }
    },
    {
        path: '/admin/categories',
        name: 'admin.categories',
        component: page('Admin/Categories'),
        meta: {
            base: 'admin',
            can: ['view-category']
        }
    },
    {
        path: '/admin/categories/:id/specs',
        name: 'admin.specs',
        component: page('Admin/Categories/Specs'),
        meta: {
            base: 'admin'
        }
    },

    // adresses
    {
        path: '/admin/adresses',
        name: 'admin.adresses',
        component: page('Admin/Adresses'),
        meta: {
            base: 'admin',
            can: ['view-address']
        }
    },
    {
        path: '/admin/uf/:id/cities',
        name: 'admin.cities',
        component: page('Admin/Adresses/Cities'),
        meta: {
            base: 'admin',
            can: ['view-address']
        }
    },
    {
        path: '/admin/city/:id/districts',
        name: 'admin.districts',
        component: page('Admin/Adresses/Districts'),
        meta: {
            base: 'admin',
            can: ['view-address']
        }
    },

    {
        path: '/admin/sellers',
        name: 'admin.sellers',
        component: page('Admin/Sellers'),
        meta: {
            base: 'admin',
            can: ['view-seller']
        }
    },
    {
        path: '/admin/sellers/create',
        name: 'admin.sellers.create',
        component: page('Admin/Sellers/Create'),
        meta: {
            base: 'admin',
            can: ['create-seller']
        }
    },
    {
        path: '/admin/sellers/:id/update',
        name: 'admin.sellers.update',
        component: page('Admin/Sellers/Update'),
        meta: {
            base: 'admin',
            can: ['update-seller']
        }
    },
    {
        path: '/admin/brands',
        name: 'admin.brands',
        component: page('Admin/Brands'),
        meta: {
            base: 'admin',
            can: ['view-brands']
        }
    },








    /**
     * dashboard
     */
     {
        path: '/dashboard',
        name: 'dash.home',
        component: page('Dashboard/Home'),
        meta: {
            base: 'dashboard',
        }
    },
    {
        path: '/dashboard/meu-perfil',
        name: 'dash.profile',
        component: page('Dashboard/Profile'),
        meta: {
            base: 'dashboard',
        }
    },
    {
        path: '/dashboard/meus-enderecos',
        name: 'dash.adresses',
        component: page('Dashboard/Adresses'),
        meta: {
            base: 'dashboard',
        }
    },
    {
        path: '/dashboard/configuracoes',
        name: 'dash.config',
        component: page('Dashboard/Config'),
        meta: {
            base: 'dashboard'
        }
    },
    {
        path: '/dashboard/locais-atendidos',
        name: 'dash.config',
        component: page('Dashboard/ServedDistricts'),
        meta: {
            base: 'dashboard'
        }
    },

    // products
    {
        path: '/dashboard/produtos',
        name: 'dash.products',
        component: page('Dashboard/Products'),
        meta: {
            base: 'dashboard',
            can: ['view-product']
        }
    },
    {
        path: '/dashboard/produtos/novo',
        name: 'dash.product.create',
        component: page('Dashboard/Products/Create.vue'),
        meta: {
            base: 'dashboard',
            can: ['create-product'],
            defaultDrawer: 'mini'
        }
    },
    {
        path: '/dashboard/produtos/:id/editar',
        name: 'dash.product.update',
        component: page('Dashboard/Products/Update.vue'),
        meta: {
            base: 'dashboard',
            can: ['update-product']
        }
    },
    {
        path: '/dashboard/produtos/:id/editar/categoria',
        name: 'dash.product.update-category',
        component: page('Dashboard/Products/UpdateCategory.vue'),
        meta: {
            base: 'dashboard',
            can: ['update-product']
        }
    },
    

    /**
     * testes
     */
     {
        path: '/p/:slug',
        name: 'commerce.product',
        component: page('Commerce/Product'),
        meta: {
            base: 'commerce',
        }
    },
    {
        path: '/carrinho',
        name: 'commerce.cart',
        component: page('Commerce/Cart'),
        meta: {
            base: 'commerce',
        }
    },

]



export default routes