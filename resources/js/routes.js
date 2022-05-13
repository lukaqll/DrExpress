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
            can: ['view-permissions']
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
]



export default routes