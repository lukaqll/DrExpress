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
                        <v-tab>Dados</v-tab>
                        <v-tab>Endereços</v-tab>
                        <v-tab>Funções</v-tab>
                        <v-tab>Configurações</v-tab>
                    </v-tabs>
                </v-card-title>
                <v-card-text>
                    <v-form id="new-user" @submit.prevent="updateUser">
        
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
        
                                </div>
                            </v-tab-item>
                            <v-tab-item>
                                <v-card class="m-2">
                                    <v-list>
                                        <v-list-item 
                                            v-for="(ad, i) in adresses" :key="i"
                                            @click="() => getAddress(ad.id)"
                                            class="border-bottom"
                                        >
                                            <v-list-item-content>
                                                <v-list-item-title>{{ad.street}}</v-list-item-title>
                                                <v-list-item-subtitle>
                                                    {{ ad.city_name }} - {{ ad.uf_name }} <br>
                                                    {{ ad.district_name }} - {{ ad.number }}
                                                </v-list-item-subtitle>
                                            </v-list-item-content>
                                            <v-list-item-action-text v-if="!!ad.is_default">
                                                Endereço Padrão
                                            </v-list-item-action-text>
                                            <v-list-item-action>
                                                <v-icon small>fa fa-chevron-right</v-icon>
                                            </v-list-item-action>
                                        </v-list-item>
                                        <v-list-item @click="() => {addressModal=true; idAddress=null}" class="text-primary">
                                            <v-list-item-content>
                                                <v-list-item-title>Adicionar Endereço</v-list-item-title>
                                            </v-list-item-content>
                                            <v-list-item-action>
                                                <v-icon small color="primary">fa fa-plus</v-icon>
                                            </v-list-item-action>
                                        </v-list-item>
                                    </v-list>
                                </v-card>
                            </v-tab-item>
                            <v-tab-item>
                                <v-card flat>
                                    <v-autocomplete 
                                        label="Funções" 
                                        :items="rolesOptions"
                                        v-model="user.id_roles"
                                        chips 
                                        multiple
                                    >
                                        <template v-slot:selection="data">
                                            <v-chip
                                                v-bind="data.attrs"
                                                :input-value="data.selected"
                                                close
                                                @click="data.select"
                                                @click:close="removeRole(data.item)"
                                            >
                                                {{ data.item.text }}
                                            </v-chip>
                                        </template>
                                    </v-autocomplete>
                                </v-card>
                            </v-tab-item>
                            <v-tab-item>
                                <v-card  class="m-2" flat v-if="user.config">
                                    <div class="row">

                                        <div class="col-md-8">
                                            <div class="row">

                                                <div class="col-md-6">
                                                    <v-switch
                                                        label="Aberto"
                                                        v-model="user.config.is_open"
                                                        hint="Indica se está disponível para receber novos pedidos de venda."
                                                        persistent-hint
                                                    />
                                                    <v-switch
                                                        label="Loja Física"
                                                        v-model="user.config.is_physical"
                                                        hint="Informa se possui uma loja física ou não."
                                                        persistent-hint
                                                    />
                                                    <v-switch
                                                        label="Delivery"
                                                        v-model="user.config.is_delivery"
                                                        hint="Indica se faz entregas ou somente aceita busca presencial."
                                                        persistent-hint
                                                    />
                                                </div>

                                                <div class="col-md-6">
                                                    <v-select 
                                                        v-model="user.config.visibility" 
                                                        :items="visibilityOptions" 
                                                        label="Visibilidade"
                                                        hint="Informa a visibilidade no aplicativo."
                                                        persistent-hint
                                                    />
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-12" v-if="errors && errors.length">
                                            <v-alert v-html="errors" type="error"></v-alert>
                                        </div>
                                        
                                    </div>
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
                <v-card-actions class="justify-content-between mt-3">
                    <v-btn v-if="$can('update-user-password')" text color="primary" @click="passwordModal=true">Alterar Senha</v-btn>
                    <div>
                        <v-btn text @click="$router.back()">Voltar</v-btn>
                        <v-btn form="new-user" :loading="loading" type="submit" color="primary">Salvar</v-btn>
                    </div>
                </v-card-actions>
            </v-card>
        </div>

        <address-modal
            :visible="addressModal"
            :idAddress="idAddress"
            @onHide="addressModal=false"
            @onSave="onAddressSave"
        />

        <!-- update password -->
        <v-dialog max-width="400" v-model="passwordModal">
            <template v-slot:default="dialog">
                <v-card :loading="passwordLoading" :disabled="passwordLoading">
                    <v-card-title>Alterar senha</v-card-title>
                    <v-card-text>
                        <v-form ref="passwordForm" id="update-password" @submit.prevent="updatePassword">
                            <div class="row">
                                <div class="col-md-12">
                                    <v-text-field type="password" :rules="userRules.password" v-model="password.password" label="Senha"/>
                                </div>
                                <div class="col-md-12">
                                    <v-text-field type="password" :rules="userRules.password_confirmation" v-model="password.password_confirmation" label="Confirme a Senha"/>
                                </div>
                            </div>
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-btn text @click="dialog.value = false">Fechar</v-btn>
                        <v-btn form="update-password" type="submit" color="primary">Salvar</v-btn>
                    </v-card-actions>
                </v-card>
            </template>
        </v-dialog>

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
        idAddress: null,
        passwordModal: false,
        passwordLoading: false,
        password: {},
        roles: [],


        userRules: {
            password: [
                v => !!v || 'Insira a senha',
                v => (v && v.length >= 6) || 'A senha deve conter pelo menos 6 caracteres',
            ],
            password_confirmation: [
                v => !!v || 'Confirme a senha',
                v => (v && v.length >= 6) || 'A senha deve conter pelo menos 6 caracteres'
            ],
        },

        visibilityOptions: [
            {text: 'Visível', value: 'V'},
            {text: 'Oculto', value: 'O'},
            {text: 'Em breve', value: 'B'},
        ]
    }),

    mounted(){
        this.getUser()
        this.getAdresses()
        this.getRoles()
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
        },

        rolesOptions() {
            return this.roles.map(p => ({
                text: p.name, value: p.id
            }))
        },
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

        updateUser(){
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
            } else {
                this.createAddress(address)
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
        updateUser(){
            if( this.$can('update-user') ){
                this.loading = true
                this.$commom.request({
                    url: `/seller/${this.user.id}`,
                    type: 'put',
                    auth: true,
                    data: this.user,
                    setError: true,
                    success: resp => {
                        this.loading = false
                        this.getUser()
                    },
                    error: e => {
                        this.loading = false
                    }
                })
            }
        },

        getAddress(id){
            this.idAddress = id
            this.addressModal = true
        },

        updatePassword(){
            if( this.$refs.passwordForm.validate() && this.$can('update-user-password') ){
                this.passwordLoading = true
                this.$commom.request({
                    url: '/seller/'+this.user.id+'/password',
                    type: 'put',
                    auth: true,
                    data: this.password,
                    setError: true,
                    success: resp => {
                        this.passwordModal = false
                        this.passwordLoading = false
                        this.password={}
                    },
                    error: e => {
                        this.passwordLoading = false
                    }
                })
            }
        },

        getRoles() {
            this.$commom.request({
                url: '/roles',
                auth: true,
                success: resp => {
                    this.roles = [...resp]
                },
            })
        },
        removeRole(item){
            let newEditUser = this.editUser
            const index = newEditUser.id_roles.findIndex(i => i == item.value)
            newEditUser.id_roles.splice(index, 1)
            this.editRole = {...newEditUser}
        },

    }
}
</script>