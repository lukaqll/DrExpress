<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <v-card :loading="loading">
                    <v-card-title>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <router-link :to="`/admin/adresses`" class="small breadcrumb-item">Endereços</router-link>
                                    <li class="small breadcrumb-item active">{{uf.name}}</li>
                                </ul>
                            </div>
                            <div class="col-md-6 text-right">
                                <v-btn v-if="$can('create-address') && uf.id" small @click="createModal = true">
                                    <v-icon small>fa fa-plus</v-icon>
                                    Adicionar Cidade
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
                                            <th>IBGE</th>
                                            <th>CEP</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="city in uf.cities" :key="city.id">
                                            <td>{{city.name}}</td>
                                            <td>{{city.ibge_code}}</td>
                                            <td>{{city.cep}}</td>
                                            <td>
                                                <v-btn v-if="$can('update-address')" icon color="primary" @click="() => getCity(city.id)">
                                                    <v-icon small>fa fa-edit</v-icon>
                                                </v-btn>
                                                <router-link 
                                                    v-if="$can('view-address')"
                                                    is='v-btn' text
                                                    :to="`/admin/city/${city.id}/districts`"
                                                >
                                                    {{city.districts.length}} Bairros
                                                </router-link>
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
                <v-card-title>Adicionar Cidade</v-card-title>
                <v-card-text>
                    <v-form @submit.prevent="createCity">
                        <div class="row">
                            <div class="col-md-12">
                                <v-text-field autofocus v-model="city.name" label="Nome" />
                            </div>
                            <div class="col-md-6">
                                <v-text-field v-model="city.cep" label="CEP" v-mask="'#####-###'" />
                            </div>
                            <div class="col-md-6">
                                <v-text-field v-model="city.ibge_code" label="Código IBGE" />
                            </div>
                            <div class="col-md-12 d-flex justify-end">
                                <v-btn text color="error" @click="createModal=false">Fechar</v-btn>
                                <v-btn :loading="saveLoading" type="submit" color="primary">Salvar</v-btn>
                            </div>
                        </div>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-dialog>

        <v-dialog max-width="600" v-model="updateModal">
            <v-card>
                <v-card-title>Editar Cidade</v-card-title>
                <v-card-text>
                    <v-form @submit.prevent="updateCity">
                        <div class="row">
                            <div class="col-md-8">
                                <v-text-field autofocus v-model="editCity.name" label="Nome" />
                            </div>
                            <div class="col-md-6">
                                <v-text-field v-model="editCity.cep" label="CEP" v-mask="'#####-###'" />
                            </div>
                            <div class="col-md-6">
                                <v-text-field v-model="editCity.ibge_code" label="Código IBGE" />
                            </div>
                            <div class="col-md-12 d-flex justify-end">
                                <v-btn text color="error" @click="updateModal=false">Fechar</v-btn>
                                <v-btn :loading="saveLoading" type="submit" color="primary">Salvar</v-btn>
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
        saveLoading: false,
        uf: {},
        editCity: {},
        city: {},
        createModal: false,
        updateModal: false,
    }),

    mounted(){
        this.getCities()
    },

    watch: {
        updateModal(v){
            if(!v)
                this.editCity = {}
        },
        createModal(){
            this.city = {}
        },
    },

    methods: {

        getCities() {
            if( !this.$can('view-address') )
                return 

            this.loading = true
            this.$commom.request({
                url: '/uf/'+this.$route.params.id+'/cities',
                auth: true,
                success: resp => {
                    this.uf = {...resp}
                    this.loading = false
                },
                error: () => this.loading = false
            })
        },

        getCity( id ) {
            const city = this.uf.cities.find(s => s.id == id)
            this.editCity = {...city}
            this.updateModal = true
        },

        createCity(){
            if( !this.$can('create-address') )
                return 

            this.saveLoading = true
            this.$commom.request({
                url: `/uf/${this.uf.id}/city`,
                type: 'post',
                auth: true,
                data: this.city,
                setError: true,
                success: resp => {
                    this.getCities()
                    this.city = {}
                    this.saveLoading = false
                },
                error: e => {
                    this.saveLoading = false
                }
            })
        },

        updateCity(){
            if( !this.$can('update-address') )
                return 

            this.saveLoading = true
            this.$commom.request({
                url: `/city/${this.editCity.id}`,
                type: 'put',
                auth: true,
                data: this.editCity,
                setError: true,
                success: resp => {
                    this.getCities()
                    this.saveLoading = false
                    this.editCity = {}
                    this.updateModal = false
                },
                error: e => {
                    this.saveLoading = false
                }
            })
        },

        deleteCity(id){
            if( !this.$can('delete-address') )
                return 

            this.$commom.confirm({
                title: 'Deseja deletar esta cidade?',
                onConfirm: () => {
                    this.saveLoading = true
                    this.$commom.request({
                        url: `/city/${id}`,
                        type: 'delete',
                        auth: true,
                        setError: true,
                        success: resp => {
                            this.getCities()
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