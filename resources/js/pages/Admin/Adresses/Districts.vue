<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <v-card :loading="loading">
                    <v-card-title>
                        <div class="row" v-if="city.id">
                            <div class="col-md-6" >
                                <ul class="breadcrumb">
                                    <router-link :to="`/admin/adresses`" class="small breadcrumb-item">Endereços</router-link>
                                    <router-link :to="`/admin/uf/${city.uf.id}/cities`" class="small breadcrumb-item">{{city.uf.name}}</router-link>
                                    <li class="small breadcrumb-item active">{{city.name}}</li>
                                </ul>
                            </div>
                            <div class="col-md-6 text-right">
                                <v-btn v-if="$can('create-address') && city.id" small @click="createModal = true">
                                    <v-icon small>fa fa-plus</v-icon>
                                    Adicionar Bairro
                                </v-btn>
                            </div>
                        </div>
                    </v-card-title>
                    <v-card-text>

                        <div class="row">
                            <div class="col-md-12">
                                <v-text-field flat clearable v-model="search" clear-icon="mdi-close-circle-outline" label="Buscar"></v-text-field>
                                <v-data-table 
                                    :search="search"
                                    :headers="tableHaeders"
                                    :items="city.districts"
                                >
                                    <template v-slot:item.actions="{item}">
                                        <v-btn v-if="$can('update-address')" icon color="primary" @click="() => getDistrict(item.id)">
                                            <v-icon small>fa fa-edit</v-icon>
                                        </v-btn>
                                    </template>
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>CEP</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="district in city.districts" :key="district.id">
                                            <td>{{district.name}}</td>
                                            <td>{{district.cep}}</td>
                                            <td>
                                                <v-btn v-if="$can('update-address')" icon color="primary" @click="() => getDistrict(district.id)">
                                                    <v-icon small>fa fa-edit</v-icon>
                                                </v-btn>
                                            </td>
                                        </tr>
                                    </tbody>
                                </v-data-table>
                            </div>                  
                        </div>
                    </v-card-text>
                </v-card>
            </div>
        </div>

        <v-dialog max-width="600" v-model="createModal" @click:outside="dialog=null">
            <v-card>
                <v-card-title>Adicionar Bairro</v-card-title>
                <v-card-text>
                    <v-form @submit.prevent="createDistrict">
                        <div class="row">
                            <div class="col-md-8">
                                <v-text-field autofocus v-model="district.name" label="Nome" />
                            </div>
                            <div class="col-md-4">
                                <v-text-field v-model="district.cep" label="CEP" v-mask="'#####-###'"/>
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
                <v-card-title>Editar Bairro</v-card-title>
                <v-card-text>
                    <v-form @submit.prevent="updateDistrict">
                        <div class="row">
                            <div class="col-md-8">
                                <v-text-field autofocus v-model="editDistricts.name" label="Nome" />
                            </div>
                            <div class="col-md-4">
                                <v-text-field v-model="editDistricts.cep" label="CEP" v-mask="'#####-###'"/>
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

    data: () => {
        return {
            loading: false,
            saveLoading: false,
            city: {},
            editDistricts: {},
            district: {},
            createModal: false,
            updateModal: false,
            search: '',

            tableHaeders: [
                {text: 'Nome', value: 'name'},
                {text: 'Cep', value: 'cep'},
                {text: '', value: 'actions'},
            ]
        }
    },

    mounted(){
        this.getDistricts()
    },

    watch: {
        updateModal(v){
            if(!v)
                this.editDistricts = {}
        },
        createModal(){
            this.district = {cep: this.city.cep}
        },

        city(c){
            if( c && c.id ){
                this.district = {...this.district, cep: c.cep}
            }
        }
    },


    methods: {

        getDistricts() {
            if( !this.$can('view-address') )
                return 

            this.loading = true
            this.$commom.request({
                url: '/city/'+this.$route.params.id,
                auth: true,
                success: resp => {
                    this.city = {...resp}
                    this.loading = false
                },
                error: () => this.loading = false
            })
        },

        getDistrict( id ) {
            const district = this.city.districts.find(d => d.id == id)
            this.editDistricts = {...district}
            this.updateModal = true
        },

        createDistrict(){
            if( !this.$can('create-address') )
                return 

            this.saveLoading = true
            this.$commom.request({
                url: `/city/${this.city.id}/district`,
                type: 'post',
                auth: true,
                data: this.district,
                setError: true,
                success: resp => {
                    this.getDistricts()
                    this.district = {cep: this.city.cep}
                    this.saveLoading = false
                },
                error: e => {
                    this.saveLoading = false
                }
            })
        },

        updateDistrict(){
            if( !this.$can('update-address') )
                return 

            this.saveLoading = true
            this.$commom.request({
                url: `/district/${this.editDistricts.id}`,
                type: 'put',
                auth: true,
                data: this.editDistricts,
                setError: true,
                success: resp => {
                    this.getDistricts()
                    this.saveLoading = false
                    this.editDistricts = {}
                    this.updateModal = false
                },
                error: e => {
                    this.saveLoading = false
                }
            })
        },

        deleteDistrict(id){
            if( !this.$can('delete-address') )
                return 

            this.$commom.confirm({
                title: 'Deseja deletar este bairro?',
                onConfirm: () => {
                    this.saveLoading = true
                    this.$commom.request({
                        url: `/district/${id}`,
                        type: 'delete',
                        auth: true,
                        setError: true,
                        success: resp => {
                            this.getCity()
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