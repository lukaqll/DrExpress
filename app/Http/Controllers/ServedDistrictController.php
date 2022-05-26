<?php 

 namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServedDistrictResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ServedDistrictController extends Controller
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

            $user = auth('api')->user();
            $result = $this->servedDistrictService->list( ['id_user' => $user->id] );

            $response = [ 'status' => 'success', 'data' => ServedDistrictResource::collection($result) ];
            
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
            $result = $this->servedDistrictService->get( $dataFilter );
    
            $this->authorize('update', $result);

            $response = [ 'status' => 'success', 'data' => new ServedDistrictResource($result) ];
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

            $result = $this->servedDistrictService->get( ['id' => $id] );
            $this->authorize('update', $result);
            $response = [ 'status' => 'success', 'data' => new ServedDistrictResource($result) ];

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
        $this->gate('create-serverd-district');
        try {

            $user = auth('api')->user();

            $validData = $request->validate([
                'id_district'   => 'required|array',
                'id_district.*' => 'required|exists:districts,id',

                'freight'           => 'nullable',
                'min_delivery_time' => 'required|numeric|min:0.1',
                'max_delivery_time' => 'required|numeric|min:0.1',
                'time_type'         => 'required|string|max:1'
            ]);
            $validData['id_user'] = $user->id;
            $validData['freight'] = $this->unmaskMoney($validData['freight']);

            $created = $this->servedDistrictService->createLocales( $validData );
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
        $this->gate('create-serverd-district');
        try {
            
            $servedDistrict = $this->servedDistrictService->find($id);
            $this->authorize('update', $servedDistrict);

            $validData = $request->validate([
                'freight'           => 'nullable',
                'min_delivery_time' => 'nullable|numeric',
                'max_delivery_time' => 'nullable|numeric',
                'time_type'         => 'required|string|max:1'
            ]);
            $validData['freight'] = $this->unmaskMoney($validData['freight']);

            if( $validData['max_delivery_time'] < $validData['min_delivery_time'] )
                $this->throwException('O tempo máximo de entrega não pode ser menor que o mínimo');

            $updated = $this->servedDistrictService->updateById( $id, $validData);
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
        $this->gate('delete-serverd-district');
        try {

            $servedDistrict = $this->servedDistrictService->find($id);
            $this->authorize('update', $servedDistrict);

            $deleted = $this->servedDistrictService->deleteById( $id );
            $response = [ 'status' => 'success', 'data' => ($deleted) ];

        } catch ( ValidationException $e ){
            
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }

        return response()->json( $response );
    }

    /**
     * multiple delete
     * 
     * @return  json
     */
    public function multipleDelete( Request $request ){
        $this->gate('delete-serverd-district');
        try {
            DB::beginTransaction();
            $user = auth('api')->user();

            $data = $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'required|exists:served_districts,id',
            ]);

            foreach($data['ids'] as $id){
                $servedDistrict = $this->servedDistrictService->find($id);
                if($servedDistrict->id_user != $user->id)
                    $this->throwException("falha ao deletar local");

                $servedDistrict->delete();
            }

            $response = [ 'status' => 'success', 'data' => true ];
            DB::commit();

        } catch ( ValidationException $e ){
            DB::rollBack();
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }

        return response()->json( $response );
    }
}