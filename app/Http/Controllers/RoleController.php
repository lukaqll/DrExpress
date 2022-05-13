<?php 

 namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RoleController extends Controller
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
        $this->gate('edit-user-role');
         
        try {
            $dataFilter = $request->all();
            $result = $this->roleService->list( $dataFilter, ['id'] );

            $response = [ 'status' => 'success', 'data' => RoleResource::collection($result) ];
            
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
            $result = $this->roleService->get( $dataFilter );
    
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

            $result = $this->roleService->get( ['id' => $id] );
            $response = [ 'status' => 'success', 'data' => new RoleResource($result) ];

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
                'name' => 'required|string|unique:roles',
                'slug' => 'required|string|unique:roles',
                'description' => 'nullable|string',
            ]);

            $validData['slug'] = Str::slug($validData['slug']);
            
            $created = $this->roleService->create( $validData );
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
                'name' => 'required|string|unique:roles,id,'.$id,
                'slug' => 'required|string|unique:roles,id,'.$id,
                'description' => 'nullable|string',

                'id_permissions' => 'nullable|array',
                'id_permissions.*' => 'nullable|numeric|exists:permissions,id',
            ]);
            $validData['slug'] = Str::slug($validData['slug']);

            $updated = $this->roleService->updateById( $id, $validData );
            
            $updated->permissions()->detach( $updated->idPermissions() );

            if( !empty($validData['id_permissions']) ){
                $updated->permissions()->attach($validData['id_permissions']);
            }

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

            $deleted = $this->roleService->deleteById( $id );
            $response = [ 'status' => 'success', 'data' => ($deleted) ];

        } catch ( ValidationException $e ){
            
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }

        return response()->json( $response );
    }

    /**
     * get role permissions
     */
    public function getRolePermissions($id){

        try {

            $role = $this->roleService->find($id);
            $result = $this->roleService->getRolePermissions($role);
            $response = [ 'status' => 'success', 'data' => ($result) ];

        } catch ( ValidationException $e ){
            
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }

        return response()->json( $response );
    }
}