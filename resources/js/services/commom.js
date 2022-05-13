import axios from "axios";

const commom = {

    request:  ( opt = {url, type, data, auth, log, success, savedAlert, error, setError, file, load} ) => {

        // send request
        axios({
            url: '/api'+opt.url,
            method: opt.type,
            data: opt.data||'get',
            
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

                //savedAlert is true
                // opt.savedAlert && common.success({title: 'Salvo!'})
            } 

            // error
            else {
                opt.error && opt.error( resp.data.message )

                //if set error is true
                // opt.setError && common.setError({message: common.formatRequiredError(resp.data.message) || 'Ops! Houve algum erro.'})
            }
    
        })
        .catch ( e => {
            opt.log && console.error( e )
            opt.error && opt.error( e )

            if( e.response.status == 403 ||  e.response.status == 401 )
                window.location.href = '/403'
        })
    
    },

    verifyLogin: async () => {

        const result = await axios.get('/api/me', {headers: {Authorization: 'Bearer ' + localStorage.getItem('auth_token')}})
        return result.data
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
                    str += `- ${data[key][0]}\n`
                }
            }
            return str
        }
    }
}

export default commom