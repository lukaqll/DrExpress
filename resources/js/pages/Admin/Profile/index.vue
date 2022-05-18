<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <v-form ref='from' @submit.prevent="update">
                    <v-card :loading="loading">
                        <v-card-title>Minha Conta</v-card-title>
                        <v-card-text>
                            <div class="row">
                                <div class="col-md-6">
                                    <v-text-field label="Nome" v-model="user.name" :rules="rules.name"/>
                                </div>
                                <div class="col-md-6">
                                    <v-text-field type="email" label="E-mail" v-model="user.email" :rules="rules.email"/>
                                </div>
                                <div class="col-md-6">
                                    <v-text-field-simplemask
                                        label="CPF/CNPJ"
                                        v-model="user.doc_number"
                                        :options="{inputMask: docNumberMask, outputMask: docNumberMask}"
                                    />
                                </div>
                                <div class="col-md-6">
                                    <v-text-field type="date" label="Nascimento" v-model="user.birthdate"/>
                                </div>
                                <div class="col-md-6">
                                    <v-text-field label="Telefone" v-model="user.phone" v-mask="'(##) #####-####'"/>
                                </div>
                                <div class="col-md-12">
                                    <h5>Funções</h5>
                                    <v-badge v-for="(role, i) in user.roles" :key="i" :content="role.name"/>
                                </div>
                                <div class="col-md-12" v-if="errors && errors.length">
                                    <v-alert v-html="errors" type="error"></v-alert>
                                </div>
                            </div>
                        </v-card-text>
                        <v-card-actions class="justify-end">
                            <v-btn text color="primary" @click="passwordModal = true">Alterar Senha</v-btn>
                            <v-btn type="submit" color="primary">Salvar Alterações</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-form>
            </div>
        </div>

        <!-- update password -->
        <v-dialog max-width="400" v-model="passwordModal">
            <template v-slot:default="dialog">
                <v-card>
                    <v-card-title>Alterar senha</v-card-title>
                    <v-card-text>
                        <v-form ref="passwordForm" id="update-password" @submit.prevent="updatePassword">
                            <div class="row">
                                <div class="col-md-12">
                                    <v-text-field type="password" :rules="rules.password" v-model="password.password" label="Senha"/>
                                </div>
                                <div class="col-md-12">
                                    <v-text-field type="password" :rules="rules.password_confirmation" v-model="password.password_confirmation" label="Confirme a Senha"/>
                                </div>

                                <div class="col-md-12" v-if="passwordErrors && passwordErrors.length">
                                    <v-alert v-html="passwordErrors" type="error"></v-alert>
                                </div>
                            </div>
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-btn text @click="dialog.value = false">Fechar</v-btn>
                        <v-btn form="update-password" :loading="passwordLoading" type="submit" color="primary">Salvar</v-btn>
                    </v-card-actions>
                </v-card>
            </template>
        </v-dialog>
    </div>
</template>

<script>
export default {
    data: () => ({
        user: {},
        loading: false,
        errors: '',
        passwordErrors: '',
        passwordModal: '',
        password: {},
        passwordLoading: false,
        rules: {
            name: [v => !!v || 'Informe o nome'],
            email: [
                v => !!v || 'Insira seu e-mail',
                v => /.+@.+/.test(v) || 'E-mail inválido',
            ],
            password: [
                v => !!v || 'Insira sua senha',
                v => (v && v.length >= 6) || 'A senha deve conter pelo menos 6 caracteres',
            ],
            password_confirmation: [
                v => !!v || 'Confirme a senha',
                v => (v && v.length >= 6) || 'A senha deve conter pelo menos 6 caracteres'
            ],
        },
        docNumberMask: '###.###.###-##'
    }),


    watch: {
        'user.doc_number': function(v){
            this.docNumberMask = (v && v.length > 14) ? '##.###.###/####-##' : '###.###.###-###'
        }
    },

    mounted(){
        this.get()
    },

    methods: {
        get(){
            this.loading = true
            this.$commom.request({
                url: '/operators/me',
                auth: true,
                success: resp => {
                    this.loading = false
                    this.user = {...resp}
                }
            })
        },

        update(){
            if( this.$refs.from.validate() ){
                this.loading = true
                this.$commom.request({
                    url: '/operators/me/update',
                    type: 'put',
                    auth: true,
                    data: this.user,
                    successAlert: true,
                    success: resp => {
                        this.get()
                        this.loading = false
                        this.errors = ''
                        this.user = {...resp}
                    }, 
                    error: e => {
                        this.errors = this.$commom.errorMessages(e)
                        this.loading = false
                    }
                })
            }
        },

        updatePassword(){
            if( this.$refs.passwordForm.validate() ){
                this.passwordLoading = true
                this.$commom.request({
                    url: '/user/me/update-password',
                    type: 'put',
                    auth: true,
                    data: this.password,
                    successAlert: true,
                    success: resp => {
                        this.passwordLoading = false
                        this.passwordErrors = ''
                        this.password = {}
                        this.passwordModal = false
                    }, 
                    error: e => {
                        this.passwordErrors = this.$commom.errorMessages(e)
                        this.passwordLoading = false
                    }
                })
            }
        },
    }
}
</script>