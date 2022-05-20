require('./bootstrap');

window.Vue = require('vue').default;

import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from '../js/routes.js'
import App from '../js/App.vue'
import vuetify from '../plugins/vuetify'
import commom from './services/commom.js';
import utils from './services/utils';
import { createPinia, PiniaVuePlugin, storeToRefs } from 'pinia'
import { useStore } from './services/store'
import { VueMaskDirective } from 'v-mask'
import VueSweetalert2 from 'vue-sweetalert2';
import "../plugins/vuetify-mask";
import money from 'v-money'

Vue.use(VueRouter)
Vue.component('app', App)
Vue.directive('mask', VueMaskDirective); 
Vue.use(PiniaVuePlugin)
Vue.use(VueSweetalert2);
Vue.use(money, {precision:2, decimal:',', thousands:'.'})

const pinia = createPinia()

const router = new VueRouter({
    mode: 'history',
    linkActiveClass: 'active',
    routes: routes
})

const app = new Vue({
    el: '#app',
    router,
    vuetify,
    pinia
});

Vue.prototype.$can = utils.can
Vue.prototype.$hasRole = utils.hasRole
Vue.prototype.$commom = commom
Vue.prototype.$useStore = useStore()
Vue.prototype.$useStore = useStore()

router.beforeResolve( async (to, from, next) => {


    if( to.meta.base == 'auth' ){
        return next()
    }

    const store = useStore()

    // store.setLoading(true)
    const result = await Vue.prototype.$commom.verifyLogin()
    store.setLoading(false)
    
    const user = result.data

    if( result.status == 'success' ){

        await Vue.prototype.$useStore.setUser(user)

        if( to.meta.can ){
            if( utils.can( to.meta.can ) ){
                return next()
            } else {
                return router.push({name: '403'})
            }
        } else {
            return next()
        }

    } else {
        if( to.meta.base == 'auth' ){
            return next()
        } else {
            return router.push({name: 'auth.login'})
        }
    }
})



