<?php 
 namespace App\Services;

use App\Models\RolePermission;

class RolePermissionService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new RolePermission;       
    }

}