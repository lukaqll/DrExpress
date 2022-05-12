<template>
    <v-main app>
        <v-container class="auth-container">
            <div class="card-wrap">
                <slot/>
            </div>
        </v-container>
    </v-main>
</template>

<style scoped>

    .auth-container{
        min-height: 100vh;
        justify-content: center;
        display: flex;
        align-items: center;
    }

    .card-wrap{
        display: flex;
        justify-content: center;
        width: 100%;
    }
</style>