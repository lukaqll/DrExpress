<template>
    <div>
        <v-card :loading="loading">
            <v-card-title>
                <div class="row">
                    <div class="col-12">
                        Usuários Operadores
                        <v-btn v-if="$can('create-user')" text color="primary" class="float-right" @click="newUserModal = true">Novo Usuário</v-btn>
                    </div>
                </div>
            </v-card-title>
            <v-card-text>
                <v-data-table
                    :headers="usersHeaders"
                    :items="users"
                >
                    <template v-slot:item.roles_header="{ item }">
                        <span class="badge rounded-full bg-primary mr-1" v-for="(role, i) in item.roles" :key="i">{{role.name}}</span>
                    </template>
                    <template v-slot:item.actions_header="{ item }">
                        <v-btn v-if="$can('update-user')" icon color="primary" @click="() => getUser(item.id)">
                            <v-icon small>fa fa-edit</v-icon>
                        </v-btn>
                        <v-btn v-if="$can('update-user')" icon color="primary" @click="() => getUser(item.id, true)">
                            <v-icon small>fa fa-key</v-icon>
                        </v-btn>
                        <v-btn v-if="$can('update-user')" @click="() => toggleStatus(item.id)" icon :color="item.status == 'A' ? 'success' : 'error'" data-toggle="tooltip" :title="item.status == 'A' ? 'Desativar' : 'Ativar'">
                            <v-icon small>fa fa-power-off</v-icon>
                        </v-btn>
                    </template>
                </v-data-table>
            </v-card-text>
        </v-card>

        <!-- create user -->
        <v-dialog max-width="800" v-model="newUserModal">
            <template v-slot:default="dialog">
                <v-card>
                    <v-card-title>Novo usuário</v-card-title>
                    <v-card-text>
                        <v-form ref="createForm" id="new-user" @submit.prevent="createUser">
                            <div class="row">
                                <div class="col-md-6">
                                    <v-text-field autofocus :rules="userRules.name" v-model="user.name" label="nome"/>
                                </div>
                                <div class="col-md-6">
                                    <v-text-field type="email" :rules="userRules.email" v-model="user.email" label="E-mail"/>
                                </div>

                                <div class="col-md-6">
                                    <v-text-field type="password" :rules="userRules.password" v-model="user.password" label="Senha"/>
                                </div>
                                <div class="col-md-6">
                                    <v-text-field type="password" :rules="userRules.password_confirmation" v-model="user.password_confirmation" label="Confirme a Senha"/>
                                </div>

                                <div class="col-md-12" v-if="userErrors && userErrors.length">
                                    <v-alert v-html="userErrors" type="error"></v-alert>
                                </div>
                            </div>
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-btn text @click="dialog.value = false">Fechar</v-btn>
                        <v-btn form="new-user" :loading="saveLoading" type="submit" color="primary">Salvar</v-btn>
                    </v-card-actions>
                </v-card>
            </template>
        </v-dialog>

        <!-- edit user -->
        <v-dialog max-width="800" v-model="editUserModal">
            <template v-slot:default="dialog">
                <v-card>
                    <v-card-title>Editar Usuário</v-card-title>
                    <v-card-text>
                        <v-form ref="updateForm" id="edit-user" @submit.prevent="updateUser">
                            <div class="row">
                                <div class="col-md-6">
                                    <v-text-field autofocus :rules="userRules.name" v-model="editUser.name" label="nome"/>
                                </div>
                                <div class="col-md-6">
                                    <v-text-field type="email" :rules="userRules.email" v-model="editUser.email" label="E-mail"/>
                                </div>

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
        user: {},
        editUser: {},
        newUserModal: false,
        editUserModal: false,
        passwordModal: false,
        userErrors: '',
        roles: [],
        saveLoading: false,
        loading: true,

        usersHeaders: [
            {text: 'Nome', value: 'name'},
            {text: 'E-mail', value: 'email'},
            {text: 'Status', value: 'status_text'},
            {text: 'Funções', value: 'roles_header'},
            {text: '', value: 'actions_header'},
        ],

        userRules: {
            name: [v => !!v || 'Informe o nome'],
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
        newUserModal: function(v) {
            this.userErrors = ''
            !v ? this.user = {} : null
        },
        editUserModal: function(v) {
            this.userErrors = ''
            !v ? this.editUser = {} : null

        }
    },

    computed: {
        rolesOptions() {
            return this.roles.map(p => ({
                text: p.name, value: p.id
            }))
        },
    },

    methods: {
        getUsers() {
            this.loading = true
            this.$commom.request({
                url: '/operators',
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

        getUser(id, toPassword=false) {
            this.loading = true
            this.$commom.request({
                url: '/operators/'+id,
                auth: true,
                success: resp => {
                    this.editUser = {...resp}
                    this.loading = false
                    if( toPassword ){
                        this.passwordModal = true
                    } else {
                        this.editUserModal = true
                    }
                },
                error: () => this.loading = false
            })
        },

        createUser(){
            if( this.$refs.createForm.validate() ){
                this.saveLoading = true
                this.$commom.request({
                    url: '/operators',
                    type: 'post',
                    auth: true,
                    data: this.user,
                    success: resp => {
                        this.getUsers()
                        this.saveLoading = false
                        this.newUserModal = false
                        this.user = {}
                    },
                    error: e => {
                        this.userErrors = this.$commom.errorMessages(e)
                        this.saveLoading = false
                    }
                })
            }
        },

        updateUser(){
            if( this.$refs.updateForm.validate() ){
                this.saveLoading = true
                this.$commom.request({
                    url: '/operators/'+this.editUser.id,
                    type: 'put',
                    auth: true,
                    data: this.editUser,
                    success: resp => {
                        this.getUsers()
                        this.saveLoading = false
                        this.editUserModal = false
                        this.editUser = {}
                    },
                    error: e => {
                        this.userErrors = this.$commom.errorMessages(e)
                        this.saveLoading = false
                    }
                })
            }
        },

        updatePassword(){
            if( this.$refs.passwordForm.validate() ){
                this.saveLoading = true
                this.$commom.request({
                    url: '/operators/'+this.editUser.id+'/password',
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
                url: '/operators/'+id+'/toggle-status',
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
        }

    }
}
</script>