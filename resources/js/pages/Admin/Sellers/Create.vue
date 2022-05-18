<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <v-card :loading="loading" :disabled="loading">
                <v-card-title>
                    Novo vendedor
                    <v-tabs
                        v-model="tab"
                    >
                        <v-tabs-slider color="primary"></v-tabs-slider>
                        <v-tab>Login</v-tab>
                        <v-tab>Dados</v-tab>
                        <v-tab>Endereço</v-tab>
                    </v-tabs>
                </v-card-title>
                <v-card-text>
                    <v-form ref="createForm" id="new-user" @submit.prevent="createUser">
        
                        <v-tabs-items v-model="tab">
                            <v-tab-item>
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-text-field autofocus v-model="user.name" label="nome"/>
                                    </div>
                                    <div class="col-md-6">
                                        <v-text-field type="email" v-model="user.email" label="E-mail"/>
                                    </div>
        
                                    <div class="col-md-6">
                                        <v-text-field type="password" v-model="user.password" label="Senha"/>
                                    </div>
                                    <div class="col-md-6">
                                        <v-text-field type="password" v-model="user.password_confirmation" label="Confirme a Senha"/>
                                    </div>
                                </div>
                            </v-tab-item>
                            <v-tab-item>
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-text-field-simplemask
                                            label="CPF/CNPJ"
                                            v-model="user.doc_number"
                                            :options="{inputMask: docNumberMask, outputMask: docNumberMask}"
                                        />
                                    </div>
                                    <div class="col-md-6">
                                        <v-text-field label="Telefone" v-model="user.phone" v-mask="'(##) #####-####'"/>
                                    </div>
        
                                    <div class="col-md-6">
                                        <v-text-field type="date" v-model="user.birthdate" label="Nascimento"/>
                                    </div>
        
                                    <div class="col-md-6">
                                        <v-text-field v-model="user.cro" label="CRO"/>
                                    </div>
        
                                    <div class="row">
                                        <div class="col-md-3">
                                            <v-checkbox
                                                v-model="user.is_delivery"
                                                label="Delivery"
                                            />
                                        </div>
                                        <div class="col-md-3">
                                            <v-checkbox
                                                v-model="user.is_physical"
                                                label="Loja Física"
                                            />
                                        </div>
                                    </div>
        
                                </div>
                            </v-tab-item>
                            <v-tab-item>
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-select
                                            label='Estado'
                                            :items="ufs"
                                            v-model="address.id_uf"
                                            item-text="name"
                                            item-value="id"
                                        />
                                    </div>
                                    <div class="col-md-6">
                                        <v-select
                                            label='Cidade'
                                            :items="cities"
                                            v-model="address.id_city"
                                            item-text="name"
                                            item-value="id"
                                        />
                                    </div>
                                    <div class="col-md-6">
                                        <v-autocomplete
                                            label='Bairro'
                                            :items="districts"
                                            v-model="address.id_district"
                                            item-text="name"
                                            item-value="id"
                                        />
                                    </div>
                                    <div class="col-md-6">
                                        <v-text-field v-model="address.street" label="Rua"/>
                                    </div>
                                    <div class="col-md-3">
                                        <v-text-field v-model="address.cep" label="CEP" v-mask="'#####-###'"/>
                                    </div>
                                    <div class="col-md-2">
                                        <v-text-field v-model="address.number" label="Nº"/>
                                    </div>
                                    <div class="col-md-7">
                                        <v-text-field v-model="address.complement" label="Complemento"/>
                                    </div>
                                    <div class="col-md-12">
                                        <v-text-field v-model="address.reference" label="Referência"/>
                                    </div>
                                </div>
                            </v-tab-item>
                        </v-tabs-items>
                        <div class="row">
                            <div class="col-md-12" v-if="errors && errors.length">
                                <v-alert v-html="errors" type="error"></v-alert>
                            </div>
                        </div>
                    </v-form>
                </v-card-text>
                <v-card-actions class="justify-end">
                    <v-btn text @click="$router.back()">Voltar</v-btn>
                    <v-btn form="new-user" :loading="loading" type="submit" color="primary">Salvar</v-btn>
                </v-card-actions>
            </v-card>
        </div>
    </div>
</template>
<script>
export default {
    
    data: () => ({
        user: {},
        address: {},
        ufs: [],
        cities: [],
        districts: [],
        tab: null,
        loading: null,
        errors: ''
    }),

    mounted(){
        this.getUfs()
    },

    computed: {
        docNumberMask() {
            let mask = null
            let str = ''
            if( this.user.id ){
                str = this.user.doc_number
            } else {
                str = this.user.doc_number
            }
            if( str && str.length > 14 ){
                mask = '##.###.###/####-##'
            } else {
                mask = '###.###.###-###'
            }
            return mask
        }
    },

    watch: {
        'address.id_uf': function(id_uf){
            this.address = {...this.address, id_city: null, id_district: null}
            if(id_uf){
                this.getCities()
            } else {
                this.cities = []
            }
        },
        'address.id_city': function(id_city){
            const city = this.cities.find(c => c.id = id_city)
            this.address = {...this.address, id_district: null, cep: city?.cep}
            if(id_city){
                this.getDistricts()
            } else {
                this.districts = []
            }
        },
        'address.id_district': function(id_district){
            const district = this.districts.find(d => d.id = id_district)
            this.address = {...this.address, cep: district?.cep}
        },


    },
    
    methods: {


        getUfs(){
            this.$commom.request({
                url: '/uf/',
                auth: true,
                success: resp => {
                    this.ufs = [...resp]
                }
            })
        },
        getCities(){
            this.$commom.request({
                url: `/uf/${this.address.id_uf}/cities`,
                auth: true,
                success: resp => {
                    this.cities = [...resp.cities]
                }
            })
        },
        getDistricts(){
            this.$commom.request({
                url: `/city/${this.address.id_city}`,
                auth: true,
                success: resp => {
                    this.districts = [...resp.districts]
                }
            })
        },


        createUser(){
            if( this.$can('create-seller') ){
                this.loading = true
                this.$commom.request({
                    url: '/seller',
                    type: 'post',
                    auth: true,
                    data: {...this.user, ...this.address},
                    success: resp => {
                        this.loading = false
                        this.newUserModal = false
                        this.$router.push('/admin/sellers')
                    },
                    error: e => {
                        this.errors = this.$commom.errorMessages(e)
                        this.loading = false
                    }
                })
            }
        },
    }
}
</script>