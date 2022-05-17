<template>
    <div v-if="$useStore.user">
        <v-app-bar 
            app
            absolute
            elevation="1"
        >
            <v-app-bar-nav-icon @click="toggleMenu"></v-app-bar-nav-icon>
            <v-toolbar-title>Dr. Express | Vendedor</v-toolbar-title>
            <v-spacer></v-spacer>

            <v-menu
                offset-x
                :nudge-width="150"
                rounded="lg"
                bottom 
                offset-y
            >
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                    icon
                    v-bind="attrs"
                    v-on="on"
              >
                <v-icon>mdi-dots-vertical</v-icon>
              </v-btn>
            </template>
                <v-list>
                    <v-list-item @click="logout" link>
                        <v-icon small class="mr-3">fa fa-sign-out-alt</v-icon>
                        Sair
                    </v-list-item>
                </v-list>
          </v-menu>
          
        </v-app-bar>
        <div>
            <v-navigation-drawer
                v-model="drawer"
                :mini-variant.sync="mini"
                app
                class="pt-5"
                color="petrol accent-4"
                dark
            >
                <v-list-item class="px-2" color="petrol accent-4">
                    <v-list-item-avatar>
                        <v-img src="https://randomuser.me/api/portraits/men/85.jpg"></v-img>
                    </v-list-item-avatar>

                    <v-list-item-title>
                        {{$useStore.user.name}} <br>
                        <small>{{$useStore.user.email}}</small>
                    </v-list-item-title>

                </v-list-item>
                <v-divider></v-divider>
                <v-list color="petrol accent-4" >
                    <router-link 
                        v-for="item in getMenu()" :key="item.title"
                        is="v-list-item"
                        active
                        :to="item.link"
                        link exact
                        class="my-2"
                    >

                        <v-list-item-icon>
                            <v-icon dense>{{ item.icon }}</v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>{{ item.title }}</v-list-item-title>
                        </v-list-item-content>
                    </router-link>
                    <v-list-item v-if="!mini || (mini && !drawer)">
                        <v-switch 
                            color="light"
                            inset
                            v-model="$vuetify.theme.isDark" 
                            :label="$vuetify.theme.isDark ? 'Dark Mode' : 'Light Mode'"
                        >
                            <template v-slot:label>
                                <span v-if="!$vuetify.theme.isDark">
                                    <v-icon color="orange" class="mr-2">fa fa-sun</v-icon>
                                    Light Mode
                                </span>
                                <span v-else>
                                    <v-icon class="mr-2">fa fa-moon</v-icon>
                                    Dark Mode
                                </span>
                            </template>
                        </v-switch>
                    </v-list-item>
                </v-list>
            </v-navigation-drawer>
            <v-main app style="padding-top: 100px">
                <v-container fluid>
                    <slot />
                </v-container>
            </v-main>
        </div>
    </div>
</template>

<script>
import utils from '../../services/utils'
export default {
    data() {
        return {
            drawer: this.initialDrawer,
            mini: false,
            topbarMenu: false,
            windowWidth: window.innerWidth,
            menu: [
                { 
                    title: "Home", 
                    icon: "fa fa-home",
                    link: '/dashboard',
                },
                { 
                    title: "Pedidos", 
                    icon: "fas fa-shopping-basket",
                    link: '/dashboard/orders',
                },
                { 
                    title: "Produtos", 
                    icon: "far fa-gem",
                    link: '/dashboard/products',
                },
                { 
                    title: "Locais Atendidos", 
                    icon: "fa fa-map-marker-alt",
                    link: '/dashboard/served-districts',
                },
                { 
                    title: "Meios de Pagamento", 
                    icon: "far fa-credit-card",
                    link: '/dashboard/payment-methods',
                },

                { 
                    title: "Minha Conta", 
                    icon: "far fa-user",
                    link: '/dashboard/profile'
                },
            ],
        };
    },

    mounted(){
        if( !this.$hasRole(['seller']) )
            this.$router.push('/login?message=Sem Permissão')
    },
    computed: {
        initialDrawer(v){
            return this.windowWidth <= 1250 ? true : false
        },
    },
    watch: {
        '$vuetify.theme.isDark': function(isDark){
            localStorage.setItem('darkmode', isDark?'1':'0')
            window.location.reload()
        }
    },
    methods: {
        logout() {
            this.$commom.request({
                url: "/logout",
                type: "post",
                auth: true,
                success: (resp) => {
                    localStorage.removeItem("auth_token");
                    this.$useStore.user = null
                    this.$router.push("/login");
                },
                error: () => {
                    localStorage.removeItem("auth_token");
                    this.$router.push("/login");
                },
            });
        },

        getMenu(){
            return utils.getMenu(this.menu)
        },

        toggleMenu(){
            if( this.windowWidth <= 1250 ){
                this.drawer = !this.drawer
                this.mini = false
            } else {
                this.drawer = true;
                this.mini = !this.mini
            }
        },

    },
};
</script>