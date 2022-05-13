<?php

namespace App\Http\Controllers;

use App\Services\PermissionService;
use App\Services\RoleService;
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

    public function __construct()
    {
        $this->roleService = new RoleService;    
        $this->permissionService = new PermissionService;    
    }

    protected function gate($slug, $attr=[]){
        if( Gate::denies($slug, $attr) )
            throw new HttpException(403, 'Ação não autorizada');
    }
}
