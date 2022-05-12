<template>
    <div>
        <component :user="user" v-bind:is="base" >
            <router-view></router-view>
        </component>
    </div>
</template>

<script>
    import Admin from './components/Layouts/Admin.vue'
    import AuthBase from './components/Layouts/AuthBase.vue'
    export default {
        components: {Admin, AuthBase},
        data: () => ({
            userType: 1,
            user: {},
            base: null
        }),
        mounted() {
            this.verifyBase()
            this.$root.$on('login', (data) => {
                this.user = data
                this.verifyBase()
            });

        },
        methods: {
            verifyBase() {
                
                console.log(this.$route)
                if( this.$route.name.split('.')[0] == 'auth' ){
                    this.base = 'auth-base'
                } else {
                    this.base = 'admin'
                }
            }
        }
    }
</script>
