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
                                <p class="h3 m-0">{{ product.name }}</p>
                                <v-chip x-small :color="product.status == 'paused'?'warning':'success'">
                                    {{product.status_text}}
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
                            <router-link is="v-btn" :to="`/dashboard/produtos/${product.id}/editar`" text class="float-right" >
                                <v-icon small>fa fa-chevron-left</v-icon>
                                Voltar
                            </router-link>
                        </div>
                    </div>

                    <v-card class="mt-4" :loading="loading" :disabled="loading">
                        <v-card-title>Alterar categoria</v-card-title>
                        <v-card-text>
                            <div class="row">
                                <div class="col-md-12">
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

                                <div class="col-md-12">

                                    <p class="h5" light>Selecione a nova categoria</p>
                                    <div class="row">
                                        <div class="col-12 align-items-center" v-if="categoryFlowItems && categoryFlowItems.length">
                                            <v-btn class="float-left" icon color="primary" @click="backCategoryHandle">
                                                <v-icon small>fa fa-chevron-left</v-icon>
                                            </v-btn>
                                            <v-breadcrumbs class="p-0 h-100" divider=">" :items="categoryFlowItems.map(i => ({text: i}))"></v-breadcrumbs>
                                        </div>
                                    </div>
                                    <div class="col-12">
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
                                <v-divider></v-divider>
                                <div class="col-md-12" v-if="!!selectedCategory">
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
                        <v-card-actions class="justify-end">
                            <router-link
                                is="v-btn"
                                text
                                :to="`/dashboard/produtos/${product.id}/editar`"
                            >
                                Voltar
                            </router-link>
                            <v-btn v-if="!!selectedCategory" @click="save" color="primary"> 
                                Salvar
                            </v-btn>
                        </v-card-actions>
                    </v-card>

                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data: () => ({
        product: {},
        categoriesTree: [],
        loading: false,
        specs: {},
        selectedCategory: null,
        selectedCategoryParent: null,
        categoryFlow: [],
    }),
    mounted(){
        this.getProduct()
        this.getCategoriesTree()
    },
    watch: {
        selectedCategory(v){
            this.specs = {}
        }
    },
    computed: {
        selectedCategoryParentItems(){
            if( !this.selectedCategoryParent ){
                return this.categoriesTree
            } else {
                return !!this.selectedCategoryParent.linkable ? this.selectedCategoryParent.children : null
            }
        },
        categoryFlowItems(){
            if( !this.selectedCategory ){
                return this.categoryFlow
            } else {
                return [...this.categoryFlow, this.selectedCategory.name]
            }
        },
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

        getCategoriesTree() {
            this.$commom.request({
                url: '/category/tree',
                auth: true,
                success: resp => {
                    this.categoriesTree = [...resp]
                }
            })
        },
        onCategorySelectHandle( category ) {

            if( !category.linkable ){
                this.selectedCategory = {...category}
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
            } else {
                for(const cat of this.categoriesTree){
                    if(cat.id == id){
                        return  cat
                    }
                }
            }
            return null;
        },

        save(){
            const errors = this.validateData()
            if( !!errors.length ){
                this.$commom.setError({
                    title: 'Atenção!',
                    message: this.$commom.errorMessages(errors)
                })
                return
            }

            const data = {
                specs: this.specs,
                id_category: this.selectedCategory.id,
            }

            this.loading = true
            this.$commom.request({
                url: `/product/${this.product.id}/update-category`,
                type: 'put',
                auth: true,
                setError: true,
                data: data,
                success: resp => {
                    this.loading = false
                    this.$commom.success({title: 'Categoria alterada com sucesso!'})
                    this.$router.push(`/dashboard/produtos/${this.product.id}/editar`)
                    
                },
                error: () => this.loading = false
            })
        },

        validateData() {
            const errors = []
            if( !this.selectedCategory )
                errors.push("Selecione uma categoria")

            // validate required specs
            if( this.selectedCategory ){
                for( const spec of this.selectedCategory.specs ){
                    if(spec.is_required){

                        if( !this.specs[spec.id] || !this.specs[spec.id].length )
                            errors.push(`Informe a o campo <b>${spec.name}</b>`)

                    }
                }
            }


            return errors
        },
    }
}
</script>