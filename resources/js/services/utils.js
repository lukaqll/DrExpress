import Vue from "vue";

const utils = {

    absoluteRole: 'admin',

    getMenu: ( menu ) => {
        
        const user = Vue.prototype.$useStore ? Vue.prototype.$useStore.user : null

        const result = []
        
        if( !user || user.status == 'I' )
            return result


        for( const item of menu ){

            if( !item.can ){
                result.push(item)
            } else {

                if( utils.can( item.can ) )
                    result.push(item)
            }
        }

        return result
    },

    can: ( permissions='' ) => {
        
        const user = Vue.prototype.$useStore ? Vue.prototype.$useStore.user : null

        if(!user || user.status == 'I')
            return false

        if( user.roles.includes(utils.absoluteRole) )
            return true;

        if( typeof permissions == 'string' )
            return !! user.permissions.includes( permissions )

        for( const permission of permissions ){
            if( user.permissions.includes( permission ) )
                return true
        }

        return false;
    }
}

export default utils;