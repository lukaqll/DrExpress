<template>
    <div>
        <component :user="user" v-bind:is="base" >
            <router-view></router-view>
        </component>
    </div>
</template>

<script>
    import Admin from './components/Layouts/Admin.vue'
    import Auth from './components/Layouts/Auth.vue'
    export default {
        components: {Admin, Auth},
        data: () => ({
            userType: 1,
            user: {},
        }),
        mounted() {
        },
        computed: {
            base: function () { 
                return (this.$route.meta && this.$route.meta.base) ? this.$route.meta.base : 'auth'
            }
        },
    }
</script>
