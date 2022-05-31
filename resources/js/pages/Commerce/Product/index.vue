<template>
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-9 col-sm-12">
            <div class="row">
                <div class="col-12">
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
                <div class="col-12">
                    <v-card flat>
                        <v-card-text>
    
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="row" v-if="product.images && product.images.length>1">
                                        <div class="col-2">
                                            <v-card 
                                                v-for="(img,i) in product.images" :key="i" 
                                                flat outlined
                                                class="mb-2 cursor-pointer"
                                                v-bind:class="carouselImage==i&&'selected-image'"
                                                @click="carouselImage=i"
                                            >
                                                <v-img :src="img.src" height="75"/>
                                            </v-card>
                                        </div>
                                        <div class="col-10">
                                            <v-card flat min-height="450">
                                                <v-carousel 
                                                    v-model="carouselImage"
                                                    show-arrows-on-hover
                                                    hide-delimiters
                                                    height="100%"
                                                >
                                                    <v-carousel-item 
                                                        v-for="(img,i) in product.images" :key="i"
                                                        :src="img.src"
                                                    >
                                                    </v-carousel-item>
                                                </v-carousel>
                                            </v-card>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <v-card flat min-height="450">
                                            <v-img :src="product.principal_image"/>
                                        </v-card>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <h3 class="mb-5">Dados Gerais</h3>
                                            <v-card flat>
                                                <table class="table table-bordered table-striped specs-table">
                                                    <tbody>
                                                        <tr>
                                                            <th>Marca</th>
                                                            <td>{{ product.brand }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Modelo</th>
                                                            <td>{{ product.model }}</td>
                                                        </tr>
                                                        <tr v-for="(spec,i) in product.specs" :key="i">
                                                            <th>{{spec.name}}</th>
                                                            <td>{{ spec.items.join(', ') }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </v-card>
                                            <div class="col-12">
                                                <v-divider></v-divider>
                                            </div>
                                            <div class="col-12">
                                                <h3 class="mb-5">Descrição</h3>
                                                <p class="description">{{product.description}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- right sidebar -->
                                <div class="col-md-5">
                                    <v-card flat outlined>
                                        <v-card-text>
                                            <div class="row">

                                                <!-- title -->
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <p class="h3">{{ product.name }}</p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <v-btn icon @click="toggleFavorite">
                                                                <v-icon color="error" v-if="product.is_favorite">fa fa-heart</v-icon>
                                                                <v-icon v-else>far fa-heart</v-icon>
                                                            </v-btn>
                                                        </div>
                                                    </div>
                                                    <v-rating
                                                        half-increments
                                                        readonly dense
                                                        length="5"
                                                        size="25"
                                                        :value="3.5"
                                                    />
                                                </div>

                                                <!-- price -->
                                                <div class="col-12">
                                                    <p class="price-text">R$ {{$commom.toMoney(product.price)}}</p>

                                                    <!-- freght -->
                                                    <div v-if="!!product.served">
                                                        <b class="text-success">
                                                            <v-icon x-small color="success">fa fa-truck</v-icon>
                                                            <span v-if="product.served.freight>0">Frete: R$ {{ $commom.toMoney(product.served.freight) }}</span>
                                                            <span v-else>Frete Grátis</span>
                                                        </b> <br>
                                                        <span>
                                                            De
                                                            <span>{{ product.served.min_delivery_time }}</span>
                                                            a
                                                            <span>{{ product.served.max_delivery_time }}</span>
                                                            <span>{{ product.served.time_type_text }}</span>
                                                        </span> <br>
                                                    </div>
                                                    <v-chip x-small v-if="product.required_cro" color="primary">CRO Obrigatório</v-chip>
                                                </div>

                                                <!-- options -->
                                                <div class="col-md-12">
                                                    <div class="mt-3">
                                                        <v-select
                                                            v-for="(spec, i) in product.selectable_specs" :key="i"
                                                            :label="spec.name"
                                                            :items="spec.items"
                                                            item-text="name"
                                                            item-value="name"
                                                            outlined dense
                                                            v-model="specs[spec.id]"
                                                        />
                                                    </div>
                                                </div>

                                                <!-- buttons  -->
                                                <div class="col-md-12">
                                                    <div class="row" v-if="product.status == 'active' && !!product.served">
                                                        <div class="col-md-4">
                                                            <label for="amount">Quantidade</label>
                                                            <input
                                                                id="amount"
                                                                type="number"
                                                                min="1" :max="product.amount"
                                                                v-model="amount"
                                                                class="form-control"
                                                            />
                                                            <v-chip x-small>{{product.amount}} disponíveis</v-chip>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <v-btn large elevation="0" block class="mb-2" @click="addInCart">Adicionar ao carrinho</v-btn>
                                                            <v-btn large elevation="0" block color="primary lighten-1">Comprar</v-btn>
                                                        </div>
                                                    </div>
                                                    <div v-if="product.status != 'active'">
                                                        <v-alert 
                                                            color="warning"
                                                            type="info"
                                                            outlined
                                                            border="left"
                                                        >Anúncio pausado</v-alert>
                                                    </div>
                                                    <div class="mt-3" v-if="!product.served">
                                                        <v-alert 
                                                            color="warning"
                                                            type="info"
                                                            outlined
                                                            border="left"
                                                        >Este vendedor não atende à sua localidade</v-alert>
                                                    </div>
                                                </div>

                                            </div>
                                        </v-card-text>
                                    </v-card>

                                </div>
                            </div>
                        </v-card-text>
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
        carouselImage: 0,
        amount: 1,
        specs: {}
    }),

    mounted(){
        
    },  
    watch: {
        '$route.params.slug': {
            handler: function(slug) {
                if(slug)
                    this.getProduct(slug)
            },
            deep: true,
            immediate: true
        }
    },
    methods: {
        getProduct(slug){
            // const slug = this.$route.params.slug
            this.$commom.request({
                url: '/product/slug/'+slug,
                auth: true,
                success: resp => {
                    this.product = {...resp}
                }
            })
        },

        toggleFavorite(){
            this.$commom.request({
                url: '/favorite-product/',
                type: 'post',
                data: {id_product: this.product.id},
                auth: true,
                success: resp => {
                    const prod = this.product
                    prod.is_favorite = !prod.is_favorite
                    this.product = {...prod}
                }
            })
        },

        addInCart(){

            const data = {
                amount: this.amount,
                specs: this.specs,
                id_product: this.product.id
            }

            this.$commom.request({
                url: '/cart/add-item',
                type: 'post',
                data: data,
                auth: true,
                setError: true,
                success: resp => {
                    this.$router.push('/carrinho')
                }
            })
        }
    }
}
</script>
<style scoped>
.price-text{
    font-size: 40px;
}
.description{
    font-size: 20px;
    white-space: break-spaces;
    line-height: initial;
}
.selected-image{
    border: 2.5px solid rgb(125 176 239);
}
.specs-table tr{
    height: 60px;
    vertical-align: middle;
}
</style>