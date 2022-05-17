<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <v-card :loading="loading">
                    <v-card-title>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li class="small breadcrumb-item active">Endereços</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <v-btn v-if="$can('create-address')" class="float-right" small @click="createModal = true">
                                    <v-icon small>fa fa-plus</v-icon>
                                    Adicionar Estado
                                </v-btn>
                            </div>
                        </div>
                    </v-card-title>
                    <v-card-text>

                        <div class="row">
                            <div class="col-md-12">
                                <v-simple-table>
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Sigla</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="uf in ufs" :key="uf.id">
                                            <td>{{uf.name}}</td>
                                            <td>{{uf.initials}}</td>
                                            <td>
                                                <router-link 
                                                    v-if="$can('view-address')"
                                                    is='v-btn' text
                                                    :to="`/admin/uf/${uf.id}/cities`"
                                                >
                                                    {{uf.cities.length}} Cidades
                                                </router-link>
                                                <v-btn v-if="$can('update-address')" icon color="primary" @click="() => getUf(uf.id)">
                                                    <v-icon small>fa fa-edit</v-icon>
                                                </v-btn>
                                            </td>
                                        </tr>
                                    </tbody>
                                </v-simple-table>
                            </div>                  
                        </div>
                    </v-card-text>
                </v-card>
            </div>
        </div>

        <v-dialog max-width="600" v-model="createModal" @click:outside="dialog=null">
            <v-card>
                <v-card-title>Adicionar Estado</v-card-title>
                <v-card-text>
                    <v-form @submit.prevent="createUf">
                        <div class="row">
                            <div class="col-md-8">
                                <v-text-field autofocus v-model="uf.name" label="Nome" />
                            </div>
                            <div class="col-md-4">
                                <v-text-field v-model="uf.initials" label="Iniciais" />
                            </div>
                            <div class="col-md-12 d-flex justify-end">
                                <v-btn text color="error" @click="createModal=false">Fechar</v-btn>
                                <v-btn type="submit" color="primary">Salvar</v-btn>
                            </div>
                        </div>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-dialog>

        <v-dialog max-width="600" v-model="updateModal">
            <v-card>
                <v-card-title>Editar Estado</v-card-title>
                <v-card-text>
                    <v-form @submit.prevent="updateUf">
                        <div class="row">
                            <div class="col-md-8">
                                <v-text-field autofocus v-model="editUf.name" label="Nome" />
                            </div>
                            <div class="col-md-4">
                                <v-text-field v-model="editUf.initials" label="Iniciais" />
                            </div>
                            <div class="col-md-12 d-flex justify-end">
                                <v-btn text color="error" @click="updateModal=false">Fechar</v-btn>
                                <v-btn type="submit" color="primary">Salvar</v-btn>
                            </div>
                        </div>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
export default {

    data: () => ({
        loading: false,
        ufs: [],
        uf: {},
        editUf: {},
        createModal: false,
        updateModal: false,
    }),

    mounted(){
        this.getUfs()
    },

    watch: {
        updateModal(v){
            if(!v)
                this.editUf = {}
        },
        createModal(){
            this.uf = {}
        },
    },

    methods: {

        getUfs() {
            if( !this.$can('view-address') )
                return 

            this.loading = true
            this.$commom.request({
                url: '/uf',
                auth: true,
                success: resp => {
                    this.ufs = [...resp]
                    this.loading = false
                },
                error: () => this.loading = false
            })
        },

        getUf( id ) {
            const uf = this.ufs.find(s => s.id == id)
            this.editUf = {...uf}
            this.updateModal = true
        },

        createUf(){
            if( !this.$can('create-address') )
                return 

            this.saveLoading = true
            this.$commom.request({
                url: `/uf`,
                type: 'post',
                auth: true,
                data: this.uf,
                setError: true,
                success: resp => {
                    this.getUfs()
                    this.uf = {}
                    this.saveLoading = false
                    this.createModal = false
                },
                error: e => {
                    this.saveLoading = false
                }
            })
        },

        updateUf(){
            if( !this.$can('update-address') )
                return 

            this.saveLoading = true
            this.$commom.request({
                url: `/uf/${this.editUf.id}`,
                type: 'put',
                auth: true,
                data: this.editUf,
                setError: true,
                success: resp => {
                    this.getUfs()
                    this.saveLoading = false
                    this.editUf = {}
                    this.updateModal = false
                },
                error: e => {
                    this.saveLoading = false
                }
            })
        },

        deleteUf(id){
            if( !this.$can('delete-address') )
                return 

            this.$commom.confirm({
                title: 'Deseja deletar este estado?',
                onConfirm: () => {
                    this.saveLoading = true
                    this.$commom.request({
                        url: `/uf/${id}`,
                        type: 'delete',
                        auth: true,
                        setError: true,
                        success: resp => {
                            this.getUfs()
                            this.saveLoading = false
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