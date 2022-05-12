<?php 
 namespace App\Services;

use App\Models\Role;

class RoleService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new Role;       
    }

}