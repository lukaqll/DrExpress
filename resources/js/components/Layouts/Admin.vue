<template>
    <div>
        <v-app-bar 
            color="deep-purple accent-4"
            dark
            style="z-index: 999"
        >
            <v-app-bar-nav-icon @click.stop="mini = !mini"></v-app-bar-nav-icon>
            <v-toolbar-title>{{ $useStore.user.name }}</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn icon>
                <v-icon>mdi-magnify</v-icon>
            </v-btn>
            <v-btn icon>
                <v-icon>mdi-filter</v-icon>
            </v-btn>
            <v-btn icon @click="logout">
               <v-icon>mdi-dots-vertical</v-icon>
            </v-btn>
        </v-app-bar>
        <div>
            <v-navigation-drawer
                v-model="drawer"
                :mini-variant.sync="mini"
                class="pt-16"
                app
            >
                <v-list-item class="px-2">
                    <v-list-item-avatar>
                        <v-img src="https://randomuser.me/api/portraits/men/85.jpg"></v-img>
                    </v-list-item-avatar>

                    <v-list-item-title>
                        {{$useStore.user.name}} <br>
                        <small>{{$useStore.user.email}}</small>
                    </v-list-item-title>

                    <v-btn 
                        x-small fab dark
                        color="deep-purple accent-4" 
                        @click.stop="mini = !mini"
                    >
                        <v-icon>mdi-chevron-left</v-icon>
                    </v-btn>
                </v-list-item>
                <v-divider></v-divider>
                <v-list dense>
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
                </v-list>
            </v-navigation-drawer>
            <v-main scroll app class="py-15 container">
                <slot />
            </v-main>
        </div>
    </div>
</template>

<script>
import utils from '../../services/utils'
export default {
    data() {
        return {
            drawer: true,
            menu: [
                { 
                    title: "Home", 
                    icon: "fa fa-home",
                    link: '/admin'
                },
                
                { 
                    title: "Usuários", 
                    icon: "fas fa-users",
                    link: '/admin/users',
                    can: ['view-users']
                },
                { 
                    title: "Permissões", 
                    icon: "fas fa-unlock",
                    link: '/admin/permissions',
                    can: ['view-permissions']
                },
                { 
                    title: "Endereços", 
                    icon: "fas fa-map-marker-alt",
                    link: '/admin/adresses',
                },
                { 
                    title: "Métodos de Pagamento", 
                    icon: "fas fa-credit-card",
                    link: '/admin/adresses',
                },
                { 
                    title: "Categorias", 
                    icon: "fa fa-boxes",
                    link: '/admin/categories'
                },
                { 
                    title: "Minha Conta", 
                    icon: "far fa-user",
                    link: '/admin/profile'
                },
            ],
            mini: false,
        };
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
        }
    },
};
</script>