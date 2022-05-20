<template>
    <div>
        <v-card :loading="loading">
            <v-card-title>
                <div class="row">
                    <div class="col-md-6">
                        <v-breadcrumbs v-if="category.id" :items="links" />
                    </div>
                    <div class="col-md-6">
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

                        <v-expansion-panels multiple>
                            <v-expansion-panel
                                v-for="(spec, i) in category.specs"
                                :key="i" 
                            >
                                <v-expansion-panel-header class="py-0">
                                    <div>
                                        <v-btn text small @click="() => getSpec(spec.id)">{{spec.name}}</v-btn>
                                        <span x-small v-if="spec.items" class="badge bg-primary rounded-xl">{{spec.items.length || '0'}}</span>
                                        <v-icon small color="error" v-if="spec.is_required" dark>fa fa-asterisk</v-icon>
                                        <v-icon small color="primary" v-if="spec.is_multiple" dark>fa fa-check-double</v-icon>
                                    </div>
                                </v-expansion-panel-header>

                                <v-expansion-panel-content>

                                    <div class="row">
                                        <div class="col-12">
                                            <v-chip
                                                v-for="(item, i) in spec.items" :key="i"
                                                class="ma-2"
                                                :close="$can('delete-category')"
                                                @click:close="() => deleteItem(spec.id, item.id)"
                                                @click="() => itemsToUpdate[spec.id] && itemsToUpdate[spec.id].id == item.id ? cancelItemUpdate(spec.id) : getItem(item)"
                                                :color="itemsToUpdate[spec.id] && itemsToUpdate[spec.id].id == item.id ? 'primary' : 'default'"
                                            >
                                                {{item.name}}
                                            </v-chip>
                                        </div>
                                        <div class="col-12" v-if="$can('create-category') && !itemsToUpdate[spec.id]">
                                            <v-form @submit.prevent="() => createItem(spec.id)">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <v-text-field v-model="itemsToCreate[spec.id]" label="Adicionar Item" />
                                                    </div>
                                                    <div class="col-md-4 d-flex align-items-center">
                                                        <v-btn type="submit" color="primary">Salvar</v-btn>
                                                    </div>
                                                </div>
                                            </v-form>
                                        </div>
                                        <div class="col-12" v-else-if="$can('update-category') && itemsToUpdate[spec.id]">
                                            <v-form @submit.prevent="() => updateItem(spec.id)">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <v-text-field v-model="itemsToUpdate[spec.id].name" label="Editar Item" />
                                                    </div>
                                                    <div class="col-md-4 d-flex align-items-center">
                                                        <v-btn type="submit" color="primary">Salvar</v-btn>
                                                        <v-btn color="error" text @click="() => cancelItemUpdate(spec.id)">Cancelar</v-btn>
                                                    </div>
                                                </div>
                                            </v-form>
                                        </div>
                                    </div>
                                </v-expansion-panel-content>
                            </v-expansion-panel>
                        </v-expansion-panels>
                        <v-btn v-if="$can('create-category')" @click="() => form = 'createSpec'" class="mt-3" block text elevation="0" color="purple">
                            <v-icon small>fa fa-plus</v-icon>
                            Adicionar Especificação
                        </v-btn>

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
                                        <v-checkbox class="m-0" v-model="editSpec.is_multiple" label="Múltiplo"/>
                                    </div>
                                </div>
                            </v-form>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <v-btn class="float-left" text @click="() => {this.form='createSpec'; this.editSpec={}}" color="error">Cancelar</v-btn>
                                </div>
                                <div>
                                    <v-btn v-if="$can('delete-category')" text @click="deleteSpec" color="error">Excluir</v-btn>
                                    <v-btn v-if="$can('update-category')" form="update-spec" :loading="saveLoading" type="submit" color="primary">Salvar</v-btn>
                                </div>
                            </div>
                        </div>
                        <div v-if="form == 'createSpec' && $can('create-category')">
                            <h5>Nova Especificação</h5>
                            <v-form ref="createForm" id="new-spec" @submit.prevent="createSpec">
                                <div class="row">
                                    <div class="col-md-12">
                                        <v-text-field autofocus v-model="spec.name" label="nome"/>
                                    </div>
                                    <div class="col-md-12">
                                        <v-checkbox class="m-0" v-model="spec.is_required" label="Obrigatório"/>
                                        <v-checkbox class="m-0" v-model="spec.is_multiple" label="Múltiplo"/>
                                    </div>
                                </div>
                            </v-form>
                            <div class="d-flex justify-end">
                                <v-btn form="new-spec" :loading="saveLoading" type="submit" color="primary">Salvar</v-btn>
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
        saveLoading: false,
        form: 'createSpec',
        spec: {},
        editSpec: {},
        itemsToCreate: {},
        itemsToUpdate: {},
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

        getCategory() {
            if( !this.$can('view-category') )
                return 

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
            if( !this.$can('create-category') )
                return 

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
                },
                error: e => {
                    this.saveLoading = false
                }
            })
        },

        updateSpec(){
            if( !this.$can('update-category') )
                return 

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
                    this.editSpec = {}
                },
                error: e => {
                    this.saveLoading = false
                }
            })
        },

        deleteSpec(){
            if( !this.$can('delete-category') )
                return 

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
                            this.editSpec = {}
                        },
                        error: e => {
                            this.saveLoading = false
                        }
                    })
                }
            })
        },


        getItem(item){
            const itemToTupdate = this.itemsToUpdate
            itemToTupdate[item.id_spec] = {...item}
            this.itemsToUpdate = {...itemToTupdate}
        },

        cancelItemUpdate(idSpec){
            const itemToTupdate = this.itemsToUpdate
            itemToTupdate[idSpec] = null
            this.itemsToUpdate = {...itemToTupdate}
        },

        createItem(idSpec){
            if( !this.$can('create-category') )
                return 
            this.saveLoading = true
            this.$commom.request({
                url: `/spec/${idSpec}/item`,
                type: 'post',
                auth: true,
                data: {name: this.itemsToCreate[idSpec]},
                setError: true,
                success: resp => {
                    this.getCategory()
                    this.saveLoading = false
                    this.itemsToCreate[idSpec] = ''
                },
                error: e => {
                    this.saveLoading = false
                }
            })
        },

        updateItem(idSpec){
            if( !this.$can('update-category') )
                return 
            const item = this.itemsToUpdate[idSpec]

            this.saveLoading = true
            this.$commom.request({
                url: `/spec-item/${item.id}`,
                type: 'put',
                auth: true,
                data: item,
                setError: true,
                success: resp => {
                    this.getCategory()
                    this.saveLoading = false
                    const itemToTupdate = this.itemsToUpdate
                    itemToTupdate[item.id_spec] = null
                    this.itemsToUpdate = {...itemToTupdate}
                },
                error: e => {
                    this.saveLoading = false
                }
            })
        },

        deleteItem(idSpec, id){
            if( !this.$can('delete-category') )
                return 
            this.$commom.confirm({
                title: 'Deseja deletar este item?',
                onConfirm: () => {
                    this.saveLoading = true
                    this.$commom.request({
                        url: `/spec-item/${id}`,
                        type: 'delete',
                        auth: true,
                        setError: true,
                        success: resp => {
                            this.getCategory()
                            this.form = 'createSpec'
                            this.saveLoading = false
                            this.cancelItemUpdate(idSpec)
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