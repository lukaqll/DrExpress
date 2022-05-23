<template>
    <div>
        <v-card :loading="loading">
            <v-card-title>
                <div class="row">
                    <div class="col-12">
                        Vendedores
                        <v-btn text color="primary" class="float-right" @click="$router.push('/admin/sellers/create')">Novo Vendedor</v-btn>
                    </div>
                </div>
            </v-card-title>
            <v-card-text>
                <v-text-field v-model="search" clearable label="Buscar"/>
                <v-data-table
                    :headers="usersHeaders"
                    :items="users"
                    :search="search"
                >
                    <template v-slot:item.name="{ item }">
                        <v-avatar size="35" class="mr-3">
                            <v-img :src="item.picture" />
                        </v-avatar>
                        {{item.name}}
                    </template>
                    <template v-slot:item.roles_header="{ item }">
                        <span class="badge rounded-full bg-primary mr-1" v-for="(role, i) in item.roles" :key="i">{{role.name}}</span>
                    </template>
                    <template v-slot:item.actions_header="{ item }">
                        <v-btn v-if="$can('update-users')" icon color="primary" @click="$router.push(`/admin/sellers/${item.id}/update`)">
                            <v-icon small>fa fa-edit</v-icon>
                        </v-btn>
                        <v-btn v-if="$can('update-users')" @click="() => toggleStatus(item.id)" icon :color="item.status == 'A' ? 'success' : 'error'" data-toggle="tooltip" :title="item.status == 'A' ? 'Desativar' : 'Ativar'">
                            <v-icon small>fa fa-power-off</v-icon>
                        </v-btn>
                    </template>
                </v-data-table>
            </v-card-text>
        </v-card>


    </div>
</template>
<script>
export default {
    data: () => ({
        users: [],
        loading: true,
        search: '',

        usersHeaders: [
            {text: 'Nome', value: 'name'},
            {text: 'E-mail', value: 'email'},
            {text: 'Status', value: 'status_text'},
            {text: 'CPF/CNPJ', value: 'doc_number'},
            {text: 'CRO', value: 'cro'},
            {text: 'Funções', value: 'roles_header'},
            {text: '', value: 'actions_header'},
        ],

    }),

    mounted(){
        this.getUsers()
    },

    methods: {
        getUsers() {
            this.loading = true
            this.$commom.request({
                url: '/seller',
                auth: true,
                success: resp => {
                    this.loading = false
                    this.users = [...resp]
                }
            })
        },

        toggleStatus(id){
            this.$commom.request({
                url: '/seller/'+id+'/toggle-status',
                type: 'put',
                auth: true,
                success: resp => {
                    this.getUsers()
                }
            })
        },

    }
}
</script>