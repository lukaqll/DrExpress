<?php 
 namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSpec;
use App\Models\ProductSpecItem;
use App\Models\Spec;

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
}