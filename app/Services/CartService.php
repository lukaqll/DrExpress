<?php 
 namespace App\Services;

use App\Models\Cart;
use App\Models\ProductSpecItem;
use App\Models\Spec;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CartService extends AbstractService
{
    protected $model;

    private $productService;
    private $cartItemService;
    private $cartItemSpecService;

    public function __construct()
    {
        $this->model = new Cart;
        
        $this->productService = new ProductService;
        $this->cartItemService = new CartItemService;
        $this->cartItemSpecService = new CartItemSpecService;
    }


    /**
     * add item
     */
    public function addItem(User $user, array $data){

        $product = $this->productService->find($data['id_product']);

        if( empty($product) )
            $this->throwException('Falha ao adicionar ao carrinho');

        $category = $product->category;
        $seller = $product->user;

        // get/create cart
        $cart = $this->getCart($user, $seller);

        // create item
        $item = $this->cartItemService->create([
            'id_cart'    => $cart->id,
            'id_product' => $product->id,
            'amount'     => $data['amount']
        ]);

        $categorySpecs = Spec::where('id_category', $category->id)
                              ->where('is_multiple', 2)
                              ->get();

        foreach($categorySpecs as $spec){
            $isSpecOk = false;

            if( empty($data['specs']) )
                $this->throwException("Informe o campo {$spec->name} 1");

            foreach( $data['specs'] as $idSpec => $data ){
                if( $spec->id == $idSpec && !empty($data) )
                    $isSpecOk = true;
            }

            if( !$isSpecOk )
                $this->throwException("Informe o campo {$spec->name} 2");
        }

        // spec items
        if( !empty($data['specs']) && !empty($categorySpecs) ){

            foreach($data['specs'] as $idSpec => $data){

                $isSpecExists = DB::select("
                    select * from 
                        product_spec_items AS psi
                    join product_specs AS ps
                        on ps.id = psi.id_product_spec
                        and psi.name = :name
                    join specs sp
                        on sp on sp.id = ps.id_spec
                        and sp.id_category = :id_category
                ", [
                    ':name' => $data,
                    ':id_category' => $category->id
                ]);

                if( empty($isSpecExists) )
                    $this->throwException("Falha ao adicionar ao carrinho");

                $item->specs()->create([
                    'id_spec' => $idSpec,
                    'data' => $data
                ]);

            }
        }

        $this->throwException('teste');

        return $cart;
        
    }


    public function getCart(User $user, User $seller){

        $cart = $this->get([
            'id_user'   => $user->id,
            'id_seller' => $seller->id,
            'status'    => 'A',
            'deleted'   => 0
        ]);

        if( empty($cart) ){

            $cart = $this->create([
                'id_user'   => $user->id,
                'id_seller' => $seller->id,
                'status'    => 'A'
            ]);
        }

        return $cart;
    }
}