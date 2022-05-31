<?php 
 namespace App\Services;

use App\Models\CartItem;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSpec;
use App\Models\ProductSpecItem;
use App\Models\Spec;
use Illuminate\Support\Facades\DB;

class SpecService extends AbstractService
{
    protected $model;
    private $productSpecService;
    private $productSpecItemService;

    public function __construct()
    {
        $this->model = new Spec;       

        $this->productSpecService = new ProductSpecService;    
        $this->productSpecItemService = new ProductSpecItemService;    
    }

    public function validateRequiredSpecs( Category $category, array $specs ){

        $errors = [];
        foreach( $category->specs as $spec ){

            if( empty($spec->is_multiple) && is_array($specs[$spec->id]) && count($specs[$spec->id]) > 1 ){
                $errors[] = "Ĩnforme apenas um item em $spec->name";
            }

            if( !empty($spec->is_required) ){
                if( empty($specs[$spec->id]) )
                    $errors[] = "Ĩnforme o campo $spec->name";
            }
        }

        return $errors;
    }


    public function removeAllProductSpecs(Product $product){

        $productSpecs = ProductSpec::where('id_product', $product->id)->get();

        foreach($productSpecs as &$productSpec){
            
            // remove items
            ProductSpecItem::where('id_product_spec', $productSpec->id)->delete();
            $productSpec->delete();
        }

        return true;
    }

    public function addProductSpecs(Product $product, array $specs){

        $category = $product->category;

        foreach( $specs as $idSpec => $specItems ){
            
            if( empty($specItems) )
                continue;
                
            // verify spec category
            $spec = $this->find($idSpec);
            if( $spec->id_category != $category->id )
                $this->throwException("Falha ao atribuir a especificação $spec->name");

            $productSpec = $this->productSpecService->create([
                'id_product' => $product->id,
                'id_spec' => $idSpec
            ]);

            // add items
            if( is_array($specItems) ){
                foreach( $specItems as $specItem ){
                    $this->productSpecItemService->create([
                        'id_product_spec' => $productSpec->id,
                        'name' => $specItem
                    ]);
                }
            } else {
                $this->productSpecItemService->create([
                    'id_product_spec' => $productSpec->id,
                    'name' => $specItems
                ]);
            }
        }

        return true;
    }

    /**
     * validate specs on add product in cart
     */
    public function addCartItemSpecs(CartItem $cartItem, array $data){

        $product = $cartItem->product;

        // find selectable specs items
        $productSpecs = Spec::join('product_specs AS ps', function($join) use($product){
            $join->on('ps.id_spec', 'specs.id')
                 ->where('ps.id_product', $product->id);
        })->select('specs.*')
          ->where('specs.is_multiple', 2)
          ->get();

        // is specs empty
        if(!empty($productSpecs) && count($productSpecs)>0 && empty($data['specs'])){
            $firstSpec = $productSpecs[0];
            $this->throwException("Informe o campo {$firstSpec->name}");
        }

        $specs = $data['specs'];

        foreach($productSpecs as $productSpec){
            
            if( empty( $specs[ $productSpec->id ] ) )
                $this->throwException("Informe o campo {$productSpec->name}");
            
            // verify if sent spec data exists
            $isSpecExists = DB::select("
                select psi.* from 
                    product_spec_items AS psi
                join product_specs AS ps
                    on ps.id = psi.id_product_spec
                    and psi.name = :name
                    and ps.id_product = :id_product
                join specs sp
                    on sp.id = ps.id_spec
                    and sp.id_category = :id_category
            ", [
                ':name' => $specs[ $productSpec->id ],
                ':id_category' => $product->id_category,
                ':id_product' => $product->id,
            ]);

            if( empty($isSpecExists) )
                $this->throwException("Falha ao adicionar ao carrinho");
            
            // save cart item spec data
            $cartItem->specs()->create([
                'id_spec' => $productSpec->id,
                'data' => $specs[ $productSpec->id ]
            ]);
        }

        return true;
    }
}