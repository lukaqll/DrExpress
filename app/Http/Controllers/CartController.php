<?php 

 namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Resources\CartSellerResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * get by id
     * 
     * @return  json
     */
    public function get(){

        $this->gate('view-cart');

        try {

            $user = auth('api')->user();

            // $result = $user->getCart();
            // $response = [ 'status' => 'success', 'data' => new CartResource($result) ];

            $result = $this->cartService->getFormatCart($user);
            $response = [ 'status' => 'success', 'data' => new CartSellerResource($result) ];
            

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
    public function addItem( Request $request ){
        
        $this->gate('create-cart');

        try {
            DB::beginTransaction();
            $user = auth('api')->user();

            $validData = $request->validate([
                'id_product' => 'required|exists:products,id',
                'amount' => 'required|numeric|min:1',

                'specs'  => 'nullable|array'
            ]);
            
            
            $created = $this->cartService->addItem( $user, $validData );
            $response = [ 'status' => 'success', 'data' => ($created) ];

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
    public function updateItemAmount( Request $request, $id ){
        $this->gate('update-cart');

        try {
            
            $user = auth('api')->user();

            $cartItem = $this->cartItemService->find($id);
            if( $cartItem->cart->id_user != $user->id )
                $this->throwException("Falha ao atualizar item");

            $validData = $request->validate([
                'handle' => 'nullable|string',
            ]);
            
            $amount = $cartItem->amount;
            if(!empty($validData['handle']) && $validData['handle'] == 'minus'){

                if( $amount > 1 )
                    $amount--;

            } else {
                if( $cartItem->product->getAmount() > $amount )
                    $amount++;
            }
            $updated = $this->cartItemService->updateById( $id, ['amount' => $amount]);

            $response = [ 'status' => 'success', 'data' => ($updated) ];

        } catch ( ValidationException $e ){
            
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }

        return response()->json( $response );
    }

    /**
     * delete item
     * 
     * @return  json
     */
    public function removeItem( $id ){
        $this->gate('update-cart');

        try {

            $user = auth('api')->user();
            $cartItem = $this->cartItemService->find($id);
            if( $cartItem->cart->id_user != $user->id )
                $this->throwException("Falha ao remove item");

            $cartItem->specs()->delete();
            $cartItem->update(['deleted' => 1]);

            $response = [ 'status' => 'success', 'data' => true ];

        } catch ( ValidationException $e ){
            
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }

        return response()->json( $response );
    }
}