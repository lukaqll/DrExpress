<?php 

 namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\AddressResource;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AddressController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * list all
     * 
     * @return  json
     */
    public function list( Request $request )
    {
        try {

            $dataFilter = $request->all();
            $result = $this->addressService->list( $dataFilter, ['id'] );

            $response = [ 'status' => 'success', 'data' => ($result) ];
            
        } catch ( ValidationException $e ){

            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }
        return response()->json( $response );
    }

    /**
     * get by key and value
     * 
     * @return  json
     */
    public function get( Request $request ){

        try {

            $dataFilter = $request->all();
            $result = $this->addressService->get( $dataFilter );
    
            $response = [ 'status' => 'success', 'data' => ($result) ];
        } catch ( ValidationException $e ){

            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }
        return response()->json( $response ); 
    }

    /**
     * get by id
     * 
     * @return  json
     */
    public function getById( $id ){

        try {
            $result = $this->addressService->get( ['id' => $id] );
            $response = [ 'status' => 'success', 'data' => new AddressResource($result) ];

        } catch ( ValidationException $e ){

            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }
        return response()->json( $response ); 
    }

    /**
     * get by user id
     * 
     * @return  json
     */
    public function getByUser( $idUser ){
        $this->gate('view-user-address');

        try {
            $result = $this->addressService->list( ['id_user' => $idUser] );
            $response = [ 'status' => 'success', 'data' => AddressResource::collection($result) ];

        } catch ( ValidationException $e ){

            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }
        return response()->json( $response ); 
    }

    /**
     * get by me
     * 
     * @return  json
     */
    public function getMe(){
        try {
            $user = auth('api')->user();
            $result = $this->addressService->list( ['id_user' => $user->id] );
            $response = [ 'status' => 'success', 'data' => AddressResource::collection($result) ];

        } catch ( ValidationException $e ){

            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }
        return response()->json( $response ); 
    }

    /**
     * create
     * 
     * @return  json
     */
    public function create( Request $request, $id ){
        $this->gate('create-user-address');

        try {

            $validData = $request->validate([
                'id_district' => 'required|exists:districts,id',
                'street'      => 'required|string',
                'cep'         => 'required|string',
                'number'      => 'nullable|string',
                'complement'  => 'nullable|string',
                'reference'   => 'nullable|string',
                'is_default'  => 'nullable',

            ]);
            $validData['id_user'] = $id;
   
            $created = $this->addressService->create( $validData );

            $user = $created->user;
            if( empty($user->is_address) || !empty($validData['is_default']) )
                $user->update(['id_address' => $created->id]);
            
            $response = [ 'status' => 'success', 'data' => ($created) ];

        } catch ( ValidationException $e ){
            
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }

        return response()->json( $response );
    }

    /**
     * create
     * 
     * @return  json
     */
    public function createMe( Request $request ){
        
        try {
            $user = auth('api')->user();

            $validData = $request->validate([
                'id_district' => 'required|exists:districts,id',
                'street'      => 'required|string',
                'cep'         => 'required|string',
                'number'      => 'nullable|string',
                'complement'  => 'nullable|string',
                'reference'   => 'nullable|string',
                'is_default'  => 'nullable',

            ]);
            $validData['id_user'] = $user->id;
   
            $created = $this->addressService->create( $validData );

            if( empty($user->is_address) || !empty($validData['is_default']) )
                $created->user->update(['id_address' => $created->id]);
            
            $response = [ 'status' => 'success', 'data' => ($created) ];

        } catch ( ValidationException $e ){
            
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }

        return response()->json( $response );
    }

    /**
     * update
     * 
     * @return  json
     */
    public function update( Request $request, $id ){
        $this->gate('update-user-address');
        try {
           
            $validData = $request->validate([
                'id_district' => 'required|exists:districts,id',
                'street'      => 'required|string',
                'cep'         => 'required|string',
                'number'      => 'nullable|string',
                'complement'  => 'nullable|string',
                'reference'   => 'nullable|string',
                'is_default'  => 'nullable',
            ]);
            $updated = $this->addressService->updateById( $id, $validData );

            if( !empty($validData['is_default']) )
                $updated->user->update(['id_address' => $updated->id]);

            $response = [ 'status' => 'success', 'data' => ($updated) ];

        } catch ( ValidationException $e ){
            
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }

        return response()->json( $response );
    }

    /**
     * update
     * 
     * @return  json
     */
    public function updateMe( Request $request, $id ){
        
        try {
            $user = auth('api')->user();
            $address = $this->addressService->find($id);

            if( $user->id != $address->id_user )
                $this->throwException('Falha ao atualizar endereço');
            
            $validData = $request->validate([
                'id_district' => 'required|exists:districts,id',
                'street'      => 'required|string',
                'cep'         => 'required|string',
                'number'      => 'nullable|string',
                'complement'  => 'nullable|string',
                'reference'   => 'nullable|string',
                'is_default'  => 'nullable',
            ]);
            $updated = $this->addressService->updateById( $id, $validData );

            if( !empty($validData['is_default']) )
                $updated->user->update(['id_address' => $updated->id]);

            $response = [ 'status' => 'success', 'data' => ($updated) ];

        } catch ( ValidationException $e ){
            
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }

        return response()->json( $response );
    }

    /**
     * delete
     * 
     * @return  json
     */
    public function delete( $id ){

        try {

            $deleted = $this->addressService->deleteById( $id );
            $response = [ 'status' => 'success', 'data' => ($deleted) ];

        } catch ( ValidationException $e ){
            
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }

        return response()->json( $response );
    }
}