<?php 

 namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryTreeResource;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
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
            $result = $this->categoryService->list( $dataFilter, ['id'] );

            $response = [ 'status' => 'success', 'data' => ($result) ];
            
        } catch ( ValidationException $e ){

            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }
        return response()->json( $response );
    }

    /**
     * list all
     * 
     * @return  json
     */
    public function treeList( Request $request )
    {
        try {

            $result = $this->categoryService->treeList();

            $response = [ 'status' => 'success', 'data' => CategoryTreeResource::collection($result) ];
            
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
            $result = $this->categoryService->get( $dataFilter );
    
            $response = [ 'status' => 'success', 'data' => new CategoryResource($result) ];
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

            $result = $this->categoryService->get( ['id' => $id] );
            $response = [ 'status' => 'success', 'data' => new CategoryResource($result) ];

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
                'name' => 'required|string|unique:categories',
                'required_cro' => 'nullable',
                'id_category'  => 'nullable|numeric|exists:categories,id',
                'linkable'     => 'nullable',
            ]);

            if( empty($validData['id_category']) )
                $validData['linkable'] = 1;
            
            $created = $this->categoryService->create( $validData );
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
                'name' => 'required|string|unique:categories,id,'.$id,
                'required_cro' => 'nullable',
                'id_category'  => 'nullable|numeric|exists:categories,id',
                'linkable'     => 'nullable',
            ]);

            $category = $this->categoryService->find($id);

            // verify parent
            if( !empty($validData['id_category']) ){
                $parent = $this->categoryService->find($id);
                if( empty($parent->linkable) )
                    throw ValidationException::withMessages(['A categoria pai selecionada nã é linkável']);
            }

            // verify children
            if( !empty($category->children) && count($category->children) > 0 && empty($validData['linkable']) ){
                throw ValidationException::withMessages(['Esta categoria possui filhos, não é possível colocá-la como não linkável']);
            }

            // verify absolut linkable
            if( (empty($validData['linkable']) && empty($category->id_category)) || empty($validData['id_category']) ){
                $validData['linkable'] = 1;
            }

            $updated = $this->categoryService->updateById( $id, $validData);
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

            $deleted = $this->categoryService->deleteById( $id );
            $response = [ 'status' => 'success', 'data' => ($deleted) ];

        } catch ( ValidationException $e ){
            
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }

        return response()->json( $response );
    }
}