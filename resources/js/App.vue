<template>
    <div>
        <component v-bind:is="base" :defaultMini="$route.meta.defaultDrawer=='mini'">
            <transition :name="transition" mode="out-in">
                <router-view></router-view>
            </transition>
        </component>
        <div class="loader-overlay" v-if="useStore.loading">
            <div class="loader">
                <div class="ball"></div>
                <div class="ball"></div>
                <div class="ball"></div>
                <span>Loading...</span>
            </div>
        </div>
    </div>
</template>

<script>
    import Admin from './components/Layouts/Admin.vue'
    import Auth from './components/Layouts/Auth.vue'
    import Dashboard from './components/Layouts/Dashboard.vue'
    import Commerce from './components/Layouts/Commerce.vue'
    import { useStore } from './services/store'

    export default {
        components: {Admin, Auth, Dashboard, Commerce},
        data: () => ({
           useStore: useStore(),
           defaultMiniDrawer: false,
        }),
        mounted() {
            
        },
        watch: {
            '$route.meta': function(meta){
                if( meta.defaultDrawer ){
                    if( meta.defaultDrawer == 'mini' ){
                        this.defaultMiniDrawer = true
                    }
                }
            }
        },
        computed: {
            base: function () { 
                return (this.$route.meta && this.$route.meta.base) ? this.$route.meta.base : 'auth'
            },
            transition: function () {
                return this.$route.meta.transition || 'fade'
            }

        },
        methods: {
            verifyMini(){
                const meta = this.$route.meta
                if( meta.defaultDrawer ){
                    if( meta.defaultDrawer == 'mini' ){
                        this.mini = true
                    }
                }
            }
        }    
    }
</script>
