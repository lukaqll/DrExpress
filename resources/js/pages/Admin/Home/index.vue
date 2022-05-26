<template>
    <div class="row">
        <div class="col-md-4" v-for="(card,i) in cards" :key="i">
            <report-home-card :data="card"/>
        </div>
    </div>
</template>

<script>
import ReportHomeCard from '../../../components/ReportHomeCard'
export default {
    
    components: {ReportHomeCard},

    data: () => ({
        data: {},
    }),

    computed: {
        cards(){

            return [
                {title: 'Vendedores', color: 'yellow darken-2', icon: 'fa fa-store', info: this.data.sellers, link: '/admin/sellers', canLink: ['view-sellers']},
                {title: 'Operadores', color: 'purple', icon: 'fa fa-users', info: this.data.operators, link: '/admin/users', canLink: ['view-users']},
                {title: 'Clientes', color: 'success darken-2', icon: 'fa fa-mobile-alt', info: this.data.clients}
            ]
        }
    },
    mounted(){
        this.getHomeData()
    },  
    methods: {
        getHomeData(){
            this.$commom.request({
                url: '/admin/home',
                auth: true,
                success: resp => {
                    this.data = {...resp}
                }
            })
        }
    }
}
</script>