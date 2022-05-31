<template>
    <div class="col-md-8">
        <v-card :loading="cartLoading">
            <v-card-text class="p-5">

                <div v-if="!!cart && !!cart.sellers && !!cart.sellers.length ">

                    <div class="row mt-4" v-for="(seller,i) in cart.sellers" :key="i">

                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-sm-4 col-md-2">
                                            <v-avatar size="50">
                                                <v-img :src="seller.picture"/>
                                            </v-avatar>
                                        </div>
                                        <div class="col-sm-8 col-md-10">
                                            <span>Produtos de</span>
                                            <h5>{{seller.name}}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div v-if="!!seller.served">
                                        <b class="text-success">
                                            <v-icon x-small color="success">fa fa-truck</v-icon>
                                            <span v-if="seller.served.freight>0">Frete: R$ {{ $commom.toMoney(seller.served.freight) }}</span>
                                            <span v-else>Frete Grátis</span>
                                        </b> <br>
                                        <span>
                                            De
                                            <span>{{ seller.served.min_delivery_time }}</span>
                                            a
                                            <span>{{ seller.served.max_delivery_time }}</span>
                                            <span>{{ seller.served.time_type_text }}</span>
                                        </span> <br>
                                    </div>
                                </div>
                            </div>
                            <v-divider></v-divider>
                        </div>

                        <div class="col-12 pl-15">
                            <div class="row align-items-center" v-for="(item, i) in seller.cart_items" :key="i">
                                <div class="col-md-2">
                                    <v-img width="100" :src="item.product.principal_image"/>
                                </div>
                                <div class="col-md-6">
                                    <h3>{{item.product.name}}</h3>
                                    <div>
                                        <span v-for="(spec, i) in item.specs" :key="i">
                                            {{spec.spec.name}}: {{spec.data}}
                                            <span v-if="i>0 && i<item.specs.length">, </span>
                                        </span>
                                    </div>
                                    <div>
                                        <v-btn class="p-0" @click="() => removeItem(item.id)" plain small color="primary">Excluir</v-btn>
                                        <v-btn class="p-0 ml-3" :to="`/p/${item.product.slug}`" plain small color="primary">Ver produto</v-btn>
                                    </div>
                                </div>
                                <div class="col-md-2 text-center">
                                    <div class="d-flex justify-content-center">
                                        <div class="number-field">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <v-btn icon :disabled="item.amount<=1" @click="() => updateItemAmount(item.id, 'minus')">
                                                    <v-icon small color="error">fa fa-minus</v-icon>
                                                </v-btn>
                                                <b>{{parseInt(item.amount)}}</b>
                                                <v-btn icon :disabled="item.amount >= item.product.amount" @click="() => updateItemAmount(item.id, 'plus')">
                                                    <v-icon small color="primary">fa fa-plus</v-icon>
                                                </v-btn>
                                            </div>
                                        </div>
                                    </div>
                                    <span>{{item.product.amount}} disponíveis</span>
                                </div>
                                <div class="col-md-2">
                                    <h4>
                                        R$ {{ $commom.toMoney(item.price) }}
                                    </h4>
                                </div>
                                <div class="col-12">
                                    <v-divider/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-right">
                        <h4>
                            <span v-if="cart.freight>0">Frete: R$ {{ $commom.toMoney(cart.freight) }}</span>
                            <span v-else>Frete Grátis</span>
                        </h4>
                        <h2>Total: R$ {{$commom.toMoney(cart.total_price)}}</h2>
                    </div>
                </div>
                <!-- <div v-else-if="!!cart && !cart.sellers.length">
                    <h2 class="text-center">Seu carrinho está vazio</h2>
                </div> -->
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
export default {
    
    data: () => ({
        cart: {},
        cartLoading: false
    }),
    mounted(){
        this.getCart()
    },
    methods: {
        getCart(){
            this.cartLoading = true
            this.$commom.request({
                url: "/cart",
                type: "get",
                auth: true,
                setError: true,
                success: (resp) => {
                    this.cartLoading = false
                    this.cart = {...resp}
                },
                error: () => this.cartLoading = false
            });
        },
        removeItem(id){
            this.$commom.confirm({
                title: 'Remover este produto do seu carrinho?',
                onConfirm: () => {
                    this.cartLoading = true
                    this.$commom.request({
                        url: '/cart-item/'+id,
                        type: 'delete',
                        auth: true,
                        setError: true,
                        success: resp => {
                            this.getCart()
                        },
                        error: () => this.cartLoading = false
                    })
                }
            })
        },

        updateItemAmount(id, handle='plus'){
            this.cartLoading = true

            this.$commom.request({
                url: '/cart-item/amount/'+id,
                type: 'put',
                data: {handle},
                auth: true,
                setError: true,
                success: resp => {
                    this.getCart()
                },
                error: () => this.cartLoading = false

            })
        },

    }
}
</script>

<style>
.number-field{
    border: 1px solid rgb(191, 191, 191);
    border-radius: 5px;
    width: 7rem;
}
</style>