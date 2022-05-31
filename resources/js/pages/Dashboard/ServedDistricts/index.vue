<template>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <v-card :loading="loading">
                <v-card-title>
                    <div class="row">
                        <div class="col-12">
                            Locais Atendidos
                            <v-btn v-if="$can('create-served-district')" text color="primary" class="float-right" @click="newLocaleModal = true">Adicionar Local</v-btn>
                            <v-btn v-if="$can('delete-served-district') && selectedItems.length" text color="error" class="float-right" @click="deleteSelectedLocale">Deletar selecionados</v-btn>
                        </div>
                    </div>
                </v-card-title>
                <v-card-text>
                    <div class="row">
                        <div class="col-md-3">
                            <v-autocomplete
                                label='Estado' outlined dense
                                :items="ufs"
                                v-model="filter.id_uf"
                                item-text="name"
                                item-value="id" clearable
                            />
                        </div>
                        <div class="col-md-3">
                            <v-autocomplete
                                label='Cidade' outlined dense
                                :items="filterCities"
                                v-model="filter.id_city"
                                item-text="name"
                                item-value="id" clearable
                                no-data-text="Selecione um estado"
                            />
                        </div>
                        <div class="col-md-3">
                            <v-autocomplete
                                label='Bairro' outlined dense
                                :items="filterDistricts"
                                v-model="filter.id_district"
                                item-text="name"
                                item-value="id" clearable
                                no-data-text="Selecione uma cidade"
                            />
                        </div>
                    </div>
                    <v-data-table
                        :headers="localeHeaders"
                        :items="locales"
                        show-select v-model="selectedItems"
                        :items-per-page="-1" disable-sort
                    >
                        <template v-slot:item.locale="{ item }">
                            <small>{{item.uf_name}}</small> > <small>{{item.city_name}}</small> > <b>{{item.district.name}}</b>
                        </template>
                        <template v-slot:item.delivery="{ item }">
                            de {{item.min_delivery_time}} a {{item.max_delivery_time}} {{item.time_type_text}}
                        </template>
                        <template v-slot:item.freight="{ item }">
                            <span v-if="item.freight > 0">R$ {{ $commom.toMoney(item.freight) }} </span>
                            <span v-else class="text-success">Grátis</span>
                            
                        </template>
                        <template v-slot:item.actions_header="{ item }">
                            <v-btn v-if="$can('update-served-district')" icon color="primary" @click="() => getLocale(item.id)">
                                <v-icon small>fa fa-edit</v-icon>
                            </v-btn>
                            <v-btn v-if="$can('delete-served-district')" @click="() => deleteLocale(item.id)" icon>
                                <v-icon small color="error">fa fa-trash</v-icon>
                            </v-btn>
                        </template>
                    </v-data-table>
                </v-card-text>
            </v-card>
        </div>

        <!-- create locale -->
        <v-dialog max-width="900" v-model="newLocaleModal">
            <template v-slot:default="dialog">
                <v-card>
                    <v-card-title>Adicionar local atendido</v-card-title>
                    <v-card-text>
                        <v-form ref="createForm" id="new-locale" @submit.prevent="createLocale">
                            <div class="row">
                                <div class="col-md-6">
                                    <v-autocomplete
                                        label='Estado'
                                        :items="ufs"
                                        v-model="locale.id_uf"
                                        item-text="name"
                                        item-value="id"
                                    />
                                </div>
                                <div class="col-md-6">
                                    <v-autocomplete
                                        label='Cidade'
                                        :items="cities"
                                        v-model="locale.id_city"
                                        item-text="name"
                                        item-value="id"
                                        no-data-text="Selecione um estado"
                                    />
                                </div>
                                <div class="col-md-12">
                                    <v-autocomplete
                                        label='Bairros'
                                        :items="districts"
                                        v-model="locale.id_district"
                                        item-text="name"
                                        item-value="id"
                                        multiple chips small-chips :return-object="false"
                                        no-data-text="Selecione uma cidade"
                                    >
                                        <template v-slot:prepend-item>
                                            <v-list-item
                                                ripple
                                                @mousedown.prevent
                                                @click="selectAll"
                                                v-if="districts && districts.length"
                                                dense
                                            >
                                                <v-list-item-content>
                                                    <v-list-item-title>Selecionar Todos</v-list-item-title>
                                                </v-list-item-content>
                                            </v-list-item>
                                            <v-divider class="mt-2"></v-divider>
                                        </template>
                                    </v-autocomplete>
                                </div>
                            
                                <div class="row">
                                    <label>Tempo de entrega</label>
                                    <div class="col-md-2">
                                        <v-text-field
                                            label="De"
                                            outlined dense
                                            v-model="locale.min_delivery_time"
                                            type="number" min="0.1" step="0.1"
                                        />
                                    </div>
                                    <div class="col-md-2">
                                        <v-text-field
                                            label="a"
                                            outlined dense
                                            v-model="locale.max_delivery_time"
                                            type="number" min="0.1" step="0.1"
                                        />
                                    </div>
                                    <div class="col-md-4">
                                        <v-select
                                            outlined dense
                                            v-model="locale.time_type"
                                            :items="[{text: 'Minutos', value: 'i'}, {text: 'Horas', value: 'H'}, {text: 'Dias', value: 'd'}]"
                                        />
                                    </div>
                                    <div class="col-md-4">
                                        <v-text-field
                                            label="Frete"
                                            outlined dense
                                            v-model="locale.freight" persistent-hint
                                            hint="Informe o frete cobrado até este local"
                                            v-money="{}"
                                        />
                                    </div>
                                </div>
                            </div>
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-btn text @click="dialog.value = false">Fechar</v-btn>
                        <v-btn form="new-locale" :loading="saveLoading" type="submit" color="primary">Salvar</v-btn>
                    </v-card-actions>
                </v-card>
            </template>
        </v-dialog>

        <!-- edit user -->
        <v-dialog max-width="500" v-model="editLocaleModal">
            <template v-slot:default="dialog">
                <v-card>
                    <v-card-title>Editar Local</v-card-title>
                    <v-card-text>
                        <v-form ref="updateForm" id="edit-locale" @submit.prevent="updateLocale">
                            <div class="row">
                                <div class="col-12" v-if="editLocale.district">
                                    {{editLocale.uf_name}} > {{editLocale.city_name}} > <b>{{editLocale.district.name}}</b>
                                </div>
                                <div class="col-md-3">
                                    <v-text-field
                                        label="De"
                                        outlined dense
                                        v-model="editLocale.min_delivery_time"
                                        type="number" min="0.1" step="0.1"
                                    />
                                </div>
                                <div class="col-md-3">
                                    <v-text-field
                                        label="a"
                                        outlined dense
                                        v-model="editLocale.max_delivery_time"
                                        type="number" min="0.1" step="0.1"
                                    />
                                </div>
                                <div class="col-md-6">
                                    <v-select
                                        outlined dense
                                        v-model="editLocale.time_type"
                                        :items="[{text: 'Minutos', value: 'i'}, {text: 'Horas', value: 'H'}, {text: 'Dias', value: 'd'}]"
                                    />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <v-text-field
                                    v-if="editLocale.freight"
                                    label="Frete"
                                    v-model="editLocale.freight" persistent-hint
                                    hint="Informe o frete cobrado até este local"
                                    v-money="{}"
                                />
                            </div>
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="justify-content-between">
                        <v-btn text @click="() => deleteLocale(editLocale.id)" color="error">Remover</v-btn>
                        <div>
                            <v-btn text @click="dialog.value = false">Fechar</v-btn>
                            <v-btn form="edit-locale" :loading="saveLoading" type="submit" color="primary">Salvar</v-btn>
                        </div>
                    </v-card-actions>
                </v-card>
            </template>
        </v-dialog>

    </div>
</template>
<script>

const initialLocale = {time_type: 'i', freight: 0}
export default {
    data: () => ({
        locales: [],
        locale: {...initialLocale},
        editLocale: {},
        newLocaleModal: false,
        editLocaleModal: false,
        saveLoading: false,
        loading: true,

        localeHeaders: [
            {text: 'Local', value: 'locale'},
            {text: 'Entrega', value: 'delivery'},
            {text: 'Frete', value: 'freight'},
            {text: '', value: 'actions_header'},
        ],

        ufs: [],
        cities: [],
        districts: [],
        selectedItems: [],

        filterCities: [],
        filterDistricts: [],
        filter: {},

    }),

    mounted(){
        this.getLocales()
        this.getUfs()
    },

    watch: {
        newLocaleModal: function(v) {
            !v ? this.locale = {...initialLocale} : null
        },
        editLocaleModal: function(v) {
            !v ? this.editLocale = {} : null
        },

        'locale.id_uf': function(id_uf){
            if(id_uf){
                this.getCities()
            } else {
                this.cities = []
            }
        },
        'locale.id_city': function(id_city){
            if(id_city){
                this.getDistricts()
            } else {
                this.districts = []
            }
        },

        'filter.id_uf': function(id_uf){
            const newFilter = this.filter
            newFilter.id_city = null
            newFilter.id_district = null
            this.filter = {...newFilter}
            if(id_uf){
                this.getFilterCities()
            } else {
                this.filterCities = []
            }
        },
        'filter.id_city': function(id_city){
            const newFilter = this.filter
            newFilter.id_district = null
            this.filter = {...newFilter}

            if(id_city){
                this.getFilterDistricts()
            } else {
                this.filterDistricts = []
            }
        },
        filter: {
            handler(v){
                this.getLocales()
            },
            deep: true
        }
    },

    methods: {
        getLocales() {
            this.loading = true
            this.$commom.request({
                url: '/served-district',
                auth: true,
                data: this.filter,
                success: resp => {
                    this.loading = false
                    this.locales = [...resp]
                }
            })
        },

        getLocale(id) {
            const locale = this.locales.find(b => b.id == id)
            this.editLocale = {...locale}
            this.editLocaleModal = true
        },

        createLocale(){
            if( this.$can('create-served-district') ){
                this.saveLoading = true
                this.$commom.request({
                    url: '/served-district',
                    type: 'post',
                    auth: true,
                    data: this.locale,
                    setError: true,
                    success: resp => {
                        this.getLocales()
                        this.saveLoading = false
                        const locale = this.locale
                        locale.id_district = null
                        this.locale = {...locale}
                        this.selectedItems = []
                    },
                    error: e => {
                        this.saveLoading = false
                    }
                })
            }
        },

        updateLocale(){
            if( this.$can('update-served-district') ){
                this.saveLoading = true
                this.$commom.request({
                    url: '/served-district/'+this.editLocale.id,
                    type: 'put',
                    auth: true,
                    data: this.editLocale,
                    setError: true,
                    success: resp => {
                        this.getLocales()
                        this.saveLoading = false
                        this.editLocaleModal = false
                        this.editLocale = {}
                        this.selectedItems = []
                    },
                    error: e => {
                        this.saveLoading = false
                    }
                })
            }
        },

        deleteLocale(id){
            if( this.$can('delete-served-district') ){
                this.$commom.confirm({
                    title: 'Deseja deletar este local?',
                    onConfirm: () => {
                        this.saveLoading = true
                        this.$commom.request({
                            url: '/served-district/'+id,
                            type: 'delete',
                            auth: true,
                            setError: true,
                            success: resp => {
                                this.getLocales()
                                this.saveLoading = false
                                this.editLocaleModal = false
                                this.editLocale = {}
                                this.selectedItems = []
                            },
                            error: e => {
                                this.saveLoading = false
                            }
                        })
                    }
                })
            }
        },

        deleteSelectedLocale(){
            if( this.$can('delete-served-district') ){
                this.$commom.confirm({
                    title: 'Deseja deletar estes locais?',
                    onConfirm: () => {

                        const ids = this.selectedItems.map(i => i.id)
                        
                        this.saveLoading = true
                        this.$commom.request({
                            url: '/served-district/multiple',
                            type: 'delete',
                            auth: true,
                            setError: true,
                            data: {ids},
                            success: resp => {
                                this.getLocales()
                                this.saveLoading = false
                                this.editLocaleModal = false
                                this.editLocale = {}
                                this.selectedItems = []
                            },
                            error: e => {
                                this.saveLoading = false
                            }
                        })
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
        getCities(){
            this.$commom.request({
                url: `/uf/${this.locale.id_uf}/cities`,
                auth: true,
                success: resp => {
                    this.cities = [...resp.cities]
                }
            })
        },
        getDistricts(){
            this.$commom.request({
                url: `/city/${this.locale.id_city}`,
                auth: true,
                success: resp => {
                    this.districts = [...resp.districts]
                }
            })
        },

        getFilterCities(){
            this.$commom.request({
                url: `/uf/${this.filter.id_uf}/cities`,
                auth: true,
                success: resp => {
                    this.filterCities = [...resp.cities]
                }
            })
        },
        getFilterDistricts(){
            this.$commom.request({
                url: `/city/${this.filter.id_city}`,
                auth: true,
                success: resp => {
                    this.filterDistricts = [...resp.districts]
                }
            })
        },

        selectAll () {
            this.$nextTick(() => {
                const locale = this.locale

                if (locale.id_district && this.districts.length == locale.id_district.length) {
                    locale.id_district = []
                } else {
                    locale.id_district = this.districts.map(i => i.id)
                }
                this.locale = {...locale}
            })
        },

    }
}
</script>