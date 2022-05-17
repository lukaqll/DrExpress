<template>
    <div class="col-md-6 col-lg-5 col-xl-3 col-sm-12 col-xs-12">
        <v-card class="mx-auto" :loading="loading" >
            <v-card-text>
                <h3 class="text-center">Login</h3>
                <v-form ref="form" @submit.prevent="login" v-model="valid">
                    <div class="row">
                        <div class="col-12">
                            <v-text-field
                                autofocus
                                v-model="formData.email"
                                :rules="rules.email"
                                label="E-mail"
                                required
                            ></v-text-field>
                        </div>
                        <div class="col-12">
                            <v-text-field
                                v-model="formData.password"
                                :rules="rules.password"
                                label="Senha"
                                required
                                type="password"
                                min="6"
                            ></v-text-field>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <v-btn type='submit' class="float-right" color="primary">Entrar</v-btn>
                        </div>
                        <div v-if="(errorMessage && errorMessage.length) || $route.query.message" class="col-12">
                            <v-alert type="error" v-html="errorMessage || $route.query.message"/>
                        </div>
                    </div>

                </v-form>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
export default {
    data: () => ({
        formData: {},
        valid: false,
        loading: false,
        errorMessage: '',
        rules: {
            email: [
                v => !!v || 'Insira seu e-mail',
                v => /.+@.+/.test(v) || 'E-mail inválido',
            ],
            password: [
                v => !!v || 'Insira sua senha',
                v => (v && v.length >= 6) || 'A senha deve conter pelo menos 6 caracteres',
            ]
        }
    }),

    methods: {
        login() {
            if( this.$refs.form.validate() ){
                this.loading = false
                this.$commom.request({
                    url: '/login',
                    type: 'post',
                    data: this.formData,
                    success: (resp) => {

                        this.loading = false
                        this.errorMessage = ''

                        this.setUser(resp).then((user) => {
                            this.redirectAfterLogin()
                        })
                    }, 
                    error: (e) => {
                        this.loading = false
                        this.errorMessage = this.$commom.errorMessages(e)
                    }
                })
            }
        },

        async setUser( data ) {
            localStorage.setItem('auth_token', data.access_token)
            return await this.$useStore.setUser(data.user)
        },

        redirectAfterLogin() {

            let redirectTo = '/login?message=Falha%20ao%20redirecionar'
            if( this.$route.query && this.$route.query.redirectTo ){
                redirectTo = this.$route.query.redirectTo
            } else {

                if( this.$hasRole(['admin', 'operator']) ){
                    redirectTo = '/admin'
                } else if ( this.$hasRole(['seller']) ){
                    redirectTo = '/dashboard'
                }
            }

            if( this.$route.fullPath != redirectTo ){
                this.$router.push({ path: redirectTo, replace: true })
            }
        }
    }
}
</script>