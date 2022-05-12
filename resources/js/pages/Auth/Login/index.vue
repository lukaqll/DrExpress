<template>
    <div class="col-md-6 col-lg-5 col-xl-3 col-sm-12 col-xs-12">
        <v-card class="mx-auto" :loading="loading" >
            <v-card-text>
                <h3 class="text-center">Login</h3>
                <v-form @submit.prevent="login" v-model="valid">
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
                        <div v-if="errorMessage && errorMessage.length" class="col-12">
                            <v-alert type="error">{{ errorMessage }}</v-alert>
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
                v => (v && v.length <= 6) || 'A senha deve conter pelo menos 6 caracteres',
            ]
        }
    }),

    watch: {
        $user(newUser, oldUser){
            console.log('user!!!', newUser, oldUser)
        }
    },

    methods: {

        login() {
            this.loading = false
            this.$commom.request({
                url: '/login',
                type: 'post',
                data: this.formData,
                success: (resp) => {
                    this.loading = false
                    this.errorMessage = ''
                    localStorage.setItem('auth_token', resp.access_token)
                    this.$router.push("/admin/permissions")
                }, 
                error: (e) => {
                    this.loading = false
                    this.errorMessage = e.response.data.message
                }
            })
        }
    }
}
</script>