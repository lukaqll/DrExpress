<template>
    <div class="text-center">
        <h1>403 | Sem Autorização</h1>
        <div class="row">
            <div class="col-12 d-flex justify-content-between">
                <v-btn color="primary center" @click="$router.back(-2)">
                    <i class="fa fa-chevron-left"></i>
                    Voltar
                </v-btn>
                <v-btn text color="primary center" @click="$router.push('/login')">
                    Ir para o Login
                </v-btn>
            </div>
        </div>
    </div>
</template>