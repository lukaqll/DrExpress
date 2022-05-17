import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import colors from 'vuetify/lib/util/colors'

Vue.use(Vuetify)

const isDark = localStorage.getItem('darkmode') == '1' ? true : false

const opts = {
    theme: {
        dark: isDark,
        themes: {
            light: {
                background: '#f1f1f1',
                petrol: '#17a499',

            },

            dark: {
                primary: '#696ffb',
                purple: '#d54abd',
                success: '#4cceac',
                secondary: '#6c757d',
                accent: '#3ea2fb',
                error: '#db504a',
                petrol: '#17a499',
                background: '#141b2d',
            },

        },
        options: {
            customProperties: false,
        },
    },
}

export default new Vuetify(opts)