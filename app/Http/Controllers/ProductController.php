<?php 

 namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ProductController extends Controller
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
    public function listMe( Request $request )
    {
        try {

            $user = auth('api')->user();

            $dataFilter = $request->all();
            $result = $this->productService->list( ['id_user' => $user->ud], ['id'], 'desc' );

            $response = [ 'status' => 'success', 'data' => ProductResource::collection($result) ];
            
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
            $result = $this->productService->get( $dataFilter );
    
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
    public function getMe( $id ){

        try {
            $user = auth('api')->user();
            $result = $this->productService->get( ['id' => $id] );

            if( $result->id_user != $user->id )
                throw new HttpException(403, 'Ação não autorizada');

            $response = [ 'status' => 'success', 'data' => new ProductResource($result) ];

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
        $this->gate('create-product');

        try {
            DB::beginTransaction();

            $data = json_decode($request->get('data'), true);
            $images = $request->file('images');

            $validator = Validator::make($data, [
                'id_category' => 'required|exists:categories,id',
                'name'        => 'required|string',
                'brand'       => 'required|string',
                'model'       => 'required|string',
                'price'       => 'required|string',
                'qtd'         => 'required|numeric|min:1',

                'color'       => 'nullable|string',
                'guarantee'   => 'nullable|numeric',
                'description' => 'nullable|string',
                'principal_image' => 'nullable|numeric',
                
                'specs'  => 'nullable|array',
            ]);
            
            $imagesValidator = Validator::make(['images' => $images], [
                'images' => 'required|array',
                'images.*' => 'required|image'
            ]);

            $validData = $validator->validate();
            $imagesData = $imagesValidator->validate();

            $validData['price'] = $this->unmaskMoney($validData['price']);

            $created = $this->productService->createProduct( $validData, $imagesData['images'] );
            $response = [ 'status' => 'success', 'data' => ($created) ];

            DB::commit();
        } catch ( ValidationException $e ){
            DB::rollBack();
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }

        return response()->json( $response );
    }

    /**
     * general update
     * 
     * @return  json
     */
    public function generalUpdate( Request $request, $id ){
        $this->gate('update-product');

        try {
            

            $user = auth('api')->user();
            $product = $this->productService->find($id);
            if($product->id_user != $user->id)
                throw new HttpException(403, 'Ação não autorizada');

            $validData = $request->validate([
                'name' => 'required|string|min:5',
                'brand' => 'required|string',
                'model' => 'required|string',
                'price' => 'required|string',
            ]);
            $validData['price'] = $this->unmaskMoney($validData['price']);

            if( empty($validData['price']) || $validData['price'] <= 0 )
                $this->throwException("informe um preço válido");

            $updated = $this->productService->updateById( $id, $validData );
            $response = [ 'status' => 'success', 'data' => ($updated) ];

        } catch ( ValidationException $e ){
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }

        return response()->json( $response );
    }

    /**
     * general update
     * 
     * @return  json
     */
    public function otherDataUpdate( Request $request, $id ){
        $this->gate('update-product');

        try {
            $user = auth('api')->user();
            $product = $this->productService->find($id);
            if($product->id_user != $user->id)
                throw new HttpException(403, 'Ação não autorizada');

            $validData = $request->validate([
                'color' => 'nullable|string',
                'guarantee' => 'nullable|numeric',
                'description' => 'nullable|string',
            ]);
            if( empty($validData['guarantee']) )
                $validData['guarantee'] = 0;

            $updated = $this->productService->updateById( $id, $validData );
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

            $deleted = $this->productService->deleteById( $id );
            $response = [ 'status' => 'success', 'data' => ($deleted) ];

        } catch ( ValidationException $e ){
            
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }

        return response()->json( $response );
    }
}