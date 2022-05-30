<?php 

 namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCommerceResource;
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
            $result = $this->productService->listByUser($user, $dataFilter);

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

        $this->gate('update-product');
        $product = $this->productService->find($id);
        $this->authorize('update', $product);

        try {

            $response = [ 'status' => 'success', 'data' => new ProductResource($product) ];

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
        $product = $this->productService->find($id);
        $this->authorize('update', $product);

        try {
            DB::beginTransaction();
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
            $this->productService->updateSlug($updated);

            $response = [ 'status' => 'success', 'data' => ($updated) ];
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
    public function otherDataUpdate( Request $request, $id ){
        
        $this->gate('update-product');
        $product = $this->productService->find($id);
        $this->authorize('update', $product);

        try {
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
     * category update
     * 
     * @return  json
     */
    public function updateCategory( Request $request, $id ){
        
        $this->gate('update-product');
        $product = $this->productService->find($id);
        $this->authorize('update', $product);

        try {

            $validData = $request->validate([
                'id_category' => 'required|exists:categories,id',
                'specs' => 'nullable',
            ]);

            $updated = $this->productService->updateCategory( $product, $validData );
            $response = [ 'status' => 'success', 'data' => ($updated) ];

        } catch ( ValidationException $e ){
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }

        return response()->json( $response );
    }

    /**
     * specs update
     * 
     * @return  json
     */
    public function updateSpecs( Request $request, $id ){
        $this->gate('update-product');
        $product = $this->productService->find($id);
        $this->authorize('update', $product);

        try {

            $validData = $request->validate([
                'specs' => 'required|array',
            ]);

            $updated = $this->productService->updateSpecs( $product, $validData );
            $response = [ 'status' => 'success', 'data' => ($updated) ];

        } catch ( ValidationException $e ){
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }

        return response()->json( $response );
    }

    /**
     * toggle product status
     * 
     * @return  json
     */
    public function toggleStatus( $id ){
        $this->gate('update-product');
        $product = $this->productService->find($id);
        $this->authorize('update', $product);

        try {

            $toStatus = 'paused';
            if( $product->status == 'active' ){
                $toStatus = 'paused';
            } else {
                $toStatus = 'active';
            }

            $updated = $this->productService->updateById( $id, ['status' => $toStatus] );
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
        $this->gate('update-product');
        $product = $this->productService->find($id);
        $this->authorize('update', $product);

        try {

            DB::beginTransaction();
            if($product->status != 'paused')
                $this->throwException('O anúncio deve estar pausado para ser removido');

            $deleted = $this->productService->deleteProduct( $product );


            $response = [ 'status' => 'success', 'data' => ($deleted) ];
            DB::commit();
        } catch ( ValidationException $e ){
            DB::rollBack();
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }

        return response()->json( $response );
    }

    /**
     * get by slug
     */
   public function getBySlug( Request $request, $slug ){

       try {

           $dataFilter = $request->all();
           $dataFilter['slug'] = $slug;
           $result = $this->productService->get( $dataFilter );
   
           $response = [ 'status' => 'success', 'data' => new ProductCommerceResource($result) ];
       } catch ( ValidationException $e ){

           $response = [ 'status' => 'error', 'message' => $e->errors() ];
       }
       return response()->json( $response ); 
   }
}


