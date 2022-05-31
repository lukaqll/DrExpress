<template>
    <div v-if="$useStore.user" class="admin">
        <v-app-bar 
            app
            hide-on-scroll
            absolute
            height="80"
        >
            <!-- elevate-on-scroll -->
            <v-toolbar-title>Dr. Express</v-toolbar-title>
            <v-spacer></v-spacer>

            <!-- favorites -->
            <v-menu
                offset-x
                offset-y
                :nudge-width="400"
                rounded="lg"
                bottom large
                :close-on-content-click="false"
                @input="getFavoriteProducts"
            >
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                icon
                v-bind="attrs"
                v-on="on"
              >
                <v-icon small>far fa-heart</v-icon>
              </v-btn>
            </template>
                <v-card :loading="favoriteProductsLoading">
                    <v-list v-if="favoriteProducts.length">
                        <v-list-item 
                            is="v-list-item"
                            v-for="(prod, i) in favoriteProducts" :key="i"
                        >
                            <v-list-item-icon>
                                <v-img width="100" :src="prod.principal_image"/>
                            </v-list-item-icon>
                            <v-list-item-title>
                                <router-link link :to="`/p/${prod.slug}`">
                                    {{ prod.name }} 
                                </router-link> <br>
                                <small>Por {{prod.user_name}}</small> <br>
                                <span>R$ {{ $commom.toMoney(prod.price) }}</span> <br>
                                <v-btn color="primary" small plain class="p-0" @click="() => removeFavorite(prod.id)">
                                    <small>Remover</small>
                                </v-btn>
                            </v-list-item-title>
                        </v-list-item>
                    </v-list>
                    <v-card-title v-else>Nenhum produto favorito ainda</v-card-title>
                </v-card>
            </v-menu>

            <!-- cart -->
            <v-btn icon to="/carrinho">
                <v-icon small>fa fa-shopping-cart</v-icon>
            </v-btn>

            <v-menu
                offset-x
                :nudge-width="150"
                rounded="lg"
                bottom large
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
                    <router-link
                        v-if="$hasRole(['admin', 'operator'])"
                        is="v-list-item"
                        to="/dashboard"
                    >
                        Área do Admin
                    </router-link>
                </v-list>
          </v-menu>
          
        </v-app-bar>
        <div>
            <v-main app style="padding-top: 100px;">
                <v-container fluid>
                    <div class="d-flex justify-content-center w-100">
                        <slot />
                    </div>
                </v-container>
            </v-main>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            windowWidth: window.innerWidth,
            favoriteProducts: [],
            favoriteProductsLoading: false,
        };
    },

    mounted(){
        if( !this.$hasRole(['admin', 'operator']) ){
            this.$router.push('/login?message=Sem Permissão')
        }
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

        getFavoriteProducts(){
            this.favoriteProductsLoading = true
            this.$commom.request({
                url: "/favorite-product",
                type: "get",
                auth: true,
                setError: true,
                success: (resp) => {
                    this.favoriteProductsLoading = false
                    this.favoriteProducts = [...resp]
                },
                error: () => this.favoriteProductsLoading = false
            });
        },
        removeFavorite(id){
            this.$commom.request({
                url: '/favorite-product/',
                type: 'post',
                data: {id_product: id},
                auth: true,
                success: resp => {
                    this.getFavoriteProducts()
                }
            })
        },

        

    },
};
</script>