<template>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <v-card :loading="loading">
                <v-card-title>
                    <div class="row">
                        <div class="col-12">
                            Marcas
                            <v-btn v-if="$can('create-brand')" text color="primary" class="float-right" @click="newBrandModal = true">Nova Marca</v-btn>
                        </div>
                    </div>
                </v-card-title>
                <v-card-text>
                    <v-data-table
                        :headers="brandsHeaders"
                        :items="brands"
                    >
                        <template v-slot:item.roles_header="{ item }">
                            <span class="badge rounded-full bg-primary mr-1" v-for="(role, i) in item.roles" :key="i">{{role.name}}</span>
                        </template>
                        <template v-slot:item.actions_header="{ item }">
                            <v-btn v-if="$can('update-brand')" icon color="primary" @click="() => getBrand(item.id)">
                                <v-icon small>fa fa-edit</v-icon>
                            </v-btn>
                            <v-btn v-if="$can('delete-brand')" @click="() => deleteBrand(item.id)" icon :color="item.status == 'A' ? 'success' : 'error'" data-toggle="tooltip" :title="item.status == 'A' ? 'Desativar' : 'Ativar'">
                                <v-icon small>fa fa-trash</v-icon>
                            </v-btn>
                        </template>
                    </v-data-table>
                </v-card-text>
            </v-card>
        </div>

        <!-- create brand -->
        <v-dialog max-width="500" v-model="newBrandModal">
            <template v-slot:default="dialog">
                <v-card>
                    <v-card-title>Nova Marca</v-card-title>
                    <v-card-text>
                        <v-form ref="createForm" id="new-brand" @submit.prevent="createBrand">
                            <div class="row">
                                <div class="col-md-12">
                                    <v-text-field autofocus v-model="brand.name" label="nome"/>
                                </div>
                            </div>
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-btn text @click="dialog.value = false">Fechar</v-btn>
                        <v-btn form="new-brand" :loading="saveLoading" type="submit" color="primary">Salvar</v-btn>
                    </v-card-actions>
                </v-card>
            </template>
        </v-dialog>

        <!-- edit user -->
        <v-dialog max-width="500" v-model="editBrandModal">
            <template v-slot:default="dialog">
                <v-card>
                    <v-card-title>Editar Marca</v-card-title>
                    <v-card-text>
                        <v-form ref="updateForm" id="edit-brand" @submit.prevent="updateBrand">
                            <div class="row">
                                <div class="col-md-12">
                                    <v-text-field autofocus v-model="editBrand.name" label="nome"/>
                                </div>
                            </div>
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-btn text @click="dialog.value = false">Fechar</v-btn>
                        <v-btn form="edit-brand" :loading="saveLoading" type="submit" color="primary">Salvar</v-btn>
                    </v-card-actions>
                </v-card>
            </template>
        </v-dialog>

    </div>
</template>
<script>
export default {
    data: () => ({
        brands: [],
        brand: {},
        editBrand: {},
        newBrandModal: false,
        editBrandModal: false,
        saveLoading: false,
        loading: true,

        brandsHeaders: [
            {text: 'Nome', value: 'name'},
            {text: '', value: 'actions_header'},
        ],

    }),

    mounted(){
        this.getBrands()
    },

    watch: {
        newBrandModal: function(v) {
            !v ? this.brand = {} : null
        },
        editBrandModal: function(v) {
            !v ? this.editBrand = {} : null

        }
    },

    methods: {
        getBrands() {
            this.loading = true
            this.$commom.request({
                url: '/brand',
                auth: true,
                success: resp => {
                    this.loading = false
                    this.brands = [...resp]
                }
            })
        },

        getBrand(id) {
            const brand = this.brands.find(b => b.id == id)
            this.editBrand = {...brand}
            this.editBrandModal = true
        },

        createBrand(){
            if( this.$can('create-brand') ){
                this.saveLoading = true
                this.$commom.request({
                    url: '/brand',
                    type: 'post',
                    auth: true,
                    data: this.brand,
                    setError: true,
                    success: resp => {
                        this.getBrands()
                        this.saveLoading = false
                        this.brand = {}
                    },
                    error: e => {
                        this.saveLoading = false
                    }
                })
            }
        },

        updateBrand(){
            if( this.$can('update-brand') ){
                this.saveLoading = true
                this.$commom.request({
                    url: '/brand/'+this.editBrand.id,
                    type: 'put',
                    auth: true,
                    data: this.editBrand,
                    setError: true,
                    success: resp => {
                        this.getBrands()
                        this.saveLoading = false
                        this.editBrandModal = false
                        this.editBrand = {}
                    },
                    error: e => {
                        this.saveLoading = false
                    }
                })
            }
        },

        deleteBrand(id){
            if( this.$can('delete-brand') ){
                this.$commom.confirm({
                    title: 'Deseja deletar esta marca?',
                    onConfirm: () => {
                        this.saveLoading = true
                        this.$commom.request({
                            url: '/brand/'+id,
                            type: 'delete',
                            auth: true,
                            setError: true,
                            success: resp => {
                                this.getBrands()
                                this.saveLoading = false
                                this.editBrandModal = false
                                this.editBrand = {}
                            },
                            error: e => {
                                this.saveLoading = false
                            }
                        })
                    }
                })
            }
        },

    }
}
</script>