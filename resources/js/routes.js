function page (path) {
    return () => import(/* webpackChunkName: '' */ `./pages/${path}`)
	.then(m => m.default || m)
}

const routes = [
    {
        path: '/login',
        name: 'auth.login',
        component: page('Auth/Login'),
        meta: {
            base: 'auth'
        }
    },
    {
        path: '/admin/permissions',
        name: 'admin.permissions',
        component: page('Admin/Permissions'),
        meta: {
            base: 'admin'
        }
    }
]



export default routes