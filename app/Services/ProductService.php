<?php 
 namespace App\Services;

use App\Models\Product;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
class ProductService extends AbstractService
{
    protected $model;

    private $userService;
    private $productSpecService;
    private $productSpecItemService;
    private $categoryService;
    private $specService;
    private $specItemService;
    private $stockLogService;
    private $productImageService;


    public function __construct()
    {
        $this->model = new Product;     
        
        $this->userService = new UserService;    
        $this->specService = new SpecService;    
        $this->specItemService = new SpecItemService;  
        $this->productSpecService = new ProductSpecService;    
        $this->productSpecItemService = new ProductSpecItemService;    
        $this->stockLogService = new StockLogService;    
        $this->productImageService = new ProductImageService;    
        $this->categoryService = new CategoryService;    
    }

    public function createProduct( array $data, array $images ){

        $user = auth('api')->user();

        $category = $this->categoryService->find( $data['id_category'] );

        if( !empty($category->linkable) )
            $this->throwException('Categoria inválida');

        $specErrors = $this->specService->validateRequiredSpecs($category, $data['specs']);
        if( !empty($specErrors) )
            $this->throwException($specErrors);
        
        if( empty($data['principal_image']) || $data['principal_image'] < 0 )
            $data['principal_image'] = 0;

        if( empty($data['qtd']) || $data['qtd'] < 0 )
            $data['qtd'] = 1;

        if( empty($data['price']) || $data['price'] <= 0 )
            $this->throwException('Informe um preço válido');

        // create product
        $productData = [
            'id_user'     => $user->id,
            'id_category'    => $data['id_category'],
            'name'        => $data['name']??'',
            'description' => $data['description']??'',
            'brand'       => $data['brand']??1,
            'color'       => $data['color']??'',
            'model'       => $data['model']??'',
            'price'       => $data['price'],
            'guarantee'   => $data['guarantee']??0
        ];
        $product = $this->create($productData);
        $slug = Str::slug($product->name.' '.$product->id);
        $product->update(['slug' => $slug]);

        // upload files
        foreach( $images as $index => $image ){
            $this->productImageService->uploadImage($product, $image, intval($data['principal_image'])==$index);
        }


        // specs
        foreach( $data['specs'] as $idSpec => $specItems ){
            
            // verify spec category
            $spec = $this->specService->find($idSpec);
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

        // stock
        $this->stockLogService->entry($product, $data['qtd']);

        return $product;
    }
    
}