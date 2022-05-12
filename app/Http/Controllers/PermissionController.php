<?php 

 namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
class PermissionController extends Controller
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
            $result = $this->permissionService->list( $dataFilter, ['topic'] );

            $response = [ 'status' => 'success', 'data' => PermissionResource::collection($result) ];
            
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
            $result = $this->permissionService->get( $dataFilter );
    
            $response = [ 'status' => 'success', 'data' => new PermissionResource($result) ];
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

            $result = $this->permissionService->get( ['id' => $id] );
            $response = [ 'status' => 'success', 'data' => new PermissionResource($result) ];

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

        try {

            $validData = $request->validate([
                'name' => 'required|string|unique:permissions',
                'slug' => 'required|string|unique:permissions',
                'topic' => 'required|string',
                'description' => 'nullable|string',
            ]);
            $validData['slug'] = Str::slug($validData['slug']);
            $validData['active'] = 1;
            
            $created = $this->permissionService->create( $validData );
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

        try {
            
            $validData = $request->validate([
                'name' => 'required|string|unique:permissions,id,'.$id,
                'slug' => 'required|string|unique:permissions,id,'.$id,
                'topic' => 'required|string',
                'description' => 'nullable|string',
            ]);
            $validData['slug'] = Str::slug($validData['slug']);

            $updated = $this->permissionService->updateById( $id, $validData);
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

            $deleted = $this->permissionService->deleteById( $id );
            $response = [ 'status' => 'success', 'data' => ($deleted) ];

        } catch ( ValidationException $e ){
            
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }

        return response()->json( $response );
    }

    /**
     * get grouping by topic
     */
    public function getRolePermissions(){

        try {

            $deleted = $this->permissionService->getTopicGroup();
            $response = [ 'status' => 'success', 'data' => ($deleted) ];

        } catch ( ValidationException $e ){
            
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }

        return response()->json( $response );
    }
}