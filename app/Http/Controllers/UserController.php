<?php 

 namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\OperatorResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
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
        $this->gate('view-users');
        try {

            $dataFilter = $request->all();
            $result = $this->userService->listOperators();

            $response = [ 'status' => 'success', 'data' => OperatorResource::collection($result) ];
            
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
            $result = $this->userService->get( $dataFilter );
    
            $response = [ 'status' => 'success', 'data' => new OperatorResource($result) ];
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
    
            $response = [ 'status' => 'success', 'data' => new OperatorResource($result) ];
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
                'doc_number' => 'nullable|string|min:14',
                'birthdate' => 'nullable|string',
                'phone' => 'nullable|string|min:15',
                'picture' => 'nullable|image',
            ]);
            $updated = $this->userService->updateById( $user->id, $validData);
    
            $response = [ 'status' => 'success', 'data' => new OperatorResource($updated) ];
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
        $this->gate('view-users');
        try {

            $result = $this->userService->get( ['id' => $id] );
            $response = [ 'status' => 'success', 'data' => new OperatorResource($result) ];

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
        $this->gate('crate-users');
        try {

            DB::beginTransaction();

            $validData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|unique:users',
                'password' => 'required|string|min:6',
                'password_confirmation' => 'required|string|min:6',
                'doc_number' => 'nullable|string|min:14',
                'birthdate' => 'nullable|string',
                'phone' => 'nullable|string|min:15',
                'picture' => 'nullable|image',
            ]);
            
            $created = $this->userService->createOperator( $validData );
            $response = [ 'status' => 'success', 'data' => new OperatorResource($created) ];

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
        $this->gate('update-users');
        try {
            
            $validData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|unique:users,email,'.$id,
                'doc_number' => 'nullable|string',
                'birthdate' => 'nullable|string',
                'picture' => 'nullable|image',
                'phone' => 'nullable|string|min:15',

                'id_roles' => 'required|array',
                'id_roles.*' => 'required|numeric|exists:roles,id'
            ]);

            $updated = $this->userService->updateById( $id, $validData);

            $updated->roles()->detach( $updated->roles->pluck('id') );
            $updated->roles()->attach( $validData['id_roles'] );

            $response = [ 'status' => 'success', 'data' => new OperatorResource($updated) ];

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
        $this->gate('update-users');
        try {
            
            $validData = $request->validate([
                'password' => 'required|string|min:6',
                'password_confirmation' => 'required|string|min:6',
            ]);

            $this->userService->passwordValidation($validData);
            $updated = $this->userService->updateById( $id, ['password' => bcrypt($validData['password'])] );

            $response = [ 'status' => 'success', 'data' => new OperatorResource($updated) ];

        } catch ( ValidationException $e ){
            
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }

        return response()->json( $response );
    }
    
    /**
     * update self pass
     */
    public function updateMePassword( Request $request ){
        $this->gate('update-users');
        try {
            
            $user = auth('api')->user();
            $validData = $request->validate([
                'password' => 'required|string|min:6',
                'password_confirmation' => 'required|string|min:6',
            ]);

            $this->userService->passwordValidation($validData);
            $updated = $this->userService->updateById( $user->id, ['password' => bcrypt($validData['password'])] );

            $response = [ 'status' => 'success', 'data' => new OperatorResource($updated) ];

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
        $this->gate('update-users');
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