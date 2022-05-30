<?php 
 namespace App\Services;

use App\Models\FavoriteProduct;
use App\Models\Product;
use App\Models\User;
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
            'id_category' => $data['id_category'],
            'name'        => $data['name']??'',
            'description' => $data['description']??'',
            'brand'       => $data['brand']??1,
            'color'       => $data['color']??'',
            'model'       => $data['model']??'',
            'price'       => $data['price'],
            'guarantee'   => $data['guarantee']??0,
            'status'      => 'active'
        ];
        $product = $this->create($productData);
        $this->updateSlug($product);
        // upload files
        foreach( $images as $index => $image ){
            $this->productImageService->uploadImage($product, $image, intval($data['principal_image'])==$index);
        }

        // specs
        $this->specService->addProductSpecs($product, $data['specs']);

        // stock
        $this->stockLogService->entry($product, $data['qtd']);

        return $product;
    }
    

    /**
     * update category
     */
    public function updateCategory( Product $product, array $data ){

        $category = $this->categoryService->find( $data['id_category'] );

        if( !empty($category->linkable) )
            $this->throwException('Categoria inválida');

        $specErrors = $this->specService->validateRequiredSpecs($category, $data['specs']);
        if( !empty($specErrors) )
            $this->throwException($specErrors);

        $product->update(['id_category' => $category->id]);

        // remove current specs
        $this->specService->removeAllProductSpecs($product);
        
        // save all again
        $this->specService->addProductSpecs($product, $data['specs']);

        return $product;
    }

    /**
     * update specs
     */
    public function updateSpecs( Product $product, array $data ){

        $category = $product->category;

        if( !empty($category->linkable) )
            $this->throwException('Categoria inválida');

        $specErrors = $this->specService->validateRequiredSpecs($category, $data['specs']);
        if( !empty($specErrors) )
            $this->throwException($specErrors);

        // remove current specs
        $this->specService->removeAllProductSpecs($product);
        
        // save all again
        $this->specService->addProductSpecs($product, $data['specs']);

        return $product;
    }

    /**
     * update slug
     */
    public function updateSlug(Product $product){
        $slug = Str::slug($product->name.' '.$product->id);
        $product->update(['slug' => $slug]);
        return $slug;
    }


    /**
     * list solf products
     */
    public function listByUser(User $user, array $data){

        $filter = $this->model->join('categories AS cat', 'cat.id', 'products.id_category')
                              ->where('id_user', $user->id)
                              ->where('deleted', 0);


        if(!empty($data['term']) && $data['term'] != 'null'){
            $filter = $filter->where(function($where) use($data){
                $where->orWhere('products.name', 'like', "%{$data['term']}%")
                      ->orWhere('products.brand', 'like', "%{$data['term']}%")
                      ->orWhere('products.model', 'like', "%{$data['term']}%")
                      ->orWhere('cat.name', 'like', "%{$data['term']}%");
            });
        }

        return $filter->selectRaw('products.*')->get();
    }

    /**
     * set as deleted
     */
    public function deleteProduct(Product $product){

        
        FavoriteProduct::where('id_product', $product->id)->delete();
        $product->update(['deleted' => 1]);
        
        return true;
    }
}