import { defineStore } from 'pinia'


export const useStore = defineStore('user', {
    state: () => ({
        user: null,
        loading: false,
    }),

    actions: {

        async setUser(user) {
            if(user){
                this.user = {...user}
            } else {
                this.user = null
            }
            return user
        },

        setLoading(isLoading) {
            this.loading = !!isLoading
        }

    }
})