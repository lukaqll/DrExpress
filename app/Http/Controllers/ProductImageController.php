<?php 

 namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ProductImageController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * upload image
     * 
     * @return  json
     */
    public function uploadImage( Request $request, $id ){
        $this->gate('update-product');

        try {
            $user = auth('api')->user();
            $product = $this->productService->find($id);
            if($product->id_user != $user->id)
                throw new HttpException(403, 'Ação não autorizada');

            $validData = $request->validate([
                'images' => 'required|array',
                'images.*' => 'required|image',
            ]);

            foreach($validData['images'] as $file)
                $this->productImageService->uploadImage($product, $file);

            $response = [ 'status' => 'success', 'data' => true ];

        } catch ( ValidationException $e ){
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }

        return response()->json( $response );
    }

    /**
     * delete image
     * 
     * @return  json
     */
    public function removeImage( Request $request, $id ){
        $this->gate('update-product');

        try {
            $user = auth('api')->user();
            $product = $this->productService->find($id);
            if($product->id_user != $user->id)
                throw new HttpException(403, 'Ação não autorizada');
            $validData = $request->validate([
                'id' => 'required|exists:product_images,id'
            ]);
            $this->productImageService->removeImage($product, $validData['id']);
            $response = [ 'status' => 'success', 'data' => true ];

        } catch ( ValidationException $e ){
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }

        return response()->json( $response );
    }

    /**
     * delete image
     * 
     * @return  json
     */
    public function setPrincipalImage( Request $request, $id ){
        $this->gate('update-product');

        try {
            $user = auth('api')->user();
            $product = $this->productService->find($id);
            if($product->id_user != $user->id)
                throw new HttpException(403, 'Ação não autorizada');
            $validData = $request->validate([
                'id' => 'required|exists:product_images,id'
            ]);
            $this->productImageService->setPrincipalImage($product, $validData['id']);
            $response = [ 'status' => 'success', 'data' => true ];

        } catch ( ValidationException $e ){
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }

        return response()->json( $response );
    }

    
}