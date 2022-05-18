<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <v-form ref='from' @submit.prevent="update">
                    <v-card :loading="loading" :disabled="loading">
                        <v-card-title class="p-0 pb-4">
                            <v-menu min-width="200px" offset-y absolute>
                                <template v-slot:activator="{ on }">
                                    <v-img 
                                        v-on="on" 
                                        class="cursor-pointer" 
                                        rounded :src="user.banner"
                                        height="auto"
                                    />
                                </template>
                                <v-card>
                                    <v-list-item-content class="justify-center">
                                        <div class="mx-auto text-center">
                                            <v-btn
                                                depressed
                                                rounded
                                                text
                                                @click="bannerModal=true"
                                            >
                                                Alterar Banner
                                            </v-btn>
                                        </div>
                                    </v-list-item-content>
                                </v-card>
                            </v-menu>
                        </v-card-title>
                        <v-card-text>
                            <div class="row">
                                <div class="col-md-3">
                                    <div>
                                        <v-menu min-width="200px" offset-y absolute>
                                            <template v-slot:activator="{ on }">
                                                <v-img 
                                                    v-on="on" 
                                                    class="elevation-2 rounded-lg cursor-pointer" 
                                                    :src="user.picture"
                                                />
                                            </template>
                                            <v-card>
                                                <v-list-item-content class="justify-center">
                                                    <div class="mx-auto text-center">
                                                        <v-btn
                                                            depressed
                                                            rounded
                                                            text 
                                                            @click="pictureModal=true"
                                                        >
                                                            Alterar Imagem
                                                        </v-btn>
                                                    </div>
                                                </v-list-item-content>
                                            </v-card>
                                        </v-menu>
                                    </div>
                                </div>
                                <div class="col-md-9">
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

                                        <div class="col-md-6">
                                            <v-text-field label="CRO" v-model="user.cro"/>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-5">
                                    <v-autocomplete
                                        label='Estado'
                                        :items="ufsOptions"
                                        v-model="user.id_uf"
                                    />
                                </div>
                                <div class="col-md-5">
                                    <v-autocomplete
                                        label='Cidade'
                                        :items="citiesOptions"
                                        v-model="user.id_city"
                                    />
                                </div>

                                <div class="col-md-2">
                                    <div class="row">
                                        <div class="col-12 py-0">
                                            <v-checkbox
                                                class="m-0"
                                                v-model="user.is_delivery"
                                                label="Delivery"
                                            />
                                        </div>
                                        <div class="col-12 py-0">
                                            <v-checkbox
                                                class="m-0"
                                                v-model="user.is_physical"
                                                label="Loja Física"
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

        <!-- uppload picture -->
        <v-dialog max-width="600" v-model="pictureModal">
            <template v-slot:default="dialog">
                <v-card :loading="uploading" :disabled="uploading">
                    <v-card-title>Alterar imagem de perfil</v-card-title>
                    <v-card-text>
                        <v-form id="upload-picture" @submit.prevent="uploadPicture">
                            <div class="row">
                                <div class="col-md-12">
                                    <v-file-input 
                                        v-model="pictureImage" 
                                        label="Arquivo"
                                        counter show-size
                                        accept="image/*"
                                    />
                                </div>
                            </div>
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-btn text @click="dialog.value = false">Fechar</v-btn>
                        <v-btn form="upload-picture" type="submit" color="primary">Salvar</v-btn>
                    </v-card-actions>
                </v-card>
            </template>
        </v-dialog>

        <!-- uppload banner -->
        <v-dialog max-width="600" v-model="bannerModal">
            <template v-slot:default="dialog">
                <v-card :loading="uploading" :disabled="uploading">
                    <v-card-title>Alterar banner</v-card-title>
                    <v-card-text>
                        <v-form id="upload-banner" @submit.prevent="uploadBanner">
                            <div class="row">
                                <div class="col-md-12">
                                    <v-file-input 
                                        v-model="bannerImage" 
                                        label="Arquivo"
                                        counter show-size
                                        accept="image/*"
                                    />
                                </div>
                            </div>
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-btn text @click="dialog.value = false">Fechar</v-btn>
                        <v-btn form="upload-banner" type="submit" color="primary">Salvar</v-btn>
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
        docNumberMask: '###.###.###-##',
        ufs: [],
        pictureModal: false,
        bannerModal: false,
        uploading: false,
        pictureImage: null,
        bannerImage: null,
    }),


    watch: {
        'user.doc_number': function(v){
            this.docNumberMask = (v && v.length > 14) ? '##.###.###/####-##' : '###.###.###-###'
        }
    },

    mounted(){
        this.get()
        this.getUfs()
    },

    computed: {
        ufsOptions() {
            return this.ufs.map(u => ({
                text: `${u.name} (${u.initials})`, value: u.id
            }))
        },

        citiesOptions() {
            if(this.user.id_uf){
                const uf = this.ufs.find(u => u.id == this.user.id_uf)
                if(uf){
                    return uf.cities.map(c => ({ text: c.name, value: c.id }))
                }
            } 
            return []
        },
    },

    methods: {
        get(){
            this.loading = true
            this.$commom.request({
                url: '/seller/me',
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
                    url: '/seller/me/update',
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

        getUfs(){
            this.$commom.request({
                url: '/uf/',
                auth: true,
                success: resp => {
                    this.ufs = [...resp]
                }
            })
        },

        uploadPicture(){
            if( this.pictureImage ){
                this.uploading = true
                const formData = new FormData()
                formData.append('file', this.pictureImage)
                this.$commom.request({
                    url: '/user/me/upload-picture',
                    auth: true,
                    type: 'post',
                    data: formData,
                    file: true,
                    setError: true,
                    success: resp => {
                        this.get()
                        this.pictureModal = false
                        this.uploading = false
                        this.pictureImage = null
                    },
                    error: () => {this.uploading = false}
                })
            }
        },

        uploadBanner(){
            if( this.bannerImage ){
                this.uploading = true
                const formData = new FormData()
                formData.append('file', this.bannerImage)
                this.$commom.request({
                    url: '/user/me/upload-banner',
                    auth: true,
                    type: 'post',
                    data: formData,
                    file: true,
                    setError: true,
                    success: resp => {
                        this.get()
                        this.bannerModal = false
                        this.uploading = false
                        this.bannerImage = null
                    },
                    error: () => {this.uploading = false}
                })
            }
        }
    }
}
</script>