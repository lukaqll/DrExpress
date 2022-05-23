<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <p class="h3">{{ product.name }}</p>
                    <v-breadcrumbs :items="product.category_flow" divider=">" class="p-0">
                        <template v-slot:item="{ item }">
                            <v-breadcrumbs-item
                                :href="item.href"
                                :disabled="item.disabled"
                            >
                                {{ item }}
                            </v-breadcrumbs-item>
                        </template>
                    </v-breadcrumbs>
                </div>
                <v-card :disabled="generalLoading">
                    <v-card-title>Geral</v-card-title>
                    <v-card-text>

                        <div class="row">
                            <div class="col-12">
                                <v-text-field label="Título" v-model="product.name"/>
                            </div>
                            <div class="col-md-6">
                                <v-combobox
                                        :items="brands"
                                        item-text="name"
                                        label="Marca"
                                        hide-no-data
                                        v-model="product.brand"
                                        item-value="name"
                                        :return-object="false"
                                        allow-overflow
                                    />
                            </div>
                            <div class="col-md-6">
                                <v-text-field label="Modelo" v-model="product.model"/>
                            </div>
                            <div class="col-md-6" v-if="product.price">
                                <v-text-field label="Preço" v-model="product.price" v-money="{}"/>
                            </div>
                            <div class="col-md-12">
                                <v-card outlined>
                                    <v-card-text>
                                        <div v-if="!stockEntry && !stockOut">
                                            <span>{{ product.amount }} unidades disponíveis</span><br>
                                            <v-btn text color="primary" outlined @click="stockEntry=true">Dar entrada em mais unidades</v-btn>
                                            <v-btn text color="error" outlined @click="stockOut=true">Dar saída</v-btn>
                                        </div>
                                        <div class="row" v-if="stockEntry">
                                            <div class="col-md-6">
                                                <v-text-field 
                                                    label="Em quantos itens quer dar entrada?" 
                                                    type="number" min="1" v-model="stockEntryAmuont"
                                                    hint="A quantidade informada será acrescentada à quantidade disponível atual"    
                                                    persistent-hint
                                                />
                                            </div>
                                            <div class="col-md-6">
                                                <v-btn text @click="stockEntry=false">Cancelar</v-btn>
                                                <v-btn @click="entryStock" color="primary">Entrada</v-btn>
                                            </div>
                                        </div>
                                        
                                        <div class="row" v-if="stockOut">
                                            <div class="col-md-6">
                                                <v-text-field 
                                                    label="Em quantos itens quer dar saída?" 
                                                    type="number" min="1" :max="product.amount" v-model="stockOutAmuont"
                                                    hint="A quantidade informada será decrementada à quantidade disponível atual"    
                                                    persistent-hint
                                                />
                                            </div>
                                            <div class="col-md-6">
                                                <v-btn text @click="stockOut=false">Cancelar</v-btn>
                                                <v-btn @click="outStock" color="error">Dar saída</v-btn>
                                            </div>
                                        </div>
                                    </v-card-text>
                                </v-card>
                            </div>
                            
                        </div>
                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-btn @click="generalUpdate" color="primary" :loading="generalLoading">
                            <v-icon small class="mr-2">fa fa-check</v-icon>
                            Salvar
                        </v-btn>
                    </v-card-actions>
                </v-card>

                <v-card class="mt-4">
                    <v-card-title>Imagens</v-card-title>
                    <v-card-text>

                        <div class="row">
                            <div class="col-md-2" v-for="(img, i) in product.images" :key="i">
                                <v-card elevation="2" rounded>
                                    <v-img :src="img"/>
                                </v-card>
                            </div>
                        </div>
                    </v-card-text>
                </v-card>

                <v-card class="mt-4" :disabled="otherDataLoading">
                    <v-card-title>Outros dados</v-card-title>
                    <v-card-text>
                        <div class="row">
                            <div class="col-12 text-center">
                                <v-menu 
                                    v-model="colorPicker"
                                    :close-on-content-click="false"
                                    max-width="300"
                                    offset-x
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn
                                            color="primary"
                                            dark
                                            v-bind="attrs"
                                            v-on="on"
                                            block
                                            text
                                        >
                                            Selecione a cor do produto
                                        </v-btn>
                                    </template>
                                    <v-card>
                                        <v-color-picker
                                            show-swatches
                                            mode="hexa"
                                            @input="setColor"
                                            hide-inputs
                                        ></v-color-picker>
                                    </v-card>
                                </v-menu>

                                <div v-if="!product.color">Nenhuma cor selecionada</div>
                                <div v-else>
                                    <div class="row">
                                        <div class="col-10">
                                            <div class="mt-3" :style="`width: 100%; border-radius: 5px; height: 10px; background-color: ${product.color}`"></div>
                                        </div>
                                        <div class="col-2">
                                            <v-btn text color="error" @click="removeColor">Limpar</v-btn>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <v-divider></v-divider>
                            <div class="col-12">
                                <p>Garantia</p>
                                <v-radio-group v-model="product.guarantee">
                                    <v-radio label="Garantia do vendedor" :value="2"/>
                                    <v-radio label="Garantia de fábrica" :value="1"/>
                                    <v-radio label="Sem garantia" :value="0"/>
                                </v-radio-group>
                            </div>
                            <v-divider></v-divider>
                            <div class="col-12">
                                <v-textarea v-model="product.description" outlined label="Descrição"/>
                            </div>
                        </div>
                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-btn @click="otherDataUpdate" color="primary" :loading="generalLoading">
                            <v-icon small class="mr-2">fa fa-check</v-icon>
                            Salvar
                        </v-btn>
                    </v-card-actions>
                </v-card>

                 <v-card class="mt-4">
                    <v-card-title>Categoria</v-card-title>
                    <v-card-text>
                        <div class="row">
                            <div class="col-md-12">
                                <v-breadcrumbs :items="product.category_flow" divider=">" class="p-0">
                                    <template v-slot:item="{ item }">
                                        <v-breadcrumbs-item
                                            :href="item.href"
                                            :disabled="item.disabled"
                                        >
                                            {{ item }}
                                        </v-breadcrumbs-item>
                                    </template>
                                </v-breadcrumbs>
                            </div>
                            <div class="col-md-12">
                                <v-btn color="error" block text outlined>Alterar Categoria</v-btn>
                                <v-alert 
                                    border="left"
                                    outlined type="info" dense
                                    color="error accent-4" 
                                    class="mt-2" elevation="2"
                                >
                                    A ficha técnica varia de acordo com a categoria selecionada. <br>
                                    Ao alterar a categoria será neccessário preencher os novos campos.
                                </v-alert>
                            </div>
                            <v-divider></v-divider>
                            <div class="col-md-12" >
                                <p class="h5" light>Ficha Técnica</p>
                                <div v-if="selectedCategory && selectedCategory.specs && selectedCategory.specs.length">
                                    <div v-for="(spec, i) in selectedCategory.specs" :key="i" class="mb-4">
                                        <v-card outlined>
                                            <v-card-text>
                                                <v-combobox
                                                    :label="`${spec.name} ${spec.is_required?'(obrigatório)':''}`"
                                                    :items="spec.items"
                                                    item-text="name"
                                                    item-value="name"
                                                    :return-object="false"
                                                    chips
                                                    v-model="specs[spec.id]"
                                                    :multiple="!!spec.is_multiple"
                                                    persistent-hint
                                                    :hint="!!spec.is_multiple ? 'Informe um ou mais' : ''"
                                                    clearable
                                                />
                                                <v-alert 
                                                    v-if="spec.is_multiple==2"
                                                    border="left"
                                                    outlined type="info" dense
                                                    color="primary accent-4" 
                                                    class="mt-2" elevation="2"
                                                >
                                                    <small>Os itens selecionados servirão de opções na compra se informado mais de um.</small>
                                                </v-alert>
                                            </v-card-text>
                                        </v-card>
                                    </div>
                                </div>
                                <div v-else>
                                    <p v-if="product.category" class="h5 text-center">
                                        <v-alert 
                                            dense color="success" border="left" elevation="2"
                                            type="success" outlined
                                        >Nada a ser preencido</v-alert>
                                    </p>
                                    <p v-else class="h5 text-center">
                                        <v-alert 
                                            dense color="error" border="left" elevation="2"
                                            type="error" outlined
                                        >Selecione a categoria</v-alert>
                                    </p>
                                </div>
                            </div> 

                        </div>
                    </v-card-text>
                </v-card>

            </div>
        </div>
    </div>
</template>
<script>
export default {
    data: () => ({
        product: {},
        brands: [],
        loading: false,
        colorPicker: false,
        specs: {},
        selectedCategory: {},

        generalLoading: false,
        otherDataLoading: false,
        stockEntry: false,
        stockOut: false,
        stockEntryAmuont: 1,
        stockOutAmuont: 1,
    }),
    mounted(){
        this.getProduct()
        this.getBrands()
    },
    watch: {
        'product.category': function(v){
            this.selectedCategory = {...v}
        },
        selectedCategory(){
            this.formatSpecHandle()
        }
    },
    methods: {
        getProduct(){
            this.loading = true
            this.$commom.request({
                url: '/product/me/'+this.$route.params.id,
                auth: true,
                success: resp => {
                    this.loading = false
                    this.product = {...resp}
                }
            })
        },

        getBrands() {
            this.$commom.request({
                url: '/brand',
                auth: true,
                success: resp => {
                    this.brands = [...resp]
                }
            })
        },

        removeColor(){
            const prod = this.product
            prod.color = null
            this.product = {...prod}
        },
        setColor(data){
            const prod = this.product
            prod.color = data.hexa
            this.product = {...prod}
        },
        formatSpecHandle(){
            const specResult = {}
            for(const spec of this.product.specs ){
                if( !!spec.is_multiple ){
                    specResult[spec.id] = spec.items
                } else {
                    specResult[spec.id] = spec.items[0]
                }
            }

            this.specs = {...specResult}
        },

        generalUpdate(){
            this.generalLoading = true
            this.$commom.request({
                url: '/product/'+this.product.id+'/general',
                type: 'put',
                auth: true,
                setError: true,
                data: this.product,
                successAlert: true,
                success: resp => {
                    this.generalLoading = false
                    this.getProduct()
                },
                error: () => this.generalLoading=false
            })
        },

        otherDataUpdate(){
            this.otherDataLoading = true
            this.$commom.request({
                url: '/product/'+this.product.id+'/other-data',
                type: 'put',
                auth: true,
                setError: true,
                data: this.product,
                successAlert: true,
                success: resp => {
                    this.otherDataLoading = false
                    this.getProduct()
                },
                error: () => this.otherDataLoading=false
            })
        },
        entryStock(){
            this.generalLoading = true
            this.$commom.request({
                url: '/stock/entry',
                type: 'post',
                auth: true,
                setError: true,
                data: {amount: this.stockEntryAmuont, id_product: this.product.id},
                successAlert: true,
                success: resp => {
                    this.generalLoading = false
                    this.stockEntry = false
                    this.stockEntryAmuont = 1
                    this.getProduct()
                },
                error: () => this.generalLoading=false
            })
        },
        outStock(){
            this.generalLoading = true
            this.$commom.request({
                url: '/stock/out',
                type: 'post',
                auth: true,
                setError: true,
                data: {amount: this.stockOutAmuont, id_product: this.product.id},
                successAlert: true,
                success: resp => {
                    this.generalLoading = false
                    this.stockOut = false
                    this.stockOutAmuont = 1

                    this.getProduct()
                },
                error: () => this.generalLoading=false
            })
        }
    }
}
</script>