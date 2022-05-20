<template>
    <div>
        <v-card :loading="loading">
            <v-card-title>
                <div class="row">
                    <div class="col-md-12">
                        Categorias
                        <v-btn v-if="$can('create-category')" text color="primary" class="float-right" @click="editCategoryModal = false; category = {}">Nova Categoria</v-btn>
                    </div>
                </div>
            </v-card-title>
            <v-card-text>
                <div class="row">
                    <div class="col-md-6">
                        <v-text-field
                            v-model="search"
                            label="Buscar"
                            flat
                            clearable
                            clear-icon="mdi-close-circle-outline"
                        ></v-text-field>

                        <!-- treeview -->
                        <v-treeview 
                            :items="categoriesTree"
                            rounded
                            hoverable
                            activatable
                            transition
                            dense
                            open-on-click
                            :search="search"
                            expand-icon="mdi-chevron-down"
                        >

                            <template v-slot:label="{ item }">
                                <v-btn text small @click="() => getCategory(item.id)">{{item.name}}</v-btn>
                                <span x-small v-if="item.required_cro" class="badge bg-primary rounded-xl p-1">
                                    <small>CRO</small>
                                </span>

                                <v-badge x-small v-if="item.specs && item.specs.length" color="primary" :content="item.specs.length"/>
                            </template>

                            <template v-slot:append="{ item }">
                                <v-btn v-if="item.linkable" small icon color="success" @click="() => linkCategory(item.id)">
                                    <v-icon small >fa fa-plus</v-icon>
                                </v-btn>
                                <router-link v-else :to="`/admin/categories/${item.id}/specs`" style="text-decoration: none">
                                    <v-btn  small icon color="error">
                                        <v-icon small >fa fa-chevron-right</v-icon>
                                    </v-btn>
                                </router-link>
                            </template>
                        </v-treeview>
                    </div>
                    <div class="col-md-6" style="border-left: solid 1px #ddd">
                         <div v-if="editCategoryModal">
                            <h5>Editar Categoria</h5>
                            <v-form ref="createForm" id="update-category" @submit.prevent="updateCategory">
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-text-field autofocus v-model="editCategory.name" label="nome"/>
                                    </div>
                                    <div class="col-md-6">
                                        <v-checkbox class="m-0" v-model="editCategory.required_cro" label="CRO Obrigatório"/>
                                        <v-checkbox :disabled="!editCategory.id_category" class="m-0" v-model="editCategory.linkable" label="Linkável"/>
                                    </div>
                                    <div class="col-md-12">
                                        <v-autocomplete 
                                            v-model="editCategory.id_category" 
                                            label="Categoria Pai"
                                            :items="categoriesOptions"
                                            clearable clear-icon="mdi-close-circle-outline"
                                        />
                                    </div>
                                </div>
                            </v-form>
                            <div class="d-flex justify-end">
                                <v-btn v-if="$can('delete-category')" text @click="deleteCategory" color="error">Excluir</v-btn>
                                <v-btn v-if="$can('update-category')" form="update-category" :loading="saveLoading" type="submit" color="primary">Salvar</v-btn>
                            </div>
                        </div>
                        <div v-else-if="$can('create-category')">
                            <h5>Nova Categoria</h5>
                            <v-form ref="createForm" id="new-category" @submit.prevent="createCategory">
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-text-field autofocus v-model="category.name" label="nome"/>
                                    </div>
                                    <div class="col-md-6">
                                        <v-checkbox class="m-0" value="1" v-model="category.required_cro" label="CRO Obrigatório"/>
                                        <v-checkbox v-if="showLinkable" class="m-0" value="1" v-model="category.linkable" label="Linkável"/>
                                    </div>
                                    <div class="col-md-12">
                                        <v-autocomplete 
                                            v-model="category.id_category" 
                                            label="Categoria Pai"
                                            :items="categoriesOptions"
                                            clearable clear-icon="mdi-close-circle-outline"
                                        />
                                    </div>
                                </div>
                            </v-form>
                            <div class="d-flex justify-end">
                                <v-btn v-if="$can('create-category')" form="new-category" :loading="saveLoading" type="submit" color="primary">Salvar</v-btn>
                            </div>
                        </div>
                    </div>
                </div>
            </v-card-text>
        </v-card>

    </div>
</template>
<script>
export default {
    data: () => ({
        categoriesTree: [],
        categories: [],
        category: {},
        editCategory: {},
        editCategoryModal: false,
        saveLoading: false,
        loading: true,
        search: '',
        active: [],
        showLinkable: false
    }),

    mounted(){
        this.getCategoriesTree()
        this.getCategories()
    },

    watch: {
        editCategoryModal: function(v) {
            !v ? this.editCategory = {} : null

        }
    },

    computed: {
        categoriesOptions() {
            return this.categories.map(p => {
                if(p.linkable)
                return {text: p.name, value: p.id}
            })
        },

        selected () {
            if (!this.active.length) 
                return undefined

            const id = this.active[0]
            return id
        },
    },

    watch: {
        selected(v){
            if(v)
                this.getCategory(v)
        },
        'category.id_category': function(v){
            if(!v){
                this.showLinkable = false
            } else {
                this.showLinkable = true
            }

        }
    },

    methods: {
        getCategoriesTree() {
            this.loading = true
            this.$commom.request({
                url: '/category/tree',
                auth: true,
                success: resp => {
                    this.loading = false
                    this.categoriesTree = [...resp]
                }
            })
        },

        getCategories() {
            this.loading = true
            this.$commom.request({
                url: '/category',
                auth: true,
                success: resp => {
                    this.loading = false
                    this.categories = [...resp]
                }
            })
        },

        getCategory( id  ) {
            this.loading = true
            this.$commom.request({
                url: '/category/'+id,
                auth: true,
                success: resp => {
                    this.editCategory = {...resp}
                    this.loading = false
                    this.editCategoryModal = true
                },
                error: () => this.loading = false
            })
        },

        createCategory(){
            if( !this.$can('create-category') )
                return 

            this.saveLoading = true
            this.$commom.request({
                url: '/category',
                type: 'post',
                auth: true,
                data: this.category,
                setError: true,
                success: resp => {
                    this.getCategoriesTree()
                    this.getCategories()
                    this.saveLoading = false
                    this.category = {...this.category, name: ''}
                },
                error: e => {
                    this.saveLoading = false
                }
            })
        },

        updateCategory(){
            if( !this.$can('update-category') )
                return 

            this.saveLoading = true
            this.$commom.request({
                url: '/category/'+this.editCategory.id,
                type: 'put',
                auth: true,
                data: this.editCategory,
                setError: true,
                success: resp => {
                    this.getCategories()
                    this.getCategoriesTree()
                    this.saveLoading = false
                    this.editCategoryModal = false
                    this.editCategory = {}
                },
                error: e => {
                    this.saveLoading = false
                }
            })
        },

        deleteCategory(){
            if( !this.$can('delete-category') )
                return 

            this.saveLoading = true
            this.$commom.request({
                url: '/category/'+this.editCategory.id,
                type: 'delete',
                auth: true,
                setError: true,
                success: resp => {
                    this.getCategories()
                    this.getCategoriesTree()
                    this.saveLoading = false
                    this.editCategoryModal = false
                    this.editCategory = {}
                },
                error: e => {
                    this.saveLoading = false
                }
            })
        },

        linkCategory(id){
            this.category = {id_category: id}
            this.editCategoryModal = false
        },
    }
}
</script>