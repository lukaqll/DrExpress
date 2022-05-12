require('./bootstrap');

window.Vue = require('vue').default;

import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from '../js/routes.js'
import App from '../js/App.vue'
import vuetify from '../plugins/vuetify'
import commom from './services/commom.js';

Vue.use(VueRouter)
Vue.component('app', App)

const router = new VueRouter({
    mode: 'history',
    linkActiveClass: 'active',
    routes: routes
})
// router.beforeEach( async (to, from, next) => {
    
//     console.log('to', to)
//     console.log('from', from)
//     console.log('next', next)
    
//     if( to.name == 'login' )
//         return next()
    
//     const result = await commom.verifyLogin()
    
//     if( result.status == 'success' ){
//         return next({authUser: result.user})
//     } else {
//         if( to.name != 'login' )
//             return {name: 'login'}
//     }
// })

const app = new Vue({
    el: '#app',
    router,
    vuetify
});
