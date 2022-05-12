import Login from '../js/pages/Auth/Login'
import Permissions from '../js/pages/Admin/Permission'
import commom from './services/commom'

const routes = [
    {
        path: '/login',
        name: 'auth.login',
        component: Login
    },
    {
        path: '/admin/permissions',
        name: 'admin.permissions',
        component: Permissions,
        beforeEnter
    }
]

const beforeEnter = ( to, from, next ) => {
    commom.verifyLogin().then(result => {
        if( result.status == 'success' ){
            next({authUser: result.user})
        } else {
            to('login')
        }
    })
    .catch(() => {
        to('login')
    })
}

export default routes