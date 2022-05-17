<?php 

 namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DistrictController extends Controller
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
            $result = $this->districtService->list( $dataFilter, ['id'] );

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
            $result = $this->districtService->get( $dataFilter );
    
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

            $result = $this->districtService->get( ['id' => $id] );
            $response = [ 'status' => 'success', 'data' => ($result) ];

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
                'cep' => 'required|string|min:9',
            ]);
            $validData['id_city'] = $id;

            $isDistrictExists = $this->districtService->get(['name' => $validData['name'], 'id_city' => $id]);
            if(!empty($isDistrictExists))
                $this->throwException("Bairro {$validData['name']} já cadastrado para esta cidade");
            
            $created = $this->districtService->create( $validData );
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
            
            $district = $this->districtService->find($id);

            $validData = $request->validate([
                'name' => 'required|string',
                'cep' => 'required|string|min:9',
            ]);

            $isDistrictExists = $this->districtService->get(['name' => $validData['name'], 'id_city' => $district->id_city]);
            if(!empty($isDistrictExists) && $isDistrictExists->id != $id)
                $this->throwException("Bairro {$validData['name']} já cadastrado para esta cidade");

            $updated = $this->districtService->updateById( $id, $validData);
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

            $deleted = $this->districtService->deleteById( $id );
            $response = [ 'status' => 'success', 'data' => ($deleted) ];

        } catch ( ValidationException $e ){
            
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }

        return response()->json( $response );
    }
}