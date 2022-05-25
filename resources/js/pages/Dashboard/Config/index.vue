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
                                                hint="Indica se está disponível para receber novos pedidos de venda."
                                                persistent-hint
                                            />
                                            <v-switch
                                                label="Loja Física"
                                                v-model="config.is_physical"
                                                hint="Informa se possui uma loja física ou não."
                                                persistent-hint
                                            />
                                            <v-switch
                                                label="Delivery"
                                                v-model="config.is_delivery"
                                                hint="Indica se você faz entregas ou somente aceita busca presencial."
                                                persistent-hint
                                            />
                                        </div>

                                        <div class="col-md-6">
                                            <v-select 
                                                v-model="config.visibility" 
                                                :items="visibilityOptions" 
                                                label="Visibilidade"
                                                hint="Informa sua visibilidade no aplicative."
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
        config(v){
            console.log(v)
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
            if( this.$refs.from.validate() ){
                this.loading = true
                this.$commom.request({
                    url: '/seller/me/config',
                    type: 'put',
                    auth: true,
                    data: this.config,
                    successAlert: true,
                    success: resp => {
                        this.get()
                        this.loading = false
                        this.errors = ''
                        this.config = {...resp}
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