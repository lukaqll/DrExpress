<template>
    <div class="row">
        <div class="col-md-12">
            <v-card>
                <v-card-title>
                    <div class="row">
                        <div class="col-md-6">
                            Meus Produtos
                        </div>
                        <div class="col-md-6 text-right">
                            <v-btn color="primary" text @click="$router.push('/dashboard/produtos/novo')">Novo Anúncio</v-btn>
                        </div>
                    </div>

                </v-card-title>
                <v-card-text>
                    <v-simple-table>

                    </v-simple-table>
                </v-card-text>
            </v-card>
        </div>
    </div>
</template>