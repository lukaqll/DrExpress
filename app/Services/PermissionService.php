<?php 
 namespace App\Services;

use App\Models\Permission;

class PermissionService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new Permission;       
    }

}