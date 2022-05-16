<template>
    <div>
        <v-card :loading="loading">
            <v-card-title>
                <div class="row">
                    <div class="col-md-6">
                        <v-breadcrumbs v-if="category.id" :items="links" />
                    </div>
                    <div class="col-md-6">
                        <v-btn class="float-right" small @click="form = 'createSpec'">
                            Nova Espec.
                        </v-btn>
                        <v-btn text class="float-right" small @click="$router.back()">
                            <v-icon small>fa fa-chevron-left</v-icon>
                            Voltar
                        </v-btn>
                    </div>
                </div>
            </v-card-title>
            <v-card-text v-if="category.id">

                <div class="row">
                    <div class="col-md-7">
                        <v-text-field
                            v-model="search"
                            label="Buscar"
                            flat
                            clearable
                            clear-icon="mdi-close-circle-outline"
                        ></v-text-field>

                        <!-- treeview -->
                        <v-treeview 
                            :items="category.specs"
                            rounded
                            hoverable
                            transition
                            dense
                            open-on-click
                            :search="search"
                            expand-icon="mdi-chevron-down"
                        >
                            <template v-slot:label="{ item }">
                                <v-btn text small @click="() => item.children ? getSpec(item.id) : getItem(item)">{{item.name}}</v-btn>
                                <span x-small v-if="item.children" class="badge bg-primary rounded-xl">{{item.children.length || '0'}}</span>
                                <span x-small v-if="item.is_required" class="badge bg-success rounded-xl">
                                    <v-icon x-small v-if="item.is_required" dark>fa fa-check</v-icon>
                                </span>
                            </template>
                            <template v-slot:append="{ item }">
                                <v-btn v-if="item.children" small icon color="success" @click="() => addItem(item.id)">
                                    <v-icon small >fa fa-plus</v-icon>
                                </v-btn>
                            </template>
                        </v-treeview>
                    </div>
                    <div class="col-md-5" style="border-left: solid 1px #ddd">
                        <div v-if="form == 'updateSpec'">
                            <h5>Editar Especificação</h5>
                            <v-form ref="createForm" id="update-spec" @submit.prevent="updateSpec">
                                <div class="row">
                                    <div class="col-md-12">
                                        <v-text-field autofocus v-model="editSpec.name" label="nome"/>
                                    </div>
                                    <div class="col-md-12">
                                        <v-checkbox class="m-0" v-model="editSpec.is_required" label="Obrigatório"/>
                                    </div>
                                </div>
                            </v-form>
                            <div class="d-flex justify-end">
                                <v-btn text @click="deleteSpec" color="error">Excluir</v-btn>
                                <v-btn form="update-spec" :loading="saveLoading" type="submit" color="primary">Salvar</v-btn>
                            </div>
                        </div>
                        <div v-if="form == 'createSpec'">
                            <h5>Nova Especificação</h5>
                            <v-form ref="createForm" id="new-spec" @submit.prevent="createSpec">
                                <div class="row">
                                    <div class="col-md-12">
                                        <v-text-field autofocus v-model="spec.name" label="nome"/>
                                    </div>
                                    <div class="col-md-12">
                                        <v-checkbox class="m-0" v-model="spec.is_required" label="Obrigatório"/>
                                    </div>
                                </div>
                            </v-form>
                            <div class="d-flex justify-end">
                                <v-btn form="new-spec" :loading="saveLoading" type="submit" color="primary">Salvar</v-btn>
                            </div>
                        </div>
                        <div v-if="form == 'createItem'">
                            <h5>Adicionar Item ({{ category.specs.find(s => s.id == item.id_spec).name }})</h5>
                            <v-form ref="createItemForm" id="create-item" @submit.prevent="createItem">
                                <div class="row">
                                    <div class="col-md-12">
                                        <v-text-field autofocus v-model="item.name" label="nome"/>
                                    </div>
                                </div>
                            </v-form>
                            <div class="d-flex justify-end">
                                <v-btn form="create-item" :loading="saveLoading" type="submit" color="primary">Salvar</v-btn>
                            </div>
                        </div>
                        <div v-if="form == 'updateItem'">
                            <h5>Editar Item ({{ category.specs.find(s => s.id == item.id_spec).name }} / {{item.name}})</h5>
                            <v-form ref="updateItemForm" id="update-item" @submit.prevent="updateItem">
                                <div class="row">
                                    <div class="col-md-12">
                                        <v-text-field autofocus v-model="item.name" label="nome"/>
                                    </div>
                                </div>
                            </v-form>
                            <div class="d-flex justify-end">
                                <v-btn text @click="deleteItem" color="error">Excluir</v-btn>
                                <v-btn form="update-item" :loading="saveLoading" type="submit" color="primary">Salvar</v-btn>
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
        category: {},
        loading: false,
        specsTree: [],
        search: '',
        saveLoading: false,
        form: 'createSpec',
        spec: {},
        editSpec: {},
        item: {},
    }),

    computed: {
        links(){
            return [
                {text: 'Categorias', href: '/admin/categories'},
                {text: this.category.name, disabled: true},
                {text: 'Especificações', disabled: true},
            ]
        }
    },

    mounted(){
        this.getCategory()
    },

    methods: {

        getCategory( id ) {
            this.loading = true
            this.$commom.request({
                url: '/category/'+this.$route.params.id,
                auth: true,
                success: resp => {
                    if(!resp.linkable)
                        this.category = {...resp}

                    this.loading = false
                },
                error: () => this.loading = false
            })
        },

        getSpec( id ) {
            const spec = this.category.specs.find(s => s.id == id)
            this.editSpec = {...spec}
            this.form = 'updateSpec'
        },

        createSpec(){
            this.saveLoading = true
            this.$commom.request({
                url: `/category/${this.category.id}/specs`,
                type: 'post',
                auth: true,
                data: this.spec,
                setError: true,
                success: resp => {
                    this.getCategory()
                    this.spec = {}
                    this.saveLoading = false
                    this.addItem(resp.id)
                },
                error: e => {
                    this.saveLoading = false
                }
            })
        },

        updateSpec(){
            this.saveLoading = true
            this.$commom.request({
                url: `/spec/${this.editSpec.id}`,
                type: 'put',
                auth: true,
                data: this.editSpec,
                setError: true,
                success: resp => {
                    this.getCategory()
                    this.saveLoading = false
                    this.editSpecModal = false
                    this.editSpec = {}
                },
                error: e => {
                    this.saveLoading = false
                }
            })
        },

        deleteSpec(){
            this.$commom.confirm({
                title: 'Deseja deletar esta especificação?',
                onConfirm: () => {
                    this.saveLoading = true
                    this.$commom.request({
                        url: `/spec/${this.editSpec.id}`,
                        type: 'delete',
                        auth: true,
                        setError: true,
                        success: resp => {
                            this.getCategory()
                            this.form = 'createSpec'
                            this.saveLoading = false
                            this.editSpecModal = false
                            this.editSpec = {}
                        },
                        error: e => {
                            this.saveLoading = false
                        }
                    })
                }
            })
        },

        addItem(id){
            this.form = 'createItem'
            this.item = {id_spec: id}
        },

        getItem(item){
            this.form = 'updateItem'
            this.item = {...item}
        },

        createItem(){
            this.saveLoading = true
            this.$commom.request({
                url: `/spec/${this.item.id_spec}/item`,
                type: 'post',
                auth: true,
                data: this.item,
                setError: true,
                success: resp => {
                    this.getCategory()
                    this.saveLoading = false
                    this.item = {...this.item, name: ''}
                },
                error: e => {
                    this.saveLoading = false
                }
            })
        },

        updateItem(){
            this.saveLoading = true
            this.$commom.request({
                url: `/spec-item/${this.item.id}`,
                type: 'put',
                auth: true,
                data: this.item,
                setError: true,
                success: resp => {
                    this.getCategory()
                    this.saveLoading = false
                    this.form = 'createItem'
                    this.item = {...this.item, name: ''}
                },
                error: e => {
                    this.saveLoading = false
                }
            })
        },

        deleteItem(){
            this.$commom.confirm({
                title: 'Deseja deletar este item?',
                onConfirm: () => {
                    this.saveLoading = true
                    this.$commom.request({
                        url: `/spec-item/${this.item.id}`,
                        type: 'delete',
                        auth: true,
                        setError: true,
                        success: resp => {
                            this.getCategory()
                            this.form = 'createSpec'
                            this.saveLoading = false
                            this.editSpecModal = false
                            this.item = {}
                        },
                        error: e => {
                            this.saveLoading = false
                        }
                    })
                }
            })
        },

    }
}
</script>