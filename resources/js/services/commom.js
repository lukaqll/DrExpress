import axios from "axios";
import SweetAlert from 'sweetalert2'
const commom = {

    request:  ( opt = {url, type, data, auth, log, success, savedAlert, error, setError, file, load} ) => {

        const method = opt.type||'get';
        let queryParams = '?'

        // build url params
        if(method == 'get' && opt.data){
            queryParams += new URLSearchParams(opt.data)
        }

        // send request
        axios({
            url: '/api'+opt.url+queryParams,
            method: method,
            data: opt.data,
            
            headers:  {
                'Content-Type': opt.file ? 'multipart/form-data' : undefined,
                'Authorization': opt.auth ? 'Bearer ' + localStorage.getItem('auth_token') : null
            },
        })
        .then ( resp => {
   
            opt.log && console.log( resp )
    
            if( !resp.data )
                return
            
            // success
            if( resp.data.status == 'success' ){
                opt.success && opt.success( resp.data.data )

                //successAlert is true
                opt.successAlert && commom.success({title: 'Salvo!'})
            } 

            // error
            else {
                opt.error && opt.error( resp.data.message )

                //if set error is true
                opt.setError && commom.setError({message: commom.errorMessages(resp.data.message) || 'Ops! Houve algum erro.'})
            }
    
        })
        .catch ( e => {
            opt.log && console.error( e )
            opt.error && opt.error( e )

            if( e.response ){
                if(e.response.status == 403 ||  e.response.status == 401)
                    commom.loginRedirect(e.response.data.message)

                if(e.response.status == 413)
                    commom.setError({title: 'Arquivo muito grande'})
            }

        })
    
    },

    verifyLogin: async () => {
        try {
            const result = await axios.get('/api/me', {headers: {Authorization: 'Bearer ' + localStorage.getItem('auth_token')}})
            return result.data

        } catch( e ){
            if( e.response && (e.response.status == 403 ||  e.response.status == 401) ){
                commom.loginRedirect(e.response.data.message)
            }
        }
    },

    errorMessages: (data='') => {
        if (typeof data == 'string'){
            return data
        }

        if( typeof data == 'array' || typeof data == 'object' ){

            let str = ''
            for( const key in data){
                if ( typeof data[key] == 'string'){
                    str += `- ${data[key]}<br>`
                } else if ( typeof data[key] == 'array' || typeof data[key] == 'object' ){
                    str += `- ${data[key][0]}<br>`
                }
            }
            return str
        }
    },


    setError: function(opt = {}){
        SweetAlert.fire({
            icon: opt.type ? opt.type : 'error',
            title: opt.title,
            html: opt.message ? opt.message : ''
        })
    },
    success: function(opt = {}){
        SweetAlert.fire({
            icon: 'success',
            title: opt.title,
            html: '<p>' + (opt.message || '') + '</p>',
            timer: opt.timer || 1000,
            showConfirmButton: false,
        })
    },
    confirm: function(opt = {}){
        SweetAlert.fire({
            icon: opt.type || 'warning',
            title: opt.title || '',
            html: '<p>' + (opt.message || '') + '</p>',
            showCancelButton: true,
            confirmButtonText: opt.confirmButtonText || 'Sim',
            cancelButtonText: opt.cancelButtonText || 'Cancelar',
        }).then((result)=>{
            if(result.value) {
                opt.onConfirm && opt.onConfirm()
            } else {
                opt.onCancel && opt.onCancel()
            }
        })
    },

    loginRedirect: (message) => {
        const query = {
            redirectTo: window.location.pathname,
            message: commom.errorMessages(message)
        }
        window.location.href = `/login?`+new URLSearchParams(query)
    },

    toMoney: (str, currency=false) => {
        if(str == null || str == '' || !str)
            return currency ? ('R$ ' + '0,00') : '0,00'

        if(parseFloat(str) > 0){

            let val = parseFloat(str).toFixed(2)
            let array = parseFloat(val).toLocaleString("pt-BR", {currency:"BRL"}).split(',')
            
            let decimal = array[1] ? array[1].padEnd(2, '0') : '00'

            const toReturn = ( array[0] + ',' + decimal )
            return currency ? ('R$ ' + toReturn) : toReturn
        } else {
            return currency ? ('R$ ' + '0,00') : '0,00'
        }
    },

    dateFormat: function(str, time = false) {

        if (str == null || str == '' || !str) return ''

        const dateTimeSplit = str.match('T') ? str.split('T') : str.split(' ')

        const parts = dateTimeSplit[0].split('-')
        const day = parts[2]
        const month = parts[1]
        const year = parts[0]

        return day + '/' + month + '/' + year + (dateTimeSplit[1] && time ? (' ' + dateTimeSplit[1].split('.')[0]) : '')
    },

    refreshUser: () => {

        commom.verifyLogin()
            .then(result => {
                if( result.status == 'success' ){
                    const user = result.data
                    Vue.prototype.$useStore.setUser(user).then()
                }
            })

    }
}

export default commom