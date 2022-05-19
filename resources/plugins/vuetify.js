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
                'dash-drawer-bakground': '#00a8e9',
                'admin-drawer-bakground': '#fff',
            },

            dark: {
                primary: '#7367f0',
                purple: '#d54abd',
                success: '#4cceac',
                secondary: '#6c757d',
                accent: '#3ea2fb',
                error: '#db504a',
                petrol: '#17a499',
                background: '#141b2d',
                // 'admin-drawer-bakground': '#594cd8',
            },

        },
        options: {
            customProperties: false,
        },
    },
}

export default new Vuetify(opts)