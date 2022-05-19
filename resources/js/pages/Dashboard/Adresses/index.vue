<template>
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-8">
            <v-card :loading="loading" :disabled="loading">
                <v-card-title>
                    Meus Endereços
                </v-card-title>
                <v-card-text>
                    <v-form ref="createForm" id="new-user" @submit.prevent="createUser">
                        <v-list>
                            <v-list-item 
                                v-for="(ad, i) in adresses" :key="i"
                                @click="() => getAddress(ad.id)"
                                class="border-bottom"
                            >
                                <v-list-item-content>
                                    <v-list-item-title>{{ad.street}}</v-list-item-title>
                                    <v-list-item-subtitle>
                                        {{ ad.city_name }} - {{ ad.uf_name }} <br>
                                        {{ ad.district_name }} - {{ ad.number }}
                                    </v-list-item-subtitle>
                                </v-list-item-content>
                                <v-list-item-action-text v-if="!!ad.is_default">
                                    Endereço Padrão
                                </v-list-item-action-text>
                                <v-list-item-action>
                                    <v-icon small>fa fa-chevron-right</v-icon>
                                </v-list-item-action>
                            </v-list-item>
                            <v-list-item @click="() => {addressModal=true; idAddress=null}" class="text-primary">
                                <v-list-item-content >
                                    <v-list-item-title>Adicionar Endereço</v-list-item-title>
                                </v-list-item-content>
                                <v-list-item-action>
                                    <v-icon small color="primary">fa fa-plus</v-icon>
                                </v-list-item-action>
                            </v-list-item>
                        </v-list>
                    </v-form>
                </v-card-text>
            </v-card>
        </div>

        <address-modal
            :visible="addressModal"
            :idAddress="idAddress"
            @onHide="addressModal=false"
            @onSave="onAddressSave"
        />
    </div>
</template>
<script>
import AddressModal from '../../../components/AddressModal'

export default {
    
    components: {AddressModal},

    data: () => ({
        adresses: [],
        tab: null,
        loading: null,
        errors: '',
        addressModal: false,
        idAddress: null
    }),

    mounted(){
        this.getAdresses()
    },


    watch: {
        
        addressModal(v){
            if(!v) this.idAddress = null
        }


    },
    
    methods: {


        getAdresses() {
            this.loading = true
            this.$commom.request({
                url: '/user/me/address',
                auth: true,
                success: resp => {
                    this.loading = false
                    this.adresses = [...resp]
                },
                error: () => this.loading = false
            })
        },

        onAddressSave(address){
            if(this.idAddress){
                this.updateAddress(address)
            } else {
                this.createAddress(address)
            }
        },
        updateAddress(address){
            this.loading = true
            this.$commom.request({
                url: `/address/me/${this.idAddress}`,
                type: 'put',
                auth: true,
                data: address,
                setError: true,
                success: resp => {
                    this.loading = false
                    this.addressModal = false
                    this.getAdresses()
                },
                error: e => {
                    this.loading = false
                    this.errors = this.$commom.errorMessages(e)
                }
            })
        },
        createAddress(address){
            this.loading = true
            this.$commom.request({
                url: `/user/me/address`,
                type: 'post',
                auth: true,
                data: address,
                setError: true,
                success: resp => {
                    this.loading = false
                    this.addressModal = false
                    this.getAdresses()
                },
                error: e => {
                    this.loading = false
                }
            })
        },

        getAddress(id){
            this.idAddress = id
            this.addressModal = true
        }
    }
}
</script>