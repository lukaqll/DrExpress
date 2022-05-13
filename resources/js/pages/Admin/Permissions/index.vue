<template>
    <div class="row">
        <div class="col-md-6">
            <v-card>
                <v-card-title>
                    <div class="row">
                        <div class="col-12">
                            Funções
                            <v-btn v-if="$can('create-permissions')" class="float-right" @click="() => modalRole = true">Nova Função</v-btn> 
                        </div>
                    </div>
                </v-card-title>
                <v-card-text>
                    <v-data-table 
                        :headers="rolesHeaders"
                        :items="roles"
                        :search="roleSearch"
                        item-key="id"
                    >
                        <template v-slot:top>
                            <v-text-field v-model="roleSearch" label="Pesquisar"></v-text-field>
                        </template>
                        <template v-slot:item.permissions_header="{ item }">
                            <v-badge :content="item.id_permissions.length"/>
                        </template>
                        <template v-slot:item.actions="{ item }">
                            <v-btn v-if="$can('update-permissions')" icon color="primary" @click="()=>getRole(item.id)">
                                <i class="fa fa-edit"></i>
                            </v-btn>
                        </template>
                    </v-data-table>
                </v-card-text>
            </v-card>
        </div>

        <div class="col-md-6">
            <v-card>
                <v-card-title>
                    <div class="row">
                        <div class="col-12">
                            Permissões
                            <v-btn v-if="$can('create-permissions')" class="float-right" @click="() => modalPermission = true">Nova Permissão</v-btn> 
                        </div>
                    </div>
                </v-card-title>
                <v-card-text>
                    <v-data-table 
                        :headers="permissionsHeaders"
                        :items="permissions"
                        :search="permissionSearch"
                        item-key="id"
                    >
                        <template v-slot:top>
                            <v-text-field v-model="permissionSearch" label="Pesquisar"></v-text-field>
                        </template>
                        <template v-slot:item.actions="{ item }">
                            <v-btn v-if="$can('update-permissions')" icon color="primary" @click="() => getPermission(item.id)">
                                <i class="fa fa-edit"></i>
                            </v-btn>
                        </template>
                    </v-data-table>
                </v-card-text>
            </v-card>
        </div>

        <!-- modal role -->
        <v-dialog v-model="modalRole" v-if="$can('create-permissions')" width="700">
            <template v-slot:default="dialog">
                <v-card>
                    <v-toolbar color="light" elevation="1">Nova Função</v-toolbar>
                    <v-card-text class="pt-5">
                        <v-form id="create-role" @submit.prevent="createRole">
                            <div class="row">
                                <div class="col-md-6">
                                    <v-text-field v-model="newRole.name" label="Nome" autofocus/>
                                </div>
                                <div class="col-md-6">
                                    <v-text-field v-model="newRole.slug" label="Slug"/>
                                </div>
                                <div class="col-md-12">
                                    <v-text-field v-model="newRole.description" label="Descrição"/>
                                </div>

                                <div v-if="roleError && roleError.length" class="col-12">
                                    <v-alert type="error" v-html="roleError"></v-alert>
                                </div>
                            </div>
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-btn text @click="dialog.value = false">Fechar</v-btn>
                        <v-btn form="create-role" type="submit" color="primary">Salvar</v-btn>
                    </v-card-actions>
                </v-card>
            </template>
        </v-dialog>

        <!-- edit role -->
        <v-dialog v-model="modalEditRole" v-if="$can('create-permissions')" width="700">
            <template v-slot:default="dialog">
                <v-card>
                    <v-toolbar color="light" elevation="1">Editar Função</v-toolbar>
                    <v-card-text class="pt-5">
                        <v-form id="update-role" @submit.prevent="updateRole">
                            <div class="row">
                                <div class="col-md-6">
                                    <v-text-field v-model="editRole.name" label="Nome" autofocus/>
                                </div>
                                <div class="col-md-6">
                                    <v-text-field v-model="editRole.slug" label="Nome"/>
                                </div>
                                <div class="col-md-12">
                                    <v-text-field v-model="editRole.description" label="Descrição"/>
                                </div>

                                <div class="col-12">
                                    <v-autocomplete 
                                        label="Permissões" 
                                        :items="permissionsOptions"
                                        v-model="editRole.id_permissions"
                                        chips 
                                        multiple
                                    >
                                    <template v-slot:selection="data">
                                        <v-chip
                                            v-bind="data.attrs"
                                            :input-value="data.selected"
                                            close
                                            @click="data.select"
                                            @click:close="removePermission(data.item)"
                                        >
                                            {{ data.item.text }}
                                        </v-chip>
                                    </template>
                                    </v-autocomplete>
                                </div>

                                <div v-if="roleError && roleError.length" class="col-12">
                                    <v-alert type="error" v-html="roleError"></v-alert>
                                </div>
                            </div>
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-btn text @click="dialog.value = false">Fechar</v-btn>
                        <v-btn form="update-role" type="submit" color="primary">Salvar</v-btn>
                    </v-card-actions>
                </v-card>
            </template>
        </v-dialog>

        <!-- modal permission -->
        <v-dialog v-model="modalPermission" v-if="$can('update-permissions')" width="700">
            <template v-slot:default="dialog">
                <v-card>
                    <v-toolbar color="light" elevation="1">Nova Permissão</v-toolbar>
                    <v-card-text class="pt-5">
                        <v-form id="create-permission" @submit.prevent="createPermission">
                            <div class="row">
                                <div class="col-md-12">
                                    <v-select v-model="newPermission.topic" label="Tópico" :items="permissionTopics"/>
                                </div>
                                <div class="col-md-6">
                                    <v-text-field v-model="newPermission.name" label="Nome" autofocus/>
                                </div>
                                <div class="col-md-6">
                                    <v-text-field v-model="newPermission.slug" label="Slug"/>
                                </div>
                                <div class="col-md-12">
                                    <v-text-field v-model="newPermission.description" label="Descrição"/>
                                </div>

                                <div v-if="permissionError && permissionError.length" class="col-12">
                                    <v-alert type="error" v-html="permissionError"></v-alert>
                                </div>
                            </div>
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-btn text @click="dialog.value = false">Fechar</v-btn>
                        <v-btn form="create-permission" type="submit" color="primary">Salvar</v-btn>
                    </v-card-actions>
                </v-card>
            </template>
        </v-dialog>

        <!-- modal edit permission -->
        <v-dialog v-model="modalEditPermission" v-if="$can('update-permissions')" width="700">
            <template v-slot:default="dialog">
                <v-card>
                    <v-toolbar color="light" elevation="1">Editar Permissão</v-toolbar>
                    <v-card-text class="pt-5">
                        <v-form id="update-permission" @submit.prevent="updatePermission">
                            <div class="row">
                                <div class="col-md-12">
                                    <v-select v-model="editPermission.topic" label="Tópico" :items="permissionTopics"/>
                                </div>
                                <div class="col-md-6">
                                    <v-text-field v-model="editPermission.name" label="Nome" autofocus/>
                                </div>
                                <div class="col-md-6">
                                    <v-text-field v-model="editPermission.slug" label="Slug"/>
                                </div>
                                <div class="col-md-12">
                                    <v-text-field v-model="editPermission.description" label="Descrição"/>
                                </div>

                                <div v-if="permissionError && permissionError.length" class="col-12">
                                    <v-alert type="error" v-html="permissionError"></v-alert>
                                </div>
                            </div>
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-btn text @click="dialog.value = false">Fechar</v-btn>
                        <v-btn form="update-permission" type="submit" color="primary">Salvar</v-btn>
                    </v-card-actions>
                </v-card>
            </template>
        </v-dialog>

    </div>
</template>

<script>
export default {
    data: () => ({

        // roles
        roleSearch: '',
        roles: [],
        modalRole: false,
        modalEditRole: false,
        newRole: {},
        editRole: {},
        roleError: '',
        
        permissionSearch: '',
        permissions: [],
        modalPermission: false,
        modalEditPermission: false,
        newPermission: {},
        editPermission: {},
        permissionError: '',

        rolePermissions: [],
        modalRolePermissions: false,

        permissionTopics: [
            {text: 'Usuário', value: 'user'},
            {text: 'Permissões', value: 'permissions'},
        ]

    }),
    mounted(){
        this.getRoles()
        this.getPermissions()
    },
    watch: {
        modalRole: function(v) {
            this.roleError = ''
            if( !v ) this.newRole = {}
        },
        modalEditRole: function(v) {
            this.roleError = ''
            if( !v ) this.editRole = {}
        },
        modalPerission: function(v) {
            this.permissionError = ''
            if( !v ) this.newPermission = {}
        },
        modalEditPerission: function(v) {
            this.permissionError = ''
            if( !v ) this.editPermission = {}
        },
    },
    computed: {
        rolesHeaders() { 
            return [
                {text: 'Nome', value: 'name'},
                {text: 'Slug', value: 'slug'},
                {text: 'Descrição', value: 'description'},
                {text: 'Permissões', value: 'permissions_header'},
                {text: '', value: 'actions', sortable: false},
            ]
        },

        permissionsHeaders() { 
            return [
                {text: 'Nome', value: 'name'},
                {text: 'Tópico', value: 'topic_text'},
                {text: 'Descrição', value: 'description'},
                {text: 'Slug', value: 'slug'},
                {text: '', value: 'actions', sortable: false},
            ]
        },

        permissionsOptions() {
            return this.permissions.map(p => ({
                text: p.name, value: p.id
            }))
        }
    },
    methods: {
        getRoles(){
            this.$commom.request({
                url: '/roles',
                auth: true,
                success: (resp) => {
                    this.roles = [...resp]
                }
            })
        },
        createRole(){
            this.$commom.request({
                url: '/roles',
                type: 'post',
                auth: true,
                data: this.newRole,
                success: (result) => {
                    this.modalRole = false
                    this.newRole = {}
                    this.roleError = ''
                    this.getRoles()
                    this.getRole(result.id)
                },
                error: e => {
                    this.roleError = this.$commom.errorMessages(e)
                }
            })
        },
        getRole(id){
            this.$commom.request({
                url: '/roles/'+id,
                auth: true,
                success: (resp) => {
                    this.editRole = {...resp}
                    this.modalEditRole = true
                }
            })
        },
        updateRole(){
            this.$commom.request({
                url: '/roles/'+this.editRole.id,
                type: 'put',
                auth: true,
                data: this.editRole,
                success: () => {
                    this.modalEditRole = false
                    this.editRole = {}
                    this.roleError = ''
                    this.getRoles()
                },
                error: e => {
                    this.roleError = this.$commom.errorMessages(e)
                }
            })
        },

        getPermissions(){
            this.$commom.request({
                url: '/permissions',
                auth: true,
                success: (resp) => {
                    this.permissions = [...resp]
                },
                
            })
        },
        getPermission(id){
            this.$commom.request({
                url: '/permissions/'+id,
                auth: true,
                success: (resp) => {
                    console.log(this.modalEditPermission)
                    this.editPermission = {...resp}
                    this.modalEditPermission = true
                },
                
            })
        },
        createPermission(){
            this.$commom.request({
                url: '/permissions',
                type: 'post',
                auth: true,
                data: this.newPermission,
                success: (result) => {
                    this.newPermission = {}
                    this.permissionError = ''
                    this.getPermissions()
                },
                error: e => {
                    this.permissionError = this.$commom.errorMessages(e)
                }
            })
        },
        updatePermission(){
            this.$commom.request({
                url: '/permissions/'+this.editPermission.id,
                type: 'put',
                auth: true,
                data: this.editPermission,
                success: () => {
                    this.modalEditPermission = false
                    this.editPermission = {}
                    this.permissionError = ''
                    this.getPermissions()
                },
                error: e => {
                    this.permissionError = this.$commom.errorMessages(e)
                }
            })
        },


        getRolePermission(id){
            this.$commom.request({
                url: `/roles/${id}/permissions`,
                auth: true,
                success: (resp) => {
                    console.log(resp)
                    this.rolePermissions = [...resp]
                },
                
            })
        },

        removePermission(item){
            let newEditRole = this.editRole
            const index = newEditRole.id_permissions.findIndex(i => i == item.value)
            newEditRole.id_permissions.splice(index, 1)
            this.editRole = {...newEditRole}
        }
    }
}
</script>