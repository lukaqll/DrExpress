<?php

namespace App\Http\Controllers;

use App\Services\PermissionService;
use App\Services\RoleService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Gate;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $gate;
    protected $roleService;
    protected $permissionService;

    public function __construct()
    {
        $this->gate = new Gate;
        $this->roleService = new RoleService;    
        $this->permissionService = new PermissionService;    
    }
}
