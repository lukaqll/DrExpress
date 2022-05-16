<?php 

 namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SpecController extends Controller
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
    public function list( Request $request, $idCategory )
    {
        try {

            $result = $this->specService->list( ['id_category' => $idCategory], ['id'] );

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
            $result = $this->specService->get( $dataFilter );
    
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

            $result = $this->specService->get( ['id' => $id] );
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
    public function create( $idCategory, Request $request ){

        try {

            $validData = $request->validate([
                'name' => 'required|string|unique:specs,id_category,'.$idCategory,
                'is_required' => 'nullable',
            ]);
            
            $category = $this->categoryService->find($idCategory);
            if( !empty($category->likable) )
                throw ValidationException::withMessages(['Não é possível adicionar um especificação nesta categoria']);

            $validData['id_category'] = $idCategory;
            
            $created = $this->specService->create( $validData );
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
                'name' => 'required|string',
                'is_required' => 'nullable',
            ]);
            $updated = $this->specService->updateById( $id, $validData);
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

            $spec = $this->specService->find($id);
            foreach($spec->items as $item){
                if( !empty($item->products) && count($item->products) > 0 )
                    throw ValidationException::withMessages(['Existem produtos usando esta especificação, não é possível deletá-la']);
            }

            $spec->items()->delete();
            $deleted = $this->specService->deleteById( $id );

            $response = [ 'status' => 'success', 'data' => ($deleted) ];

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
    public function deleteItem( $id ){

        try {

            $item = $this->specItemService->find($id);
            if( !empty($item->products) && count($item->products) > 0 )
                throw ValidationException::withMessages(['Existem produtos usando este item, não é possível deletá-lo']);
            

            $deleted = $this->specItemService->deleteById( $id );
            
            $response = [ 'status' => 'success', 'data' => ($deleted) ];

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
    public function createItem( $idSpec, Request $request ){

        try {

            $validData = $request->validate([
                'name' => 'required|string|unique:spec_items,id_spec,'.$idSpec
            ]);
            $validData['id_spec'] = $idSpec;
            
            $created = $this->specItemService->create( $validData );
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
    public function updateItem( Request $request, $id ){

        try {
            
            $validData = $request->validate([
                'name' => 'required|string',
            ]);
            $updated = $this->specItemService->updateById( $id, $validData );
            $response = [ 'status' => 'success', 'data' => ($updated) ];

        } catch ( ValidationException $e ){
            
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }

        return response()->json( $response );
    }
}