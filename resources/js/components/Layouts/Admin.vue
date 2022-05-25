<template>
    <div v-if="$useStore.user" class="admin">
        <v-app-bar 
            app
            class="m-3"
            rounded
            hide-on-scroll
            scroll-threshold="0"
            absolute
        >
            <!-- elevate-on-scroll -->
            <v-app-bar-nav-icon @click="toggleMenu"></v-app-bar-nav-icon>
            <v-toolbar-title>Dr. Express</v-toolbar-title>
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
                    <router-link
                        v-if="$hasRole('seller')"
                        is="v-list-item"
                        to="/dashboard"
                    >
                        Área do lojista
                    </router-link>
                </v-list>
          </v-menu>
          
        </v-app-bar>
        <div>
            <v-navigation-drawer
                floating
                v-model="drawer"
                :mini-variant.sync="mini"
                app 
                class="pt-5"
                color="admin-drawer-bakground"
                mini-variant-width="57"
            >
                <v-list-item class="px-2">
                    <v-list-item-avatar>
                        <v-img :src="$useStore.user.picture"></v-img>
                    </v-list-item-avatar>

                    <v-list-item-title>
                        {{$useStore.user.name}} <br>
                        <small>{{$useStore.user.email}}</small>
                    </v-list-item-title>

                </v-list-item>
                <v-divider></v-divider>
                <v-list 
                    color="admin-drawer-bakground" 
                    dense
                    class="p-2"
                >
                    <router-link 
                        v-for="item in getMenu()" :key="item.title"
                        is="v-list-item"
                        :to="item.link"
                        link 
                        class="my-2"
                        active-class="menu-active"
                        :exact="item.exact"
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
                            dense inset
                            v-model="$vuetify.theme.isDark" 
                            :label="$vuetify.theme.isDark ? 'Dark Mode' : 'Light Mode'"
                        >
                            <template v-slot:label>
                                <span v-if="!$vuetify.theme.isDark">
                                    <v-icon color="orange" class="mr-2">fa fa-sun</v-icon>
                                </span>
                                <span v-else>
                                    <v-icon class="mr-2">fa fa-moon</v-icon>
                                </span>
                            </template>
                        </v-switch>
                    </v-list-item>
                </v-list>
            </v-navigation-drawer>
            <v-main app style="padding-top: 100px; margin: 7px;">
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
                    link: '/admin',
                    exact: true
                },
                { 
                    title: "Vendedores", 
                    icon: "fas fa-store",
                    link: '/admin/sellers',
                    can: ['view-seller']
                },
                
                { 
                    title: "Endereços", 
                    icon: "fas fa-map-marker-alt",
                    link: '/admin/adresses',
                    can: ['view-address']
                },
                { 
                    title: "Meios de Pagamento", 
                    icon: "fas fa-credit-card",
                    link: '/admin/paymento-methods',
                    can: ['view-address']

                },
                { 
                    title: "Categorias", 
                    icon: "fa fa-boxes",
                    link: '/admin/categories',
                    can: ['view-category']
                },
                { 
                    title: "Marcas", 
                    icon: "fa fa-copyright",
                    link: '/admin/brands',
                    can: ['view-brands']
                },
                { 
                    title: "Permissões", 
                    icon: "fas fa-unlock",
                    link: '/admin/permissions',
                    can: ['view-permission']
                },
                { 
                    title: "Usuários", 
                    icon: "fas fa-users",
                    link: '/admin/users',
                    can: ['view-user']
                },
                { 
                    title: "Minha Conta", 
                    icon: "far fa-user",
                    link: '/admin/profile'
                },
            ],
        };
    },

    mounted(){
        if( !this.$hasRole(['admin', 'operator']) ){
            this.$router.push('/login?message=Sem Permissão')
        }
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
                    this.$useStore.setUser(null)
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