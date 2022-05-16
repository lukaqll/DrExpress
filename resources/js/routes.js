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
            can: ['view-users']
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
        component: page('Admin/Adresses/Ufs'),
        meta: {
            base: 'admin'
        }
    },
    {
        path: '/admin/adresses/{:idUf}/cities',
        name: 'admin.adresses',
        component: page('Admin/Adresses/Cities'),
        meta: {
            base: 'admin'
        }
    },
]



export default routes