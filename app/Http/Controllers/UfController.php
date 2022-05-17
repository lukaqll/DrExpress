<?php 

 namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\UfCitiesResource;
use App\Http\Resources\UfResource;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UfController extends Controller
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
            $result = $this->ufService->list( $dataFilter, ['id'] );

            $response = [ 'status' => 'success', 'data' => UfResource::collection($result) ];
            
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
            $result = $this->ufService->get( $dataFilter );
    
            $response = [ 'status' => 'success', 'data' => new UfResource($result) ];
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

            $result = $this->ufService->get( ['id' => $id] );
            $response = [ 'status' => 'success', 'data' => new UfResource($result) ];

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
    public function getCities( $id ){
        try {

            $result = $this->ufService->get( ['id' => $id] );
            $response = [ 'status' => 'success', 'data' => new UfCitiesResource($result) ];

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
    public function create( Request $request ){
        $this->gate('create-address');
        try {

            $validData = $request->validate([
                'name' => 'required|string|unique:ufs',
                'initials' => 'required|string|unique:ufs',
            ]);
            
            $created = $this->ufService->create( $validData );
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
        $this->gate('update-address');
        try {
            
            $validData = $request->validate([
                'name' => 'required|string|unique:ufs,id,'.$id,
                'initials' => 'required|string|unique:ufs,id,'.$id,
            ]);
            $updated = $this->ufService->updateById( $id, $validData);
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
        $this->gate('delete-address');
        try {

            $deleted = $this->ufService->deleteById( $id );
            $response = [ 'status' => 'success', 'data' => ($deleted) ];

        } catch ( ValidationException $e ){
            
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }

        return response()->json( $response );
    }
}