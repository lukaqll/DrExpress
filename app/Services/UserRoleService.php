<?php 
 namespace App\Services;

use App\Models\UserRole;

class UserRoleService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new UserRole;       
    }

}