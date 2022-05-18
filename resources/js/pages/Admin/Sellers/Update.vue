<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <v-card :loading="loading" :disabled="loading">
                <v-card-title>
                    Editar vendedor
                    <v-tabs
                        v-model="tab"
                    >
                        <v-tabs-slider color="primary"></v-tabs-slider>
                        <v-tab>Login</v-tab>
                        <v-tab>Dados</v-tab>
                        <v-tab>Endereços</v-tab>
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
                                <v-card class="m-5">
                                    <v-list>
                                        <v-list-item 
                                            v-for="(ad, i) in adresses" :key="i"
                                            @click="() => getAddress(ad.id)"
                                        >
                                            <v-list-item-content>
                                                <v-list-item-title>{{ad.street}}</v-list-item-title>
                                                <v-list-item-subtitle>
                                                    {{ ad.city_name }} - {{ ad.uf_name }} <br>
                                                    {{ ad.district_name }} - {{ ad.number }}
                                                </v-list-item-subtitle>
                                            </v-list-item-content>
                                            <v-list-item-action>
                                                <v-icon small>fa fa-chevron-right</v-icon>
                                            </v-list-item-action>
                                        </v-list-item>
                                        <v-list-item @click="() => {addressModal=true; idAddress=null}">
                                            <v-list-item-content>
                                                <v-list-item-title>Adicionar Endereço</v-list-item-title>
                                            </v-list-item-content>
                                            <v-list-item-action>
                                                <v-icon small>fa fa-plus</v-icon>
                                            </v-list-item-action>
                                        </v-list-item>
                                    </v-list>
                                </v-card>
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

        <!-- <v-dialog v-model="addressModal" max-width="700">
            <template v-slot:default="dialog">
                <v-card >
                    <v-card-title>Editar Endereço</v-card-title>
                    <v-card-text>
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
                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-btn text @click="dialog.value = false">Fechar</v-btn>
                        <v-btn form="update-address" type="submit" color="primary">Salvar</v-btn>
                    </v-card-actions>
                </v-card>
            </template>
        </v-dialog> -->

        <address-modal
            :visible="addressModal"
            :idAddress="idAddress"
            @onHide="addressModal=false"
            @onSave="onAddressSave"
        />
    </div>
</template>
<script>
import AddressModal from '../../../components/AddressModal'

export default {
    
    components: {AddressModal},

    data: () => ({
        user: {},
        adresses: [],
        tab: null,
        loading: null,
        errors: '',
        addressModal: false,
        idAddress: null
    }),

    mounted(){
        this.getUser()
        this.getAdresses()
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
        
        addressModal(v){
            if(!v) this.idAddress = null
        }


    },
    
    methods: {

        getUser() {
            this.loading = true
            this.$commom.request({
                url: '/seller/'+this.$route.params.id,
                auth: true,
                success: resp => {
                    this.user = {...resp}
                    this.loading = false
                },
                error: () => this.loading = false
            })
        },

        getAdresses() {
            this.loading = true
            this.$commom.request({
                url: '/user/'+this.$route.params.id+'/address',
                auth: true,
                success: resp => {
                    this.loading = false
                    this.adresses = [...resp]
                },
                error: () => this.loading = false
            })
        },

        createUser(){
            if( this.$can('update-seller') ){
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

        onAddressSave(address){
            if(this.idAddress){
                this.updateAddress(address)
            }
        },
        updateAddress(address){
            if( this.$can('update-user-address') ){
                this.loading = true
                this.$commom.request({
                    url: `/address/${this.idAddress}`,
                    type: 'put',
                    auth: true,
                    data: address,
                    setError: true,
                    success: resp => {
                        this.loading = false
                        this.addressModal = false
                        this.getAdresses()
                    },
                    error: e => {
                        this.loading = false
                        this.errors = this.$commom.errorMessages(e)
                    }
                })
            }
        },

        getAddress(id){
            this.idAddress = id
            this.addressModal = true
        }
    }
}
</script>