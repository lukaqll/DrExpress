require('./bootstrap');

window.Vue = require('vue').default;

import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from '../js/routes.js'
import App from '../js/App.vue'
import vuetify from '../plugins/vuetify'
import commom from './services/commom.js';
import fa from '../plugins/fontawesome/js/all.min.js'

Vue.use(VueRouter)
Vue.component('app', App)
Vue.prototype.$commom = commom

const router = new VueRouter({
    mode: 'history',
    linkActiveClass: 'active',
    routes: routes
})
router.beforeEach( async (to, from, next) => {
        
    if( to.meta.base == 'auth' )
        return next()
    
    const result = await commom.verifyLogin()
    if( result.status == 'success' ){
        return next({authUser: result.user})
    } else {
        if( to.meta.base == 'auth' ){
            return next()
        } else {
            router.push({name: 'auth.login'})
        }
    }
})

const app = new Vue({
    el: '#app',
    router,
    vuetify
});
