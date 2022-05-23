<?php 

 namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class StockLogController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * entry
     * 
     * @return  json
     */
    public function entry( Request $request ){

        try {
            $this->gate('update-product');
            $validData = $request->validate([
                'amount' => 'required|numeric|min:1',
                'id_product' => 'required|exists:products,id',
            ]);
            $validData['type'] = 'E';
            
            $user = auth('api')->user();
            $product = $this->productService->find($validData['id_product']);
            if($product->id_user != $user->id)
                throw new HttpException(403, 'Ação não autorizada');

            $created = $this->stockLogService->create( $validData );
            $response = [ 'status' => 'success', 'data' => ($created) ];

        } catch ( ValidationException $e ){
            
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }

        return response()->json( $response );
    }

    /**
     * out
     * 
     * @return  json
     */
    public function out( Request $request ){

        try {
            $this->gate('update-product');
            $validData = $request->validate([
                'amount' => 'required|numeric|min:1',
                'id_product' => 'required|exists:products,id',
            ]);
            $validData['type'] = 'S';
            
            $user = auth('api')->user();
            $product = $this->productService->find($validData['id_product']);
            if($product->id_user != $user->id)
                throw new HttpException(403, 'Ação não autorizada');

            if( $validData['amount'] > $product->getAmount() )
                $this->throwException("Não é possível dar saída numa quantidade maior que a disponível");

            $created = $this->stockLogService->create( $validData );
            $response = [ 'status' => 'success', 'data' => ($created) ];

        } catch ( ValidationException $e ){
            
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }

        return response()->json( $response );
    }


}