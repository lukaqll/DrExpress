<?php 
 namespace App\Services;

use App\Models\Product;
use Illuminate\Validation\ValidationException;

class ProductService extends AbstractService
{
    protected $model;

    private $userService;
    private $productSpecService;
    private $productSpecItemService;
    private $categoryService;
    private $specService;
    private $specItemService;


    public function __construct()
    {
        $this->model = new Product;     
        
        $this->userService = new UserService;    
        $this->specService = new SpecService;    
        $this->specItemService = new SpecItemService;  
        $this->productSpecService = new ProductSpecService;    
        $this->productSpecItemService = new ProductSpecItemService;    
    }

    public function createProduct( array $data ){

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

        
    }

}