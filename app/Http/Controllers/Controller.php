<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\CityService;
use App\Services\DistrictService;
use App\Services\PermissionService;
use App\Services\ProductService;
use App\Services\RoleService;
use App\Services\SpecItemService;
use App\Services\SpecService;
use App\Services\UfService;
use App\Services\UserService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Gate;
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
    }

    protected function gate($slug, $attr=[]){
        if( Gate::denies($slug, $attr) )
            throw new HttpException(403, 'Ação não autorizada');
    }
}
