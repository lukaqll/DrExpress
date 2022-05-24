<?php

namespace App\Http\Controllers;

use App\Services\AddressService;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\CityService;
use App\Services\DistrictService;
use App\Services\PermissionService;
use App\Services\ProductImageService;
use App\Services\ProductService;
use App\Services\ProductSpecItemService;
use App\Services\ProductSpecService;
use App\Services\RoleService;
use App\Services\SpecItemService;
use App\Services\SpecService;
use App\Services\StockLogService;
use App\Services\UfService;
use App\Services\UserService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $roleService;
    protected $permissionService;
    protected $userService;
    protected $categoryService;
    protected $specService;
    protected $specItemService;
    protected $productService;
    protected $ufService;
    protected $cityService;
    protected $districtService;
    protected $addressService;
    protected $brandService;
    protected $productSpecService;
    protected $productSpecItemService;
    protected $stockLogService;
    protected $productImageService;

    public function __construct()
    {
        $this->roleService = new RoleService;    
        $this->permissionService = new PermissionService;    
        $this->userService = new UserService;    
        $this->categoryService = new CategoryService;    
        $this->specService = new SpecService;    
        $this->specItemService = new SpecItemService;    
        $this->productService = new ProductService;    
        $this->ufService = new UfService;    
        $this->cityService = new CityService;    
        $this->districtService = new DistrictService;    
        $this->addressService = new AddressService;    
        $this->brandService = new BrandService;    
        $this->productSpecService = new ProductSpecService;    
        $this->productSpecItemService = new ProductSpecItemService;    
        $this->stockLogService = new StockLogService;    
        $this->productImageService = new ProductImageService;    
    }

    protected function gate($slug, $attr=[]){
        if( Gate::denies($slug, $attr) )
            throw new HttpException(403, 'Ação não autorizada');
    }

    public function throwException($message=''){
        if( is_string($message) )
            throw ValidationException::withMessages([$message]);
        
        if( is_array($message) )
            throw ValidationException::withMessages($message);

        throw ValidationException::withMessages(['Ops... Houve um erro!']);
        
    }

    public function unmaskMoney($str = ''){

        if( empty($str) )
            return 0;

        if( is_int($str) || is_float($str) )
            return $str;

        $str = str_replace('.', '', $str);
        $str = str_replace(',', '.', $str);
        $str = str_replace('R$', '', $str);
        $str = str_replace('', '', $str);
        return floatval($str);
    }

    protected function cannot($slug, $class){
        // if( auth('api')->user()->cannot($slug, $class) )
        //     throw new HttpException(403, 'Ação não autorizada');
    }
}
