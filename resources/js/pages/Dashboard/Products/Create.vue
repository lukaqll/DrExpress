<template>
    <div class="row">
        <div class="col-lg-9 col-md-8 col-sm-8">
            <v-card flat :loading="loading" :disabled="loading">
                <v-stepper class="bg-none" vertical v-model="step" flat >
                    <v-stepper-step :complete="step>1" step="1" @click="step=1">
                        Categoria
                        <small>Categoria do seu produto</small>
                    </v-stepper-step>
                    <v-stepper-content step="1">
        
                        <div class="row justify-content-center m-2">
                            <div class="col-lg-8 col-md-10 col-sm-10 col-xs-12 text-center">
                                <div class="row">
                                    <div class="col-12">
                                        <v-alert 
                                            dense color="primary" border="left" elevation="2"
                                            type="info" outlined
                                        >
                                            Categoria do produto <br>
                                            <small>Selecione a categoria que mais se enquadra o produto.</small>
                                        </v-alert>
                                    </div>
                                    <div class="col-12 align-items-center" v-if="categoryFlowItems && categoryFlowItems.length">
                                        <v-btn class="float-left" icon color="primary" @click="backCategoryHandle">
                                            <v-icon small>fa fa-chevron-left</v-icon>
                                        </v-btn>
                                        <v-breadcrumbs class="p-0 h-100" divider=">" :items="categoryFlowItems.map(i => ({text: i}))"></v-breadcrumbs>
                                    </div>
                                    <div class="col-12 mh-50">
                                        <v-card max-height="300" class="overflow-auto">
                                            <v-list 
                                                dense 
                                                elevation="1" 
                                                v-if="selectedCategoryParentItems"
                                            >
                                                <v-list-item 
                                                    v-for="(cat, i) in selectedCategoryParentItems" :key="i"
                                                    :class="`${i<(selectedCategoryParentItems.length-1)&&'border-bottom'} text-left`"
                                                    @click="() => onCategorySelectHandle(cat)"
                                                >
                                                    <v-list-item-content >
                                                        <v-list-item-title v-text="cat.name"></v-list-item-title>
                                                    </v-list-item-content>
                                                    <v-list-item-action>
                                                        <v-icon small>fa fa-chevron-right</v-icon>
                                                    </v-list-item-action>
                                                </v-list-item>
                                            </v-list>
                                        </v-card>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-12 text-right" v-if="selectedCategory">
                                <v-btn @click="step=step+1" color="primary">
                                    Pŕoximo
                                    <v-icon small>fa fa-chevron-right</v-icon>
                                </v-btn>
                            </div>
                        </div>
                        <v-divider></v-divider>
                    </v-stepper-content>
        
                    <v-stepper-step :complete="step>2" step="2" @click="step=2">
                        Dados
                        <small>Informações do produto</small>
                    </v-stepper-step>
                    <v-stepper-content step="2">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 col-md-10 col-sm-10 col-xs-12 text-center">
                                <div class="row">
                                    <div class="col-12">
                                        <v-alert 
                                            dense color="primary" border="left" elevation="2"
                                            type="info" outlined
                                        >
                                            Informe alguns dados do produto <br>
                                            <small>Estes dados serão exibidos no anúncio</small>
                                        </v-alert>
                                    </div>
                                    <div class="col-md-6">
                                        <v-combobox
                                            :items="brands"
                                            item-text="name"
                                            label="Marca"
                                            hint='Informe a marca do produto ou "Genérica" se não houver'
                                            persistent-hint
                                            hide-no-data
                                            v-model="product.brand"
                                            item-value="name"
                                            :return-object="false"
                                            allow-overflow
                                        />
                                    </div>
                                    <div class="col-md-6">
                                        <v-text-field 
                                            label="Modelo"
                                            hint='Informe o modelo do produto'
                                            persistent-hint
                                            v-model="product.model"
                                        />
                                    </div>
                                    <div class="col-md-6">
                                        <v-text-field 
                                            label="Título do Anúncio"
                                            hint='Nome que aparecerá no anúncio'
                                            persistent-hint
                                            v-model="product.name"
                                        />
                                    </div>
                                    <div class="col-md-6">
                                        <v-text-field 
                                            label="Preço R$"
                                            hint='Preço em Real do produto'
                                            persistent-hint
                                            v-model.lazy="product.price"
                                            v-money="{}"
                                        />
                                    </div>
                                    <div class="col-md-6">
                                        <v-text-field 
                                            type="number" min="1"
                                            label="Quantidade"
                                            hint='Quantidade disponível do produto'
                                            persistent-hint
                                            v-model="product.qtd"
                                        />
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-12 text-right">
                                <v-btn @click="step=step-1" text>Voltar</v-btn>
                                <v-btn @click="step=step+1" color="primary">
                                    Pŕoximo
                                    <v-icon small>fa fa-chevron-right</v-icon>
                                </v-btn>
                            </div>
                        </div>
                        <v-divider></v-divider>
                    </v-stepper-content>
    
                    <v-stepper-step :complete="step>3" step="3" @click="step=3">
                        Ficha Técnica
                        <small>Dados técnicos do produto</small>    
                    </v-stepper-step>
                    <v-stepper-content step="3">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 col-md-10 col-sm-10 col-xs-12 text-center">
                                <div class="row">
                                    <div class="col-12">
                                        <v-alert 
                                            dense color="primary" border="left" elevation="2"
                                            type="info" outlined
                                        >
                                            Informe os dados técnicos do produto<br>
                                            <small>Algumas Especificações variam de acordo com a categoria selecionada.</small>
                                        </v-alert>
                                    </div>
                                    <div class="col-md-12" >
                                        <div v-if="selectedCategory && selectedCategory.specs && selectedCategory.specs.length">
                                            <div v-for="(spec, i) in selectedCategory.specs" :key="i" class="mb-4">
                                                <v-card>
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
                                            <p v-if="selectedCategory" class="h5 text-center">
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
                            </div>
                            <div class="col-12 text-right">
                                <v-btn @click="step=step-1" text>Voltar</v-btn>
                                <v-btn @click="step=step+1" color="primary">
                                    Pŕoximo
                                    <v-icon small>fa fa-chevron-right</v-icon>
                                </v-btn>
                            </div>
                            
                        </div>
                        <v-divider></v-divider>
                    </v-stepper-content>
    
                    <v-stepper-step :complete="step>4" step="4" @click="step=4">
                        Especificações
                        <small>Especificações do produto</small>    
                    </v-stepper-step>
                    <v-stepper-content step="4">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 col-md-10 col-sm-10 col-xs-12 text-center">
                                <div class="row">
                                    <div class="col-12">
                                        <v-alert 
                                            dense color="primary" border="left" elevation="2"
                                            type="info" outlined
                                        >
                                            Especificações do produto
                                        </v-alert>
                                    </div>
                                    <div class="col-md-12" >                                    
                                        <!-- color picker -->
                                        <div class="mb-4">
                                            <v-card>
                                                <v-card-text>
                                                    <div class="row">
                                                        <div class="col-12">
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
    
                                                    </div>
                                                </v-card-text>
                                            </v-card>
                                        </div>
    
                                        <div class="mb-4">
                                            <v-card>
                                                <v-card-text>
                                                    <p class="h5 text-center" color="primary">Garantia</p>
                                                    <p>Seleciona a garantia oferecida no poduto</p>
                                                    <v-radio-group v-model="product.guarantee">
                                                        <v-radio label="Garantia do vendedor" value="2"/>
                                                        <v-radio label="Garantia de fábrica" value="1"/>
                                                        <v-radio label="Sem garantia" value="0"/>
                                                    </v-radio-group>
                                                </v-card-text>
                                            </v-card>
                                        </div>
    
                                        <div class="mb-4">
                                            <v-card>
                                                <v-card-text>
                                                    <p class="h5 text-center" color="primary">Descrição</p>
                                                    <p>Insira uma descrição detalhada do produto</p>
                                                    <v-textarea outlined v-model="product.description" placeholder=""/>
                                                </v-card-text>
                                            </v-card>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="col-12 text-right">
                                <v-btn @click="step=step-1" text>Voltar</v-btn>
                                <v-btn @click="step=step+1" color="primary">
                                    Pŕoximo
                                    <v-icon small>fa fa-chevron-right</v-icon>
                                </v-btn>
                            </div>
                            
                        </div>
                        <v-divider></v-divider>
                    </v-stepper-content>
    
                    <v-stepper-step :complete="step>5" step="5" @click="step=5">
                        Imagens
                        <small>Fotos do produto</small>        
                    </v-stepper-step>
                    <v-stepper-content step="5">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 col-md-10 col-sm-10 col-xs-12 text-center">
                                <div class="row">
                                    <div class="col-12">
                                        <v-alert 
                                            dense color="primary" border="left" elevation="2"
                                            type="info" outlined
                                        >
                                            Adicione algumas imagens do produto <br>
                                            <small>As imagens serão exibidas no anúncio</small>
                                        </v-alert>
                                    </div>
                                    <div class="col-12">
                                        <v-file-input 
                                            hint="Insira as imagens do produto" 
                                            persistent-hint
                                            label="Imagens"
                                            counter show-size
                                            accept="image/*"
                                            multiple
                                            v-model="images"
                                        />
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-3" v-for="(file, i) in imagesPreview" :key="i">
                                                <v-menu offset-y absolute>
                                                    <template v-slot:activator="{ on }">
                                                        <v-card>
                                                            <v-img 
                                                                v-on="on" 
                                                                class="elevation-2 rounded-lg cursor-pointer"  
                                                                contain
                                                                :src="file"
                                                            />
                                                            <span v-if="principalImage == i" class="badge bg-success w-100 opacity-50" style="z-index: 100">Principal</span>
                                                        </v-card>
                                                    </template>
                                                    <v-card>
                                                        <v-list-item-content class="justify-center">
                                                            <div class="mx-auto text-center">
                                                                <v-btn small depressed text color="error" @click="() => removeImage(i)">Remover</v-btn>
                                                                <v-btn small depressed text color="success" v-if="principalImage!=i" @click="() => principalImage=i">Imagem Principal</v-btn>
                                                            </div>
                                                        </v-list-item-content>
                                                    </v-card>
                                                </v-menu>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-right">
                                <v-btn @click="step=step-1" text>Voltar</v-btn>
                                <v-btn @click="createProduct" color="primary" :loading="loading">
                                    <v-icon small class="mr-2">fa fa-check</v-icon>
                                    Salvar
                                </v-btn>
                            </div>
                        </div>
                    </v-stepper-content>
    
                </v-stepper>
            </v-card>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-4">
            <v-card color="h-100">
                <v-card-title>Seu Produto</v-card-title>
                <v-card-text>
                    <div class="row">
                        <div class="col-12">
                            <v-breadcrumbs divider=">" :items="categoryFlowItems.map(i => ({text: i}))"></v-breadcrumbs>
                        </div>
                        <div class="col-12">
                            Dados <v-divider/>
                            <div class="d-flex w-100 mt-1 justify-content-between" v-if="product.name && product.name.length">
                                <b>Nome:</b>
                                <span>{{ product.name }}</span>
                            </div>
                            <div class="d-flex w-100 mt-1 justify-content-between" v-if="product.brand && product.brand.length">
                                <b>Marca:</b>
                                <span>{{ product.brand }}</span>
                            </div>
                            <div class="d-flex w-100 mt-1 justify-content-between" v-if="product.model && product.model.length">
                                <b>Modelo:</b>
                                <span>{{ product.model }}</span>
                            </div>
                            <div class="d-flex w-100 mt-1 justify-content-between" v-if="product.price && product.price.length">
                                <b>Preço:</b>
                                <span>R$ {{ product.price }}</span>
                            </div>
                        </div>

                        <div class="col-12 mt-3" v-if="selectedCategory && specs">
                            Especificações 
                            <v-divider/>
                            <div  v-for="(spec, i) in specsPresentation" :key="i" >
                                <div
                                   v-if="spec.itemsNames && spec.itemsNames.length"
                                    class="d-flex w-100 mt-1 justify-content-between"
                                >
                                    <b>{{ spec.name }}:</b>
                                    <span>{{ spec.itemsNames }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex w-100 mt-1 justify-content-between" v-if="product.color">
                            <b>Cor:</b>
                            <div :style="`width: 20px; height: 20px; border-radius: 5px; background-color: ${product.color}`"></div>
                        </div>
                        <div class="d-flex w-100 mt-1 justify-content-between" v-if="product.guarantee">
                            <b>Garantia:</b>
                            <span v-if="product.guarantee==0">Sem garantia</span>
                            <span v-if="product.guarantee==1">Garantia de fábrica</span>
                            <span v-if="product.guarantee==2">Garantia do vendedor</span>
                        </div>
                        <div class="d-flex w-100 mt-1 justify-content-between" v-if="images && images.length">
                            <b>Imagens:</b>
                            <span>{{images.length}} imagens</span>
                        </div>

                    </div>
                </v-card-text>
            </v-card>
        </div>
    </div>
</template>

<script>
export default {
    data: () => ({
        product: {},
        step: 5,
        categoriesTree: [],
        loading: false,
        selectedCategoryParent: null,
        selectedCategory: null,
        categoryFlow: [],
        colorPicker: false,
        specs: {},
        images: [],
        principalImage: 0,
        brands: []
    }),

    computed: {
        selectedCategoryParentItems(){
            if( !this.selectedCategoryParent ){
                return this.categoriesTree
            } else {
                return this.selectedCategoryParent.linkable ? this.selectedCategoryParent.children : null
            }
        },
        categoryFlowItems(){
            if( !this.selectedCategory ){
                return this.categoryFlow
            } else {
                return [...this.categoryFlow, this.selectedCategory.name]
            }
        },

        specsPresentation(){
            let result = []
            const cat = this.selectedCategory
            for(const idSpec in this.specs){
                const spec = cat.specs.find(s => s.id == idSpec)

                let itemsNames = []

                if(spec.is_multiple){
                    itemsNames = this.specs[idSpec].join(', ')
                } else {
                    itemsNames = this.specs[idSpec]
                }
                
                result.push({
                    name: spec.name,
                    is_multiple: spec.is_multiple,
                    itemsNames: itemsNames
                })
            }
            return result
        },

        imagesPreview(){
            return this.images.map(img => URL.createObjectURL(img))
        }
    },

    watch: {

        images(v){

            if(v.length){
                if(this.principalImage > (v.length-1))
                    this.principalImage = (v.length-1)
            } else {
                this.principalImage = 0
            }
        },

        selectedCategory(v){
            this.specs = {}
        }
    },

    mounted(){
        this.getCategoriesTree()
        this.getBrands()
    }, 
    methods: {

        createProduct() {

            const errors = this.validateData()
            if( !!errors.length ){
                this.$commom.setError({
                    title: 'Atenção!',
                    message: this.$commom.errorMessages(errors)
                })
                return
            }

            const data = {
                ...this.product,
                specs: this.specs,
                id_category: this.selectedCategory.id,
                principal_image: this.principalImage
            }
            const formData = new FormData()
            formData.append('data', JSON.stringify(data))
            for(const i in this.images)
                formData.append('images[]', this.images[i])

            this.loading = true
            this.$commom.request({
                url: '/product',
                type: 'post',
                auth: true,
                setError: true,
                data: formData,
                file: true,
                success: resp => {
                    console.log(resp)
                    this.loading = false
                    this.$commom.success({title: 'Produto cadastrado com sucesso!'})
                    this.$router.push('/dashboard/produtos')
                    
                },
                error: () => this.loading = false
            })
        },

        validateData() {
            const errors = []
            if( !this.selectedCategory )
                errors.push("Selecione uma categoria")

            if( this.selectedCategory && !!this.selectedCategory.linkable )
                errors.push("Categoria inválida")

            const requiredProductFields = {
                brand: 'Marca', 
                model: 'Modelo', 
                name: 'Título', 
                price: 'Preço', 
                qtd: 'Quantidade'
            }
            for(const field in requiredProductFields){
                if( !this.product[field] || !this.product[field].length )
                    errors.push(`Informe a o campo <b>${requiredProductFields[field]}</b>`)
            }

            // validate required specs
            if( this.selectedCategory ){
                for( const spec of this.selectedCategory.specs ){
                    if(spec.is_required){

                        if( !this.specs[spec.id] || !this.specs[spec.id].length )
                            errors.push(`Informe a o campo <b>${spec.name}</b>`)

                    }
                }
            }

            if( !this.images.length )
                errors.push("Insira ao menos uma imagem do produto")

            return errors
        },

        getCategoriesTree() {
            this.loading = true
            this.$commom.request({
                url: '/category/tree',
                auth: true,
                success: resp => {
                    this.loading = false
                    this.categoriesTree = [...resp]
                }
            })
        },

        onCategorySelectHandle( category ) {

            if( !category.linkable ){
                this.selectedCategory = {...category}
                this.step = 2
            } else {
                this.selectedCategoryParent = {...category}
                this.selectedCategory = null
                const categoryFlow = this.categoryFlow
                categoryFlow.push(category.name)
                this.categoryFlow = [...categoryFlow]
            }
            

        },

        backCategoryHandle(){
            if( this.selectedCategoryParent.id_parent ){
                const cat = this.findCategory(this.selectedCategoryParent.id_parent, this.categoriesTree[0])
                this.selectedCategoryParent = {...cat}
            } else {
                this.selectedCategoryParent = null
            }

            this.selectedCategory = null
            const categoryFlow = this.categoryFlow
            categoryFlow.pop()
            this.categoryFlow = [...categoryFlow]
        },

        findCategory(id, category){

            if(category.id == id){
                return category;
            }else if (category.children != null){
                var i;
                var result = null;
                for(i=0; result == null && i < category.children.length; i++){
                    result = this.findCategory(id, category.children[i]);
                }
                return result;
            }
            return null;
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
        removeImage(index){
            const images = this.images
            images.splice(index, 1)
            this.images = [...images]
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
    }
}
</script>