<template>
    
    <v-card class="h-100">
        <v-card-text>
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-2">
                            <v-avatar :color="data.color" icon>
                                <v-icon dark>{{ data.icon }}</v-icon>
                            </v-avatar>
                        </div>
                        <div class="col-10">
                            <span class="text-h4" v-if="data.info">{{ data.info.total }}</span><br>
                            <span class="h5">{{ data.title }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <v-sparkline
                        v-if="data.info"
                        :value="data.info.chart"
                        auto-draw :auto-draw-duration="1000"
                        :color="data.color"
                        :auto-line-width='false'
                        stroke-linecap="round"
                        smooth="15"
                        line-width="2"
                        height="50"
                    />
                </div>
                <div class="col-12" v-if="data.link">
                    <div v-if="!data.canLink || (data.canLink && $can(data.canLink))">
                        <router-link is="v-btn" :to="data.link" text block :color="data.color">Detalhes</router-link>
                    </div>
                </div>
            </div>
        </v-card-text>
    </v-card>
</template>

<script>
export default {
    props: {data: Object}
}
</script>