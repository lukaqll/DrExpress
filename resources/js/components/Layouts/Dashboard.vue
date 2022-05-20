<template>
    <div v-if="$useStore.user" class="dashboard">
        <v-app-bar 
            app
            class="m-3"
            rounded
            hide-on-scroll
            scroll-threshold="0"
            absolute
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
        <v-navigation-drawer
            v-model="drawer"
            :mini-variant.sync="mini"
            mini-variant-width="57"
            app
            class="pt-5"
            color="dash-drawer-bakground"
        >
            <v-list-item class="px-2" dark>
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
                color="dash-drawer-bakground"
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
                    exact
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
                        color="white"
                        dark
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
</template>

<script>
import utils from '../../services/utils'
export default {
    props: {defaultMini: Boolean},
    data() {
        return {
            drawer: this.initialDrawer,
            mini: this.defaultMini,
            topbarMenu: false,
            windowWidth: window.innerWidth,
            menu: [
                { 
                    title: "Início", 
                    icon: "fa fa-home",
                    link: '/dashboard',
                },
                { 
                    title: "Vendas", 
                    icon: "fa fa-tags",
                    link: '/dashboard/vendas',
                },
                { 
                    title: "Produtos", 
                    icon: "far fa-gem",
                    link: '/dashboard/produtos',
                },
                { 
                    title: "Locais Atendidos", 
                    icon: "fa fa-map-location-dot",
                    link: '/dashboard/locais-atendidos',
                },
                { 
                    title: "Meios de Pagamento", 
                    icon: "far fa-credit-card",
                    link: '/dashboard/meios-de-pagameto',
                },

                { 
                    title: "Meus Endereços", 
                    icon: "fa fa-map-marker-alt",
                    link: '/dashboard/meus-enderecos',
                },
                { 
                    title: "Meu Perfil", 
                    icon: "far fa-user",
                    link: '/dashboard/meu-perfil'
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
        },
        defaultMini(v){
            if(v) this.mini = v
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