<template>
    <div>
        <component v-bind:is="base" >
            <router-view></router-view>
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
    import { useStore } from './services/store'

    export default {
        components: {Admin, Auth, Dashboard},
        data: () => ({
           useStore: useStore()
        }),
        mounted() {
            
        },
        computed: {
            base: function () { 
                return (this.$route.meta && this.$route.meta.base) ? this.$route.meta.base : 'auth'
            },

        },
    }
</script>
