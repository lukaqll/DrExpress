<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-12 col-xl-8">
                <v-form ref='from' @submit.prevent="update">
                    <v-card :loading="loading" :disabled="loading">
                        <v-card-title>Configurações</v-card-title>
                        <v-card-text>
                            <div class="row">

                                <div class="col-md-8">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <v-switch
                                                label="Aberto"
                                                v-model="config.is_open"
                                                messages="Indica se está disponível para receber novos pedidos de venda."
                                                dense inset
                                            />
                                            <v-switch
                                                label="Loja Física"
                                                v-model="config.is_physical"
                                                messages="Informa se possui uma loja física ou não."
                                                dense inset
                                            />
                                            <v-switch
                                                label="Delivery"
                                                v-model="config.is_delivery"
                                                messages="Indica se você faz entregas ou somente aceita busca presencial."
                                                dense inset
                                            />
                                        </div>

                                        <div class="col-md-6">
                                            <v-select 
                                                v-model="config.visibility" 
                                                :items="visibilityOptions" 
                                                label="Visibilidade"
                                                hint="Informa sua visibilidade no aplicativo."
                                                persistent-hint
                                            />
                                        </div>
                                    </div>
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
        </div>

    </div>
</template>

<script>
export default {
    data: () => ({
        config: {},
        loading: false,
        errors: '',

        visibilityOptions: [
            {text: 'Visível', value: 'V'},
            {text: 'Oculto', value: 'O'},
            {text: 'Em breve', value: 'B'},
        ]
    }),

    mounted(){
        this.get()
    },

    watch: {
        '$useStore.user.config.is_open': function(v){
            this.config = {...this.config, is_open: v}
        }
    },

    methods: {
        get(){
            this.loading = true
            this.$commom.request({
                url: '/seller/me',
                auth: true,
                success: resp => {
                    this.loading = false
                    this.config = {...resp.config}
                }
            })
        },

        update(){
            this.loading = true
            this.$commom.request({
                url: '/seller/me/config',
                type: 'put',
                auth: true,
                data: this.config,
                success: resp => {
                    this.loading = false
                    this.$commom.refreshUser()
                    this.errors = ''
                }, 
                error: e => {
                    this.loading = false
                    this.errors = this.$commom.errorMessages(e)
                }
            })
        },

    }
}
</script>