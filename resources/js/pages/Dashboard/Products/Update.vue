<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-2 col-lg-2 col-xl-2 col-3">
                        <v-card elevation="2">
                            <v-img :src="product.principal_image" class="rounded img-fluid"/>
                        </v-card>
                    </div>
                    <div class="col-md-10 col-lg-10 col-9 w-100">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="h3 m-0">{{ staticProduct.name }}</p>
                                <v-chip x-small :color="staticProduct.status == 'paused'?'warning':'success'">
                                    {{staticProduct.status_text}}
                                </v-chip>
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
                            <router-link is="v-btn" to="/dashboard/produtos" text class="float-right" >
                                <v-icon small>fa fa-chevron-left</v-icon>
                                Voltar
                            </router-link>
                        </div>
                    </div>
                    <v-expansion-panels multiple >

                        <!-- general -->
                        <v-expansion-panel >
                            <v-expansion-panel-header>
                                <div class="row">
                                    <div class="col-md-4">
                                        <v-card-title>Geral</v-card-title>
                                    </div>
                                    <div class="col-md-8 d-flex align-items-center">
                                        <div>
                                            <span>{{ staticProduct.name }}</span> <br>
                                            <span>{{ staticProduct.brand }} - {{ staticProduct.model }}</span> <br>
                                            R$ {{ staticProduct.price_currency }}
                                        </div>
                                    </div>
                                </div>
                            </v-expansion-panel-header>
                            <v-expansion-panel-content>
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
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <v-btn @click="generalUpdate" color="primary" :loading="generalLoading">
                                            <v-icon small class="mr-2">fa fa-check</v-icon>
                                            Salvar
                                        </v-btn>
                                    </div>
                                </div>
                            </v-expansion-panel-content>
                        </v-expansion-panel>
                        
                        <!-- images -->
                        <v-expansion-panel>
                            <v-expansion-panel-header>
                                <v-card-title>
                                    Imagens 
                                    
                                    <small class="ml-3" v-if="staticProduct.images && staticProduct.images.length">
                                        ({{ staticProduct.images.length }} imagens)
                                    </small>
                                </v-card-title>
                            </v-expansion-panel-header>
                            <v-expansion-panel-content>
                                <div class="row">
                                    <div class="col-md-2 col-sm-4 col-4" v-for="(img, i) in product.images" :key="i">
                                        <v-menu offset-y absolute>
                                            <template v-slot:activator="{ on }">
                                                <v-card>
                                                    <v-img 
                                                        v-on="on" 
                                                        class="elevation-2 rounded-lg cursor-pointer"  
                                                        contain
                                                        :src="img.src"
                                                    />
                                                    <span v-if="!!img.is_principal" class="badge bg-success w-100 opacity-50" style="z-index: 100">Principal</span>
                                                </v-card>
                                            </template>
                                            <v-card flat>
                                                <v-list-item-content class="justify-center">
                                                    <div class="mx-auto text-center">
                                                        <v-btn small depressed text color="error" @click="() => removeImage(img.id)">Remover</v-btn>
                                                        <v-btn small depressed text color="success" v-if="!img.is_principal" @click="() => setPrincipalImage(img.id)">Imagem Principal</v-btn>
                                                    </div>
                                                </v-list-item-content>
                                            </v-card>
                                        </v-menu>
    
                                    </div>
                                    <div class="col-md-4 d-flex align-items-center">
                                        <v-btn block outlined color="primary" @click="imageModal=true">
                                            Adicionar Foto
                                        </v-btn>
                                    </div>
                                </div>
                            </v-expansion-panel-content>
                        </v-expansion-panel>

                        <!-- other data -->
                        <v-expansion-panel>
                            <v-expansion-panel-header>
                                <v-card-title>Outros Dados</v-card-title>
                            </v-expansion-panel-header>
                            <v-expansion-panel-content>
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
                                <v-card-actions class="justify-end">
                                    <v-btn @click="otherDataUpdate" color="primary" :loading="generalLoading">
                                        <v-icon small class="mr-2">fa fa-check</v-icon>
                                        Salvar
                                    </v-btn>
                                </v-card-actions>
                            </v-expansion-panel-content>
                        </v-expansion-panel>

                        <!-- specs -->
                        <v-expansion-panel>
                            <v-expansion-panel-header>
                                <v-card-title>Ficha Técnica</v-card-title>
                            </v-expansion-panel-header>
                            <v-expansion-panel-content>
                                <div class="row">
                                    <div class="col-md-12" >
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
                                            <p class="h5 text-center">
                                                <v-alert 
                                                    dense color="success" border="left" elevation="2"
                                                    type="success" outlined
                                                >Nada a ser preencido</v-alert>
                                            </p>
                                        </div>
                                    </div> 
    
                                </div>
                                <v-card-actions class="justify-end" v-if="selectedCategory && selectedCategory.specs && selectedCategory.specs.length">
                                    <v-btn @click="updateSpecs" color="primary" :loading="generalLoading">
                                        <v-icon small class="mr-2">fa fa-check</v-icon>
                                        Salvar
                                    </v-btn>
                                </v-card-actions>
                            </v-expansion-panel-content>
                        </v-expansion-panel>

                        <!-- category -->
                        <v-expansion-panel>
                            <v-expansion-panel-header>
                                <div class="row">
                                    <div class="col-md-4">
                                        <v-card-title>Categoria</v-card-title>
                                    </div>
                                    <div class="col-md-8 d-flex align-items-center">
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
                                </div>
                            </v-expansion-panel-header>
                            <v-expansion-panel-content>
                                <v-card flat>
                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                        </div>
                                        <div class="col-md-12">
                                            <v-alert 
                                                border="left"
                                                outlined type="info" dense
                                                color="error accent-4" 
                                                class="mt-2" elevation="2"
                                            >
                                                A ficha técnica varia de acordo com a categoria do produto. <br>
                                                Ao alterar a categoria será neccessário preencher os novos campos.
                                            </v-alert>
                                            <router-link
                                                is='v-btn'
                                                :to="`/dashboard/produtos/${product.id}/editar/categoria`"
                                                color="error" block text outlined
                                            >
                                                Alterar Categoria
                                            </router-link>
                                        </div>
                                    </div>
                                </v-card>
                            </v-expansion-panel-content>
                        </v-expansion-panel>

                    </v-expansion-panels>
                </div>
            </div>
        </div>

        <!-- uppload image -->
        <v-dialog max-width="600" v-model="imageModal">
            <template v-slot:default="dialog">
                <v-card :loading="newImageLoading" :disabled="newImageLoading">
                    <v-card-title>Adicionar Imagem</v-card-title>
                    <v-card-text>
                        <v-form id="upload-image" @submit.prevent="uploadImage">
                            <div class="row">
                                <div class="col-md-12">
                                    <v-file-input 
                                        v-model="newImages" 
                                        label="Arquivo"
                                        counter show-size
                                        accept="image/*"
                                        multiple
                                    />
                                </div>
                            </div>
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-btn text @click="dialog.value = false">Fechar</v-btn>
                        <v-btn form="upload-image" type="submit" color="primary">Salvar</v-btn>
                    </v-card-actions>
                </v-card>
            </template>
        </v-dialog>

    </div>
</template>
<script>
export default {
    data: () => ({
        product: {},
        staticProduct: {},
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
        imageModal: false,
        newImages: [],
        newImageLoading: false,

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
        },
        imageModal(){
            this.newImages = []
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
                    this.staticProduct = {...resp}
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
        },

        uploadImage(){
            if( this.newImages ){

                this.newImageLoading = true
                
                const formData = new FormData()
                for(const file of this.newImages)
                    formData.append('images[]', file)

                this.$commom.request({
                    url: `/product/${this.product.id}/upload-image`,
                    type: 'post',
                    auth: true,
                    data: formData,
                    file: true,
                    setError: true,
                    success: resp => {
                        this.getProduct()
                        this.imageModal = false
                        this.newImageLoading = false
                        this.newImages = []
                    },
                    error: () => {this.newImageLoading = false}
                })
            }
        },
        removeImage(id){
            this.$commom.confirm({
                title: 'Deseja remover esta imagem?',
                onConfirm: () => {
                    this.$commom.request({
                        url: `/product/${this.product.id}/remove-image`,
                        type: 'post',
                        auth: true,
                        data: {id},
                        setError: true,
                        success: resp => {
                            this.getProduct()
                        }
                    })
                }
            })
        },
        setPrincipalImage(id){

            this.$commom.request({
                url: `/product/${this.product.id}/set-principal-image`,
                type: 'post',
                auth: true,
                data: {id},
                setError: true,
                success: resp => {
                    this.getProduct()
                }
            })
        },

        updateSpecs(){
            this.$commom.request({
                url: `/product/${this.product.id}/update-specs`,
                type: 'put',
                auth: true,
                setError: true,
                data: {specs: this.specs},
                successAlert: true,
                success: resp => {
                    this.getProduct()
                },
                error: () => this.generalLoading=false
            })
        }
    }
}
</script>