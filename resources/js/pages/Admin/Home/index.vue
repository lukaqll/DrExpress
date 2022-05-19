<template>
    <div class="row d-flex">

        <div class="col-md-4">
            <v-card class="h-100">
                <v-card-text>
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-2">
                                    <v-avatar color="purple" icon>
                                        <v-icon dark>fa fa-users</v-icon>
                                    </v-avatar>
                                </div>
                                <div class="col-10">
                                    <span class="text-h4">5</span><br>
                                    <span class="h5">Operadores</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12" v-if="$can('view-users')">
                            <v-btn @click="$router.push('/admin/users')" text block color="purple">Detalhes</v-btn>
                        </div>
                    </div>
                </v-card-text>
            </v-card>
        </div>
        <div class="col-md-4">
            <v-card class="h-100">
                <v-card-text>
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-2">
                                    <v-avatar color="yellow darken-2" icon>
                                        <v-icon dark>fa fa-store</v-icon>
                                    </v-avatar>
                                </div>
                                <div class="col-10">
                                    <span class="text-h4">5</span><br>
                                    <span class="h5">Vendedores</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12" v-if="$can('view-sellers')">
                            <v-btn @click="$router.push('/admin/sellers')" text block color="yellow darken-2">Detalhes</v-btn>
                        </div>
                    </div>
                </v-card-text>
            </v-card>
        </div>
        <div class="col-md-4">
            <v-card class="h-100">
                <v-card-text>
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-2">
                                    <v-avatar color="success darken-2" icon>
                                        <v-icon dark>fa fa-mobile-alt</v-icon>
                                    </v-avatar>
                                </div>
                                <div class="col-10">
                                    <span class="text-h4">5</span><br>
                                    <span class="h5">Clientes</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </v-card-text>
            </v-card>
        </div>

    </div>
</template>