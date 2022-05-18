<template>
    <div>
        <v-card :loading="loading">
            <v-card-title>
                <div class="row">
                    <div class="col-12">
                        Vendedores
                        <v-btn small class="float-right" @click="$router.push('/admin/sellers/create')">Novo Vendedor</v-btn>
                    </div>
                </div>
            </v-card-title>
            <v-card-text>
                <v-text-field v-model="search" clearable label="Buscar"/>
                <v-data-table
                    :headers="usersHeaders"
                    :items="users"
                    :search="search"
                >
                    <template v-slot:item.roles_header="{ item }">
                        <span class="badge rounded-full bg-primary mr-1" v-for="(role, i) in item.roles" :key="i">{{role.name}}</span>
                    </template>
                    <template v-slot:item.actions_header="{ item }">
                        <v-btn v-if="$can('update-users')" icon color="primary" @click="$router.push(`/admin/sellers/${item.id}/update`)">
                            <v-icon small>fa fa-edit</v-icon>
                        </v-btn>
                        <v-btn v-if="$can('update-users')" @click="() => toggleStatus(item.id)" icon :color="item.status == 'A' ? 'success' : 'error'" data-toggle="tooltip" :title="item.status == 'A' ? 'Desativar' : 'Ativar'">
                            <v-icon small>fa fa-power-off</v-icon>
                        </v-btn>
                    </template>
                </v-data-table>
            </v-card-text>
        </v-card>

        <!-- edit user -->
        <v-dialog max-width="1000" v-model="editUserModal">
            <template v-slot:default="dialog">
                <v-card>
                    <v-card-title>
                        Editar Usuário
                        <v-tabs v-model="editionTab">
                            <v-tab>Login</v-tab>
                            <v-tab>Dados</v-tab>
                            <v-tab>Endereço</v-tab>
                            <v-tab>Funções</v-tab>

                        </v-tabs>
                    </v-card-title>
                    <v-card-text>
                        <v-form ref="updateForm" id="edit-user" @submit.prevent="updateUser">
                            <v-tabs-items v-model="editionTab">
                                <v-tab-item>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <v-text-field autofocus :rules="userRules.name" v-model="editUser.name" label="nome"/>
                                        </div>
                                        <div class="col-md-6">
                                            <v-text-field type="email" :rules="userRules.email" v-model="editUser.email" label="E-mail"/>
                                        </div>
                                        <div class="col-md-12">
                                            <v-btn v-if="$can('update-users')" color="primary" @click="() => getUser(editUser.id, true)">
                                                <v-icon small>fa fa-key</v-icon>
                                                Alterar Senha
                                            </v-btn>
                                        </div>
                                    </div>
                                </v-tab-item>
                                <v-tab-item>
                                    <div class="row">
                                        <div class="col-md-6">

                                            <v-text-field-simplemask
                                                label="CPF/CNPJ"
                                                v-model="editUser.doc_number"
                                                :options="{inputMask: docNumberMask, outputMask: docNumberMask}"
                                                :rules="userRules.doc_number"
                                            />
                                        </div>
                                        <div class="col-md-6">
                                            <v-text-field label="Telefone" v-model="editUser.phone" v-mask="'(##) #####-####'"/>
                                        </div>

                                        <div class="col-md-6">
                                            <v-text-field type="date" v-model="editUser.birthdate" label="Nascimento"/>
                                        </div>

                                        <div class="col-md-6">
                                            <v-text-field v-model="editUser.cro" label="CRO"/>
                                        </div>
                                    </div>
                                </v-tab-item>
                                <v-tab-item>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <v-autocomplete
                                                label='Estado'
                                                :items="ufsOptions"
                                                v-model="editUser.id_uf"
                                            />
                                        </div>
                                        <div class="col-md-6">
                                            <v-autocomplete
                                                label='Cidade'
                                                :items="citiesEditOptions"
                                                v-model="editUser.id_city"
                                            />
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <v-checkbox
                                                    v-model="editUser.is_delivery"
                                                    label="Delivery"
                                                />
                                            </div>
                                            <div class="col-md-3">
                                                <v-checkbox
                                                    v-model="editUser.is_physical"
                                                    label="Loja Física"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </v-tab-item>
                                <v-tab-item>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <v-autocomplete 
                                                label="Funções" 
                                                :items="rolesOptions"
                                                v-model="editUser.id_roles"
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
                                        </div>
                                    </div>
                                </v-tab-item>
                            </v-tabs-items>
                            <div class="row">
                                
                                <div class="col-md-12" v-if="userErrors && userErrors.length">
                                    <v-alert v-html="userErrors" type="error"></v-alert>
                                </div>
                            </div>
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-btn text @click="dialog.value = false">Fechar</v-btn>
                        <v-btn form="edit-user" :loading="saveLoading" type="submit" color="primary">Salvar</v-btn>
                    </v-card-actions>
                </v-card>
            </template>
        </v-dialog>

        <!-- update password -->
        <v-dialog max-width="400" v-model="passwordModal">
            <template v-slot:default="dialog">
                <v-card>
                    <v-card-title>Alterar senha de {{editUser.name}}</v-card-title>
                    <v-card-text>
                        <v-form ref="passwordForm" id="update-password" @submit.prevent="updatePassword">
                            <div class="row">
                                <div class="col-md-12">
                                    <v-text-field type="password" :rules="userRules.password" v-model="editUser.password" label="Senha"/>
                                </div>
                                <div class="col-md-12">
                                    <v-text-field type="password" :rules="userRules.password_confirmation" v-model="editUser.password_confirmation" label="Confirme a Senha"/>
                                </div>

                                <div class="col-md-12" v-if="userErrors && userErrors.length">
                                    <v-alert v-html="userErrors" type="error"></v-alert>
                                </div>
                            </div>
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-btn text @click="dialog.value = false">Fechar</v-btn>
                        <v-btn form="update-password" :loading="saveLoading" type="submit" color="primary">Salvar</v-btn>
                    </v-card-actions>
                </v-card>
            </template>
        </v-dialog>

    </div>
</template>
<script>
export default {
    data: () => ({
        users: [],
        editUser: {},
        editUserModal: false,
        passwordModal: false,
        userErrors: '',
        roles: [],
        saveLoading: false,
        loading: true,
        editionTab: null,
        search: '',

        usersHeaders: [
            {text: 'Nome', value: 'name'},
            {text: 'E-mail', value: 'email'},
            {text: 'Status', value: 'status_text'},
            {text: 'CPF/CNPJ', value: 'doc_number'},
            {text: 'CRO', value: 'cro'},
            {text: 'Funções', value: 'roles_header'},
            {text: '', value: 'actions_header'},
        ],

        userRules: {
            name: [v => !!v || 'Informe o nome'],
            phone: [v => !!v || 'Informe o telefone'],
            doc_number: [v => !!v || 'Informe o CPF/CNPJ'],
            email: [
                v => !!v || 'Insira o e-mail',
                v => /.+@.+/.test(v) || 'E-mail inválido',
            ],
            password: [
                v => !!v || 'Insira a senha',
                v => (v && v.length >= 6) || 'A senha deve conter pelo menos 6 caracteres',
            ],
            password_confirmation: [
                v => !!v || 'Confirme a senha',
                v => (v && v.length >= 6) || 'A senha deve conter pelo menos 6 caracteres'
            ],
        }
    }),

    mounted(){
        this.getUsers()
        this.getRoles()
    },

    watch: {
        editUserModal: function(v) {
            this.userErrors = ''
            if(!v)
                this.editUser = {}
        },

        
    },

    computed: {
        rolesOptions() {
            return this.roles.map(p => ({
                text: p.name, value: p.id
            }))
        },

        citiesEditOptions() {
            if(this.editUser.id_uf){
                return this.ufs.find(u => u.id == this.editUser.id_uf)
                               .cities
                               .map(c => ({ text: c.name, value: c.id }))
            } else {
                return []
            }
        },

        docNumberMask() {
            let mask = null
            let str = ''
            if( this.editUser.id ){
                str = this.editUser.doc_number
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

    methods: {
        getUsers() {
            this.loading = true
            this.$commom.request({
                url: '/seller',
                auth: true,
                success: resp => {
                    this.loading = false
                    this.users = [...resp]
                }
            })
        },

        getRoles() {
            this.loading = true
            this.$commom.request({
                url: '/roles',
                auth: true,
                success: resp => {
                    this.loading = false
                    this.roles = [...resp]
                },
                error: () => this.loading = false
            })
        },

        

        updatePassword(){
            if( this.$refs.passwordForm.validate() ){
                this.saveLoading = true
                this.$commom.request({
                    url: '/seller/'+this.editUser.id+'/password',
                    type: 'put',
                    auth: true,
                    data: this.editUser,
                    success: resp => {
                        this.passwordModal = false
                        this.editUser = {}
                        this.saveLoading = false
                    },
                    error: e => {
                        this.userErrors = this.$commom.errorMessages(e)
                        this.saveLoading = false
                    }
                })
            }
        },

        toggleStatus(id){
            this.$commom.request({
                url: '/seller/'+id+'/toggle-status',
                type: 'put',
                auth: true,
                success: resp => {
                    this.getUsers()
                }
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