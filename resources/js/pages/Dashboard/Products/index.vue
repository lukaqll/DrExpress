<template>
    <div>
        <v-card :loading="loading">
            <v-card-title>
                <div class="row">
                    <div class="col-12">
                        Vendedores
                        <router-link
                            is="v-btn"
                            color="primary" text
                            to="/dashboard/produtos/novo"
                            class="float-right"
                        >
                            Novo Anúncio
                        </router-link>
                    </div>
                </div>
            </v-card-title>
            <v-card-text>
                <v-text-field v-model="search" clearable label="Buscar"/>

                <v-simple-table>
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Categoria</th>
                            <th>Preço</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(prod, i) in products" :key="i">
                            <td class="my-2">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <v-img :src="prod.principal_image" class="mr-3" width="55" rounded elevation="2"/>
                                    </div> 
                                    <div class="col-md-10">
                                        <small>#{{ prod.id }}</small> <br>
                                        <b>{{ prod.name }}</b> <br>
                                        <small>{{ prod.brand }} - {{ prod.model }}</small>
                                        <small>{{ prod.amount }} Unidade</small> <br>
                                    </div> 
                                </div>
                            </td>
                            <td>
                                <v-breadcrumbs :items="prod.category_flow" divider=">" class="p-0">
                                    <template v-slot:item="{ item }">
                                        <v-breadcrumbs-item
                                            :href="item.href"
                                            :disabled="item.disabled"
                                        >
                                            {{ item }}
                                        </v-breadcrumbs-item>
                                    </template>
                                </v-breadcrumbs>
                            </td>
                            <td> R$ {{$commom.toMoney(prod.price)}}</td>
                            <td>
                                <v-menu offset-y>
                                    <template v-slot:activator="{ on }">
                                        <v-btn icon v-on="on">
                                            <v-icon small>fa fa-ellipsis-vertical</v-icon>
                                        </v-btn>
                                    </template>
                                    <v-list dense>
                                        <router-view
                                            is="v-list-item"
                                            :to="`/dashboard/produtos/${prod.id}/editar`"
                                        >
                                            <v-list-item-title>
                                                <v-icon small class="mr-2">fa fa-edit</v-icon>
                                                Editar
                                            </v-list-item-title>
                                        </router-view>
                                        <v-list-item link>
                                            <v-list-item-title>
                                                <v-icon small class="mr-2">fa fa-pause</v-icon>
                                                Pausar Anúncio
                                            </v-list-item-title>
                                        </v-list-item>
                                        <v-list-item link >
                                            <v-list-item-title>
                                                <v-icon color="error" small class="mr-2">fa fa-trash</v-icon>
                                                Deletar
                                            </v-list-item-title>
                                        </v-list-item>
                                    </v-list>
                                </v-menu>

                            </td>
                        </tr>
                    </tbody>
                </v-simple-table>

            </v-card-text>
        </v-card>


    </div>
</template>
<script>
export default {
    data: () => ({
        products: [],
        loading: true,
        search: '',

        productHeaders: [
            {text: '', value: 'img'},
            {text: '', value: 'name'},
            {text: '', value: 'data'},
            {text: '', value: 'actions_header'},
        ],

    }),

    mounted(){
        this.getProducts()
    },

    methods: {
        getProducts() {
            this.loading = true
            this.$commom.request({
                url: '/product/me',
                auth: true,
                success: resp => {
                    this.loading = false
                    this.products = [...resp]
                }
            })
        },

        toggleStatus(id){
            this.$commom.request({
                url: '/product/me/'+id+'/toggle-status',
                type: 'put',
                auth: true,
                success: resp => {
                    this.getProducts()
                }
            })
        },

    }
}
</script>