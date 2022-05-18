<?php 

 namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\OperatorResource;
use App\Http\Resources\SellerResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SellerController extends Controller
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
        $this->gate('view-seller');
        try {

            $dataFilter = $request->all();
            $result = $this->userService->listSellers();

            $response = [ 'status' => 'success', 'data' => SellerResource::collection($result) ];
            
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

        $this->gate('view-seller');
        try {
            $dataFilter = $request->all();
            $result = $this->userService->get( $dataFilter );
            $response = [ 'status' => 'success', 'data' => new SellerResource($result) ];
        } catch ( ValidationException $e ){
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }
        return response()->json( $response ); 
    }

    /**
     * get self
     * 
     * @return  json
     */
    public function getMe(){

        try {
            $result = auth('api')->user();
            $response = [ 'status' => 'success', 'data' => new SellerResource($result) ];
        } catch ( ValidationException $e ){
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }
        return response()->json( $response ); 
    }

    /**
     * update self
     * 
     * @return  json
     */
    public function updateMe( Request $request ){

        try {
            $user = auth('api')->user();
            $validData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|unique:users,id,'.$user->id,
                'doc_number' => 'required|string|min:14|unique:users,id,'.$user->id,
                'doc_number' => 'nullable|string',
                'birthdate' => 'nullable|string',
                'phone' => 'nullable|string|min:15',   
                'id_city' => 'nullable|numeric|exists:cities,id',
                'cro' => 'nullable|string',
                'is_delivery' => 'nullable',
                'is_physical' => 'nullable',
            ]);
            $updated = $this->userService->updateById( $user->id, $validData);
            $response = [ 'status' => 'success', 'data' => new SellerResource($updated) ];
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
        $this->gate('view-seller');
        try {
            $result = $this->userService->get( ['id' => $id] );
            $response = [ 'status' => 'success', 'data' => new SellerResource($result) ];
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
        $this->gate('create-seller');
        try {
            DB::beginTransaction();
            $validData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|unique:users',
                'password' => 'required|string|min:6',
                'password_confirmation' => 'required|string|min:6',
                'doc_number' => 'required|string|min:14|unique:users',
                'cro' => 'nullable|string',
                'phone' => 'required|string|min:15',
                'birthdate' => 'nullable|string',
                'picture' => 'nullable|image',
                'is_delivery' => 'nullable',
                'is_physical' => 'nullable',

                'id_district' => 'nullable|numeric|exists:districts,id',
                'street'      => 'nullable|string|min:3',
                'number'      => 'nullable|string',
                'complement'  => 'nullable|string',
                'reference'   => 'nullable|string',
                'cep'         => 'nullable|string',
            ]);
            $created = $this->userService->createSeller( $validData );
            $response = [ 'status' => 'success', 'data' => new SellerResource($created) ];
            DB::commit();
        } catch ( ValidationException $e ){
            DB::rollBack();
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
        $this->gate('update-seller');
        try {
            
            $validData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|unique:users,id,'.$id,
                'doc_number' => 'required|string|min:14|unique:users,id,'.$id,
                'doc_number' => 'nullable|string',
                'birthdate' => 'nullable|string',
                'phone' => 'nullable|string|min:15',   
                'id_city' => 'nullable|numeric|exists:cities,id',
                'cro' => 'nullable|string',
                'is_delivery' => 'nullable',
                'is_physical' => 'nullable',

                'id_roles' => 'required|array',
                'id_roles.*' => 'required|numeric|exists:roles,id',
            ]);

            $updated = $this->userService->updateById( $id, $validData);

            $updated->roles()->detach( $updated->roles->pluck('id') );
            $updated->roles()->attach( $validData['id_roles'] );

            $response = [ 'status' => 'success', 'data' => new SellerResource($updated) ];

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
    public function updatePassword( Request $request, $id ){
        $this->gate('update-seller');
        try {
            
            $validData = $request->validate([
                'password' => 'required|string|min:6',
                'password_confirmation' => 'required|string|min:6',
            ]);

            $this->userService->passwordValidation($validData);
            $updated = $this->userService->updateById( $id, ['password' => bcrypt($validData['password'])] );

            $response = [ 'status' => 'success', 'data' => new SellerResource($updated) ];

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
    public function toggleStatus( $id ){
        $this->gate('update-seller');
        try {

            $user = $this->userService->find($id);
            $toStatus = 'I';
            if( $user->status == 'A' ){
                $toStatus = 'I';
            } else {
                $toStatus = 'A';
            }

            $user->update(['status' => $toStatus]);
            $response = [ 'status' => 'success', 'data' => ($user) ];

        } catch ( ValidationException $e ){
            
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }

        return response()->json( $response );
    }
}