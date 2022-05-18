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
            base: 'admin'
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
        name: 'admin.sellers',
        component: page('Admin/Sellers/Create'),
        meta: {
            base: 'admin',
            can: ['create-seller']
        }
    },
    {
        path: '/admin/sellers/:id/update',
        name: 'admin.sellers',
        component: page('Admin/Sellers/Update'),
        meta: {
            base: 'admin',
            can: ['update-seller']
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
]



export default routes