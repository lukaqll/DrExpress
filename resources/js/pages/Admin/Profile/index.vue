<template>
    <div>
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
                            <v-text-field label="CPF" v-model="user.doc_number"/>
                        </div>
                        <div class="col-md-6">
                            <v-text-field type="date" label="Nascimento" v-model="user.birthdate"/>
                        </div>

                        <div class="col-md-12" v-if="errors && errors.length">
                            <v-alert v-html="errors" type="error"></v-alert>
                        </div>
                    </div>
                </v-card-text>
                <v-card-actions class="justify-end">
                    <v-btn type="submit" color="primary">Salvar Alterações</v-btn>
                </v-card-actions>
            </v-card>
        </v-form>
    </div>
</template>

<script>
export default {
    data: () => ({
        user: {},
        loading: false,
        errors: '',
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
        }
    }),

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
    }
}
</script>