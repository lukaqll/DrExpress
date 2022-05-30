<?php 

 namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
    public function getById( $id ){

        try {

            $result = $this->cartService->get( ['id' => $id] );
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
            dd($created);
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
    public function update( Request $request, $id ){

        try {
            
            $validData = $request->validate([
                'name' => 'required|string|unique:table,name,'.$id,
            ]);
            $updated = $this->cartService->updateById( $id, $validData);
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

            $deleted = $this->cartService->deleteById( $id );
            $response = [ 'status' => 'success', 'data' => ($deleted) ];

        } catch ( ValidationException $e ){
            
            $response = [ 'status' => 'error', 'message' => $e->errors() ];
        }

        return response()->json( $response );
    }
}