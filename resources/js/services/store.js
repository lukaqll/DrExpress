import { defineStore } from 'pinia'


export const useStore = defineStore('user', {
    state: () => ({
        user: null
    }),

    actions: {

        async setUser(user) {
            if(user){
                this.user = {...user}
            } else {
                this.user = null
            }
            return user
        }

    }
})