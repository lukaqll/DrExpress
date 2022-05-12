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
        })
    
    },

    verifyLogin: async () => {

        const result = await axios.get('/api/me', {headers: {Authorization: 'Bearer ' + localStorage.getItem('auth_token')}})
        return result.data
    }
}

export default commom