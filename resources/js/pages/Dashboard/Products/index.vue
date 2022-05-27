<template>
    <div>
        <v-card :loading="loading">
            <v-card-title>
                <div class="row">
                    <div class="col-12">
                        Meus Produtos
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
                <v-form @submit.prevent="getProducts">
                    <div class="row">
                        <div class="col-md-3">
                            <v-text-field
                                outlined dense label="Buscar"
                                v-model="filter.term" clearable
                            />
                        </div>
                        <div class="col-md-2">
                            <v-btn color="primary" type="submit">Buscar</v-btn>
                        </div>
                    </div>
                </v-form>

                <v-simple-table>
                    <tbody>
                        <tr v-for="(prod, i) in products" :key="i">
                            <td class="my-2">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <v-img :src="prod.principal_image" class="mr-3" width="55" rounded elevation="2"/>
                                    </div> 
                                    <div class="col-md-10">
                                        <small>#{{ prod.id }}</small><br>
                                        <b>{{ prod.name }}</b><br>
                                        <small>{{ prod.brand }} - {{ prod.model }}</small>
                                        <v-chip x-small>{{ prod.amount }} Unidades</v-chip>
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
                            <td>R$ {{$commom.toMoney(prod.price)}}</td>
                            <td>
                                {{ $commom.dateFormat(prod.created_at) }} <br>
                                <small>{{ prod.created_for_humans }}</small>
                            </td>
                            <td>
                                <v-chip x-small :color="prod.status == 'paused'?'warning':'success'">
                                    {{prod.status_text}}
                                </v-chip>
                            </td>
                            <td>
                                <v-menu offset-x offset-y min-width="200">
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
                                        <v-list-item link @click="() => toggleStatus(prod.id)">
                                            <v-list-item-title v-if="prod.status == 'active'">
                                                <v-icon small class="mr-2">fa fa-pause</v-icon>
                                                Pausar
                                            </v-list-item-title>
                                            <v-list-item-title v-else>
                                                <v-icon small class="mr-2">fa fa-play</v-icon>
                                                Reativar
                                            </v-list-item-title>
                                        </v-list-item>
                                        <router-view
                                            is="v-list-item"
                                            :to="'/'+prod.slug"
                                        >
                                            <v-list-item-title>
                                                <v-icon small class="mr-2">fa fa-eye</v-icon>
                                                Prévia
                                            </v-list-item-title>
                                        </router-view>
                                        <v-list-item link @click="() => deleteProduct(prod.id)" v-if="prod.status == 'paused'">
                                            <v-list-item-title>
                                                <v-icon color="error" small class="mr-2">fa fa-trash</v-icon>
                                                Remover
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
        filter: {},

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
                data: this.filter,
                auth: true,
                success: resp => {
                    this.loading = false
                    this.products = [...resp]
                }
            })
        },

        toggleStatus(id){
            this.$commom.request({
                url: '/product/'+id+'/toggle-status',
                type: 'post',
                auth: true,
                success: resp => {
                    this.getProducts()
                }
            })
        },

        deleteProduct(id){

            this.$commom.confirm({
                title: 'Deseja deletar este produto?',
                message: 'Esteja ciente que esta ação é irreversível.',
                onConfirm: () => {

                    this.$commom.request({
                        url: '/product/'+id+'',
                        type: 'delete',
                        auth: true,
                        success: resp => {
                            this.getProducts()
                            this.$commom.success({title: 'Produto deletado'})
                        }
                    })
                }
            })
        },

    }
}
</script>