<?php 
 namespace App\Services;

use App\Http\Resources\CartItemResource;
use App\Models\Cart;
use App\Models\CartItem;
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
    private $specService;

    public function __construct()
    {
        $this->model = new Cart;
        
        $this->productService = new ProductService;
        $this->cartItemService = new CartItemService;
        $this->cartItemSpecService = new CartItemSpecService;
        $this->specService = new SpecService;
    }


    /**
     * add item in cart
     */
    public function addItem(User $user, array $data){

        $product = $this->productService->find($data['id_product']);

        if( empty($product) )
            $this->throwException('Falha ao adicionar ao carrinho');

        if( $data['amount'] > $product->getAmount() )
            $this->throwException("Não possuem {$data['amount']} itens disponíveis deste produto");

        $seller = $product->user;
        $servedDistrict = $seller->districtServed();

        if( empty($servedDistrict) )
            $this->throwException('Este vendedor não atende à sua localidade');

        // get/create cart
        $cart = $this->getCart($user, $seller);

        // create item
        $cartItem = $cart->items()->create([
            'id_cart'    => $cart->id,
            'id_product' => $product->id,
            'amount'     => $data['amount']
        ]);

        $this->specService->addCartItemSpecs($cartItem, $data);

        return $cart;
    }

    /**
     * get or create a cart
     */
    public function getCart(User $user){

        $cart = $this->get([
            'id_user'   => $user->id,
            'status'    => 'A',
            'deleted'   => 0
        ]);

        if( empty($cart) ){

            $cart = $this->create([
                'id_user'   => $user->id,
                'status'    => 'A'
            ]);
        }

        return $cart;
    }

    /**
     * get formated cart
     */
    public function getFormatCart( User $user ){

        $cart = $this->getCart( $user );
        $sellers = $cart->getSellers();

        foreach($sellers as &$seller){
            $cartItems = $this->getCartItemsBySeller( $seller, $cart );
            $seller->cartItems = $cartItems;
        }
        
        $cart->sellers = $sellers;

        return $cart;
    }

    /**
     * get products by cart and seller
     */
    public function getCartItemsBySeller( User $seller, Cart $cart ){

        $result = CartItem::join('carts AS car', function($join) use($cart){
            $join->on('car.id', 'cart_items.id_cart')
                 ->where('car.id', $cart->id);
        })
        ->join('products AS prd', function($join) use($seller){
            $join->on('prd.id', 'cart_items.id_product')
                 ->where('prd.id_user', $seller->id)
                 ->where('cart_items.deleted', 0)
                 ->where('prd.deleted', 0);
        })
        ->groupBy('cart_items.id')
        ->select('cart_items.*')
        ->get();

        return $result;
    }
}