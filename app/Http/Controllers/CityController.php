<?php 

 namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityDistrictsResource;
use App\Http\Resources\CityResource;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CityController extends Controller
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
            $result = $this->cityService->list( $dataFilter, ['id'] );

            $response = [ 'status' => 'success', 'data' => CityResource::collection($result) ];
            
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
            $result = $this->cityService->get( $dataFilter );
    
            $response = [ 'status' => 'success', 'data' => new CityResource($result) ];
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

            $result = $this->cityService->get( ['id' => $id] );
            $response = [ 'status' => 'success', 'data' => new CityResource($result) ];

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
    public function getDistricts( $id ){

        try {

            $result = $this->cityService->get( ['id' => $id] );
            $response = [ 'status' => 'success', 'data' => new CityDistrictsResource($result) ];

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
        $this->gate('create-address');
        try {

            $validData = $request->validate([
                'name' => 'required|string',
                'ibge_code' => 'required|string',
                'cep' => 'required|string|min:9',
            ]);
            $validData['id_uf'] = $id;

            $isCityExist = $this->cityService->get([
                'name' => $validData['name'],
                'id_uf' => $validData['id_uf'],
            ]);
            if( !empty($isCityExist) )
                throw ValidationException::withMessages(["Cidade {$validData['name']} já cadastrada para este estado"]);
            
            $created = $this->cityService->create( $validData );
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
            
            $city = $this->cityService->find($id);

            $validData = $request->validate([
                'name' => 'required|string',
                'ibge_code' => 'required|string',
                'cep' => 'required|string|min:9',
            ]);

            $isCityExist = $this->cityService->get([
                'name' => $validData['name'],
                'id_uf' => $city->id_uf,
            ]);
            if( !empty($isCityExist) && $isCityExist->id != $id )
                throw ValidationException::withMessages(["Cidade {$validData['name']} já cadastrada para este estado"]);

            $updated = $this->cityService->updateById( $id, $validData );
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

            $deleted = $this->cityService->deleteById( $id );
            $response = [ 'status' => 'success', 'data' => ($deleted) ];

        } catch ( ValidationException $e ){
            
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }

        return response()->json( $response );
    }
}