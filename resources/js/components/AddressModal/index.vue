<template>
    <v-dialog v-model="isVisible" max-width="700">
        <v-card >
            <v-card-title>{{idAddress?'Editar':'Novo'}} Endereço</v-card-title>
            <v-card-text>
                <v-form id="address-form" @submit.prevent="onSave">
                    <div class="row">
                        <div class="col-md-6">
                            <v-select
                                label='Estado'
                                :items="ufs"
                                v-model="address.id_uf"
                                item-text="name"
                                item-value="id"
                            />
                        </div>
                        <div class="col-md-6">
                            <v-select
                                label='Cidade'
                                :items="cities"
                                v-model="address.id_city"
                                item-text="name"
                                item-value="id"
                                no-data-text="Selecione um estado"
                            />
                        </div>
                        <div class="col-md-6">
                            <v-autocomplete
                                label='Bairro'
                                :items="districts"
                                v-model="address.id_district"
                                item-text="name"
                                item-value="id"
                                no-data-text="Selecione uma cidade"
                            />
                        </div>
                        <div class="col-md-6">
                            <v-text-field v-model="address.street" label="Rua"/>
                        </div>
                        <div class="col-md-3">
                            <v-text-field v-model="address.cep" label="CEP" v-mask="'#####-###'"/>
                        </div>
                        <div class="col-md-2">
                            <v-text-field v-model="address.number" label="Nº"/>
                        </div>
                        <div class="col-md-7">
                            <v-text-field v-model="address.complement" label="Complemento"/>
                        </div>
                        <div class="col-md-12">
                            <v-text-field v-model="address.reference" label="Referência"/>
                        </div>

                        <div class="col-md-12">
                            <v-checkbox
                                label="Endereço padrão"
                                v-model="address.is_default"
                            />
                        </div>
                    </div>
                </v-form>
            </v-card-text>
            <v-card-actions class="justify-end">
                <v-btn text @click="() => {isVisible=false; onHide()}">Fechar</v-btn>
                <v-btn form="address-form" type="submit" color="primary">Salvar</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
export default {
    props: {visible: Boolean, idAddress: Number},
    data: () => ({
        address: {},

        ufs: [],
        cities: [],
        districts: [],

        isVisible: false
    }),

    watch: {
        visible(v){
            if(v){
                this.onShow()
            } else {
                this.address = {}
                this.isVisible=false
            }
        },

        isVisible(v){
            if(!v){
                this.onHide()
            }
        },

        'address.id_uf': function(id_uf){
            if(id_uf){
                this.getCities()
            } else {
                this.cities = []
            }
        },
        'address.id_city': function(id_city){
            if(id_city){
                this.getDistricts()
            } else {
                this.districts = []
            }
        },
    },

    methods: {
        onShow(){
            this.$emit('onShow')
            this.isVisible = true
            this.getUfs()

            if( this.idAddress ){
                this.getAdresses()
            }
        },
        onHide(){
            this.address = {}
            this.$emit('onHide')
        },
        onSave(){
            this.$emit('onSave', this.address)
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
        getCities(){
            this.$commom.request({
                url: `/uf/${this.address.id_uf}/cities`,
                auth: true,
                success: resp => {
                    this.cities = [...resp.cities]
                }
            })
        },
        getDistricts(){
            this.$commom.request({
                url: `/city/${this.address.id_city}`,
                auth: true,
                success: resp => {
                    this.districts = [...resp.districts]
                }
            })
        },

        getAdresses() {
            this.loading = true
            this.$commom.request({
                url: '/address/'+this.idAddress,
                auth: true,
                success: resp => {
                    this.address = {...resp}
                },
                error: () => this.loading = false
            })
        },

        getCity(){
            return this.cities.find(c => c.id == this.address.id_city)
        }
    }
}
</script>